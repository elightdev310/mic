<?php
/**
 * Using by ClaimController genrated using Kevin
 * 
 */

namespace App\Http\Controllers\MIC\Patient;

use Illuminate\Http\Request;
use Auth;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use App\MIC\Facades\ClaimFacade as ClaimModule;
use App\MIC\Helpers\MICHelper;

use App\User;
use App\MIC\Models\Claim;
use App\MIC\Models\ClaimPhoto;
use App\Models\Upload;

trait PatientClaimController
{
  /**
   * GET: myclaims
   */
  public function myClaimsPage(Request $request) {
    $user = MICHelper::currentUser();
    $claims = Claim::where('patient_uid', $user->id)
                    ->paginate(self::PAGE_LIMIT);

    $params = array();
    $params['claims'] = $claims;
    return view('mic.patient.claim.myclaims', $params);
  }

  /**
   * Get: patient/claim/{claim_id}
   */
  public function patientClaimPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = Claim::where('id', $claim_id)
                  ->where('patient_uid', $user->id)
                  ->first();
    if (!$claim) {
      return view('errors.404');
    }

    // IOI
    $answers = $claim->getAnswers();
    $questions = ClaimModule::getIQuestionsByAnswers($answers);
    
    // Photo
    $photos = ClaimModule::getClaimPhotos($claim_id);

    // Doc
    $docs = ClaimModule::getClaimDocs($claim_id, $user->id);

    $params = array();
    $params['user'] = $user;
    $params['claim'] = $claim;
    $params['questions'] = $questions;
    $params['answers'] = $answers;
    $params['photos'] = $photos;
    $params['docs'] = $docs;

    return view('mic.patient.claim.page', $params);
  }


  /**
   * Upload Photos
   */
  public function patientUploadPhoto(Request $request, $claim_id) {
    if(Input::hasFile('file')) {

      $file = Input::file('file');
      
      // print_r($file);
      //$this->createClaimFolder($claim_id, 'photos');
      $folder = storage_path("claims/photos/".$claim_id);
      $upload = $this->uploadClaimFile($file, $folder);

      if( $upload ) {
        $photo = ClaimPhoto::create([
          'claim_id' => $claim_id,
          'file_id'  => $upload->id, 
        ]);
        $photo->save();

        // TO DO: Notify to Upload Photo

        return response()->json([
          "status" => "success",
          "upload" => $upload
        ], 200);
      } else {
        return response()->json([
          "status" => "error"
        ], 400);
      }
    } else {
      return response()->json('error: upload file not found.', 400);
    }
  }

  public function patientDeletePhoto(Request $request, $claim_id, $photo_id) {
    $photo = ClaimPhoto::where('id', $photo_id)
                       ->where('claim_id', $claim_id)
                       ->first();
    if ($photo) {
      $upload = Upload::find($photo->file_id);
      if ($upload) {
        unlink($upload->path);
        $upload->forceDelete();
      }
      $photo->forceDelete();
    }

    return response()->json([
        "status" => "success",
      ], 200);
  }
  public function claimPhotoList(Request $request, $claim_id)
  {
    $claim = Claim::find($claim_id);
    $photos = ClaimModule::getClaimPhotos($claim_id);
    $view = View::make('mic.patient.claim.partials.photo_list', ['claim'=>$claim, 'photos'=>$photos]);
    $photo_list = $view->render();

    return response()->json(['photo_html' => $photo_list]);
  }
}
