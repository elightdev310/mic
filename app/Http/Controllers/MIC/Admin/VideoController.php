<?php
/**
 *
 */

namespace App\Http\Controllers\MIC\Admin;

use Auth;
use Validator;
use Mail;
use DB;
use Youtube;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\MIC\Facades\ClaimFacade as ClaimModule;

/**
 * Class IQuestionController
 * @package App\Http\Controllers\MIC\Admin
 */
class VideoController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    
  }

  public function videoList(Request $request)
  {
    try {
      $video = Youtube::getVideoInfo('i378uC4XERo');
    } catch(Exception $e) {
      print_r(123);
      print_r($e->getMessage());
    }

    exit;
    return 'video';
  }

}
