<?php
namespace App\Http\Controllers\MIC;

use Validator;
use DB;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\MIC\Models\User;
use App\MIC\Models\PaymentInfo;
use App\MIC\Models\YoutubeVideo;
use App\MIC\Models\VideoAccess;
use App\MIC\Models\VideoTracking;

use MICVideo;
use MICHelper;

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

  public function learningCenter(Request $request)
  {
    $user = MICHelper::currentUser();
    $video_all = MICVideo::getVideoList('all');

    $group = '';
    if (MICHelper::isPatient($user)) {
      $group = 'patient';
    }
    else if(MICHelper::isPartner($user)) {
      $group = MICHelper::getPartnerType($user->id);
    }
    if ($group) {
      $video_group = MICVideo::getVideoList($group);
    } else {
      $video_group = array();
    }

    $video_user = MICVideo::getVideoList('user', $user->id);

    $videos = array_merge($video_user, $video_group, $video_all);
    foreach ($videos as &$video) {
      if ($video->va->price) {
        if (MICVideo::checkPurchasedVideo($user->id, $video->id)) {
          $video->purchased = 1;
        } else {
          $video->purchased = 0;
        }
      }
      
      if ($vt = MICVideo::checkVideoWatched($user->id, $video->vid)) {
        $video->watched = $vt->updated_at;
      } else {
        $video->watched = 0;
      }
    }

    $params = array();
    $params['videos'] = $videos;
    $params['layout'] = MICHelper::layoutType($user);

    return view('mic.commons.video.learning_center', $params);
  }

  public function purchaseVideoPage(Request $request, $va_id) {
    $va = VideoAccess::find($va_id);
    $video = $va->video;
    $video->getVideoData();

    $currentUser = MICHelper::currentUser();
    $_user = User::find($currentUser->id);

    $params = array();
    $params['va'] = $va;
    $params['video'] = $video;

    $params['payment_info'] = ($_user->paymentInfo)? $_user->paymentInfo : new PaymentInfo;
    if (MICVideo::checkVideoPurchase($va)) {
      
    } else {
      $params['redirect'] = '_parent';
    }

    return view('mic.commons.video.purchase', $params);
  }

  public function purchaseVideo(Request $request, $va_id) {
    $user = MICHelper::currentUser();

    $va = VideoAccess::find($va_id);
    $price = $va->price;

    // Save Payment Information
    $validator = Validator::make($request->all(), [
      'payment_type'  => 'required', 
      'name_card'     => 'required', 
      'cc_number'     => 'required', 
      'exp'           => 'required', 
      'cid'           => 'required', 

      'address'       => 'required', 
      'city'          => 'required', 
      'state'         => 'required', 
      'zip'           => 'required'
    ]);

    if ($validator->fails()) {
      return redirect()->back()
                ->withErrors($validator)
                ->withInput();
    }
    
    $payment_info = $user->paymentInfo;
    if (!$payment_info ) 
    {
      $payment_info = new PaymentInfo;
      $payment_info->user_id = $user->id;
    }
    
    $payment_info->name_card   = $request->input('name_card');
    $payment_info->cc_number   = $request->input('cc_number');
    $payment_info->exp         = $request->input('exp');
    $payment_info->cid         = $request->input('cid');

    $payment_info->address     = $request->input('address');
    $payment_info->address2    = $request->input('address2');
    $payment_info->city        = $request->input('city');
    $payment_info->state       = $request->input('state');
    $payment_info->zip         = $request->input('zip');

    $payment_info->payment_type= $request->input('payment_type');

    $payment_info->save();

    // Purchase Video
    // TO DO: Charge 
    $comment = sprintf("Purchase youtube video(%s)", $va->video->vid);
    // MICPay::charge($user->id, $price, $comment);
    
    // TO DO : Uncomment after implementing of charge
    // MICVideo::insertPurchaseVideo($user->id, $va_id);

    return redirect()->route('learning_center.video.purchase', ['va_id'=>$va_id]);
  }

  public function trackVideo(Request $request) {
    $user = MICHelper::currentUser();

    $vid    = $request['vid'];
    $state  = $request['state'];

    $vt = MICVideo::getVideoTracking($user->id, $vid);
    if (!$vt) {
      $vt = new VideoTracking;
      $vt->user_id  = $user->id;
      $vt->vid = $vid;
    }
    $vt->state   = $state;
    $vt->save();

    return response()->json(['status' => 'success']);
  }
}
