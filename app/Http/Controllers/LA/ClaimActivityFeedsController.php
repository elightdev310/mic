<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Models\ClaimActivityFeed;

class ClaimActivityFeedsController extends Controller
{
	public $show_action = true;
	public $view_col = 'claim_id';
	public $listing_cols = ['id', 'claim_id', 'feeder_uid', 'ca_id'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('ClaimActivityFeeds', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('ClaimActivityFeeds', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the ClaimActivityFeeds.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('ClaimActivityFeeds');
		
		if(Module::hasAccess($module->id)) {
			return View('la.claimactivityfeeds.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new claimactivityfeed.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created claimactivityfeed in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("ClaimActivityFeeds", "create")) {
		
			$rules = Module::validateRules("ClaimActivityFeeds", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("ClaimActivityFeeds", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.claimactivityfeeds.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified claimactivityfeed.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("ClaimActivityFeeds", "view")) {
			
			$claimactivityfeed = ClaimActivityFeed::find($id);
			if(isset($claimactivityfeed->id)) {
				$module = Module::get('ClaimActivityFeeds');
				$module->row = $claimactivityfeed;
				
				return view('la.claimactivityfeeds.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('claimactivityfeed', $claimactivityfeed);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("claimactivityfeed"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified claimactivityfeed.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("ClaimActivityFeeds", "edit")) {			
			$claimactivityfeed = ClaimActivityFeed::find($id);
			if(isset($claimactivityfeed->id)) {	
				$module = Module::get('ClaimActivityFeeds');
				
				$module->row = $claimactivityfeed;
				
				return view('la.claimactivityfeeds.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('claimactivityfeed', $claimactivityfeed);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("claimactivityfeed"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified claimactivityfeed in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("ClaimActivityFeeds", "edit")) {
			
			$rules = Module::validateRules("ClaimActivityFeeds", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("ClaimActivityFeeds", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.claimactivityfeeds.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified claimactivityfeed from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("ClaimActivityFeeds", "delete")) {
			ClaimActivityFeed::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.claimactivityfeeds.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax()
	{
		$values = DB::table('claimactivityfeeds')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('ClaimActivityFeeds');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/claimactivityfeeds/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("ClaimActivityFeeds", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/claimactivityfeeds/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("ClaimActivityFeeds", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.claimactivityfeeds.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
}
