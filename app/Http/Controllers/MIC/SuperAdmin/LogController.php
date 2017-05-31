<?php
/**
 *
 */

namespace App\Http\Controllers\MIC\SuperAdmin;

use Auth;
use Validator;
use Mail;
use DB;
use Activity;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\MIC\Models\YoutubeVideo;
use App\MIC\Models\VideoAccess;

/**
 * Class IQuestionController
 * @package App\Http\Controllers\MIC\Admin
 */
class LogController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */

  const PAGE_LIMIT = 50;

  public function __construct()
  {
    
  }

  public function historyLogin(Request $request)
  {
    
    $logs = Activity::where('action', 'login')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(self::PAGE_LIMIT);

    $params = array();
    $params['logs'] = $logs;
    
    return view('mic.superadmin.history.login_history', $params);
  }

}
