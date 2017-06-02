<?php
/**
 *
 */

namespace App\Http\Controllers\MIC;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as FacadeResponse;
use Illuminate\Support\Facades\Input;
use Collective\Html\FormFacade as Form;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Helpers\LAHelper;
use Zizaco\Entrust\EntrustFacade as Entrust;

use Auth;
use DB;
use File;
use Validator;
use Datatables;

use App\Models\Upload;

use MICClaim;
use MICHelper;
/**
 * Class FileController
 * @package App\Http\Controllers\MIC
 */
class FileController extends Controller
{
  /**
   * 
   * Clone of UploadController@get_file function
   * Check Claim File Access
   * 
   * @return \Illuminate\Http\Response
   */
  public function get_file($hash, $name)
  {
      $upload = Upload::where("hash", $hash)->first();
      
      // Validate Upload Hash & Filename
      if(!isset($upload->id) || $upload->name != $name) {
          return response()->json([
              'status' => "failure",
              'message' => "Unauthorized Access 1"
          ]);
      }

      if($upload->public == 1) {
          $upload->public = true;
      } else {
          $upload->public = false;
      }

      // Validate if Image is Public
      if(!$upload->public && !isset(Auth::user()->id)) {
          return response()->json([
              'status' => "failure",
              'message' => "Unauthorized Access 2",
          ]);
      }

      if( Entrust::hasRole('SUPER_ADMIN') || 
          Entrust::hasRole(config('mic.user_role.admin')) ||
          Entrust::hasRole(config('mic.user_role.case_manager')) ||
          Auth::user()->id == $upload->user_id || 
          MICClaim::accessibleClaimFile($upload) ) 
      {
          $path = $upload->path;

          if(!File::exists($path))
              abort(404);
          
          // Check if thumbnail
          $size = Input::get('s');
          if(isset($size)) {
              if(!is_numeric($size)) {
                  $size = 150;
              }
              $thumbpath = storage_path("thumbnails/".basename($upload->path)."-".$size."x".$size);
              
              if(File::exists($thumbpath)) {
                  $path = $thumbpath;
              } else {
                  // Create Thumbnail
                  LAHelper::createThumbnail($upload->path, $thumbpath, $size, $size, "transparent");
                  $path = $thumbpath;
              }
          }

          $file = File::get($path);
          $type = File::mimeType($path);

          $download = Input::get('download');
          if(isset($download)) {
              // Activity 
              $user = MICHelper::currentUser();
              $doc = MICClaim::isClaimDoc($upload->id);
              if ($doc) {
                $claim = $doc->claim;
                $desc = $user->name." downloaded document of claim #{$claim->id}";
                if ($doc->isBillingDoc()) {
                  $desc = $user->name." downloaded billing document of claim #{$claim->id}";
                }
                MICHelper::logActivity([
                  'userId'      => $user->id,
                  'contentId'   => $doc->id,
                  'contentType' => 'ClaimDoc',
                  'action'      => 'download',
                  'description' => $desc,
                  'details'     => 'Claim: '.$claim->id,
                ]); 
              }

              return response()->download($path, $upload->name);
          } else {
              $response = FacadeResponse::make($file, 200);
              $response->header("Content-Type", $type);
          }
          
          return $response;
      } else {
          return response()->json([
              'status' => "failure",
              'message' => "Unauthorized Access 3"
          ]);
      }
  }


}
