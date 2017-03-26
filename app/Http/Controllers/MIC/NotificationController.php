<?php
namespace App\Http\Controllers\MIC;

use Validator;
use DB;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use Illuminate\Support\Facades\View;

use App\MIC\Models\Notification;

use MICHelper;
use MICNotification;


/**
 * Class IQuestionController
 * @package App\Http\Controllers\MIC
 */
class NotificationController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  const PAGE_LIMIT = 25;

  public function __construct()
  {
    
  }

  public function listPage() {
    $user = MICHelper::currentUser();

    $list = Notification::where('user_id', $user->id)
              ->orderBy('created_at', 'DESC')
              ->paginate(self::PAGE_LIMIT);
    
    foreach ($list as &$noti) {
      if (!$noti->read) {
        $noti->markRead();
      }
    }
      
    $params['layout'] = MICHelper::layoutType($user);
    $params['notifications'] = $list;

    return view('mic.commons.notification.list', $params);
  }

  public function deleteNotification(Request $request, $noti_id) {
    $noti = Notification::find($noti_id);
    if ($noti) {
      $noti->forceDelete();
    }
    return response()->json([
        "status" => "success",
      ], 200);
  }

  public function userNotifyList() {
    $user = MICHelper::currentUser();

    $noti_html = '';
    if ($user) {
      $limit = 5;
      $list = Notification::where('user_id', $user->id)
              ->orderBy('created_at', 'DESC')
              ->paginate(5);
      foreach ($list as &$noti) {
        if (!$noti->read) {
          $noti->markRead();
        }
      }
      $params = array(
          'notify_list' => $list
        );
      $view = View::make('mic.commons.notification.partials.notify_list', $params);
      $noti_html = $view->render();

      $count = MICNotification::getUnreadCount($user->id);
    }

    return response()->json(['notify_html' => $noti_html, 'count'=>$count]);
  }
}
