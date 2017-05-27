<?php

namespace App\Http\Controllers\MIC;


use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class QuickBookController extends Controller
{

  private $IntuitAnywhere;
  private $context;
  private $realm;

  public function __construct() {
    if (!\QuickBooks_Utilities::initialized(env('QBO_DSN'))) {
      // Initialize creates the neccessary database schema for queueing up requests and logging
      \QuickBooks_Utilities::initialize(env('QBO_DSN'));
    }
    $this->IntuitAnywhere = new \QuickBooks_IPP_IntuitAnywhere(
                                    env('QBO_DSN'), 
                                    env('QBO_ENCRYPTION_KEY'), 
                                    env('QBO_OAUTH_CONSUMER_KEY'), 
                                    env('QBO_CONSUMER_SECRET'), 
                                    env('QBO_OAUTH_URL'), 
                                    env('QBO_SUCCESS_URL') );
  }
  public function  qboConnect(){


    if ($this->IntuitAnywhere->check(env('QBO_USERNAME'), env('QBO_TENANT')) && 
        $this->IntuitAnywhere->test(env('QBO_USERNAME'), env('QBO_TENANT'))) {
      // Set up the IPP instance
      $IPP = new \QuickBooks_IPP(env('QBO_DSN'));
      // Get our OAuth credentials from the database
      $creds = $this->IntuitAnywhere->load(env('QBO_USERNAME'), env('QBO_TENANT'));
      dd($creds);
      // Tell the framework to load some data from the OAuth store
      $IPP->authMode(
        \QuickBooks_IPP::AUTHMODE_OAUTH,
        env('QBO_USERNAME'),
        $creds);

      if (env('QBO_SANDBOX')) {
        // Turn on sandbox mode/URLs
        $IPP->sandbox(true);
      }
      // This is our current realm
      $this->realm = $creds['qb_realm'];
      // Load the OAuth information from the database
      $this->context = $IPP->context();

      return true;
    } else {
      return false;
    }
  }

  public function qboOauth(){
    if ($this->IntuitAnywhere->handle(env('QBO_USERNAME'), env('QBO_TENANT')))
    {
      ; // The user has been connected, and will be redirected to QBO_SUCCESS_URL automatically.
    }
    else
    {
      // If this happens, something went wrong with the OAuth handshake
      die('Oh no, something bad happened: ' . $this->IntuitAnywhere->errorNumber() . ': ' . $this->IntuitAnywhere->errorMessage());
    }
  }

  public function qboSuccess(){
    return view('qbo_success');
  }

  public function qboDisconnect(){
    $this->IntuitAnywhere->disconnect(env('QBO_USERNAME'), env('QBO_TENANT'),true);
    return redirect()->intended("/admin/qbo/connection");// afer disconnect redirect where you want
 
  }

  public function qboConnection() {
    return view('mic.admin.quickbook.connection');
  }
  public function test(){

    //$CompanyInfoService = new \QuickBooks_IPP_Service_CompanyInfo();
    $report = new \QuickBooks_IPP_Service_Report_ProfitAndLoss();
    if ($quickbooks_CompanyInfo = $report->report($this->context, $this->realm))
    {
      return $quickbooks_CompanyInfo;
    }
    else
    {
      //echo 'Not Added qbo';
      print($CustomerService->lastError($this->context));
    }
  }

  public function getId($resp){
    $resp = str_replace('{','',$resp);
    $resp = str_replace('}','',$resp);
    $resp = abs($resp);
    return $resp;
  }  

}
