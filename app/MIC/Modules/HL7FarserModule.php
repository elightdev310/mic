<?php

namespace App\MIC\Modules;

use DB;
use Auth;

use App\MIC\Models\User;
use App\User as UserModel;

use MICHelper;

class HL7FarserModule {
  /**
   * Laravel application
   *
   * @var \Illuminate\Foundation\Application
   */
  public $app;

  /**
   * Create a new confide instance.
   *
   * @param \Illuminate\Foundation\Application $app
   *
   * @return void
   */
  protected $baseUrl;

  public function __construct($app)
  {
      $this->app = $app;
      $this->baseUrl = 'http://hl7.cc/api';
  }

  /**
   * URL Sample : /api/segment?fieldIndex=8&messageType=ADT%5EA04&messageVersion=2.4&segment=MSH
   */
  public function getSegment($params) {
    $url = $this->baseUrl."/segment?".http_build_query($params);
    
    // $aContext = array(
    //   'http' => array(
    //     'method'=>"GET",
    //   ),
    // );
    // $cxContext = stream_context_create($aContext);
    //$result = file_get_contents($url, False, $cxContext);
    
    $curlSession = curl_init();
    curl_setopt($curlSession, CURLOPT_URL, $url);
    curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($curlSession);
    curl_close($curlSession);

    if ($result) {
      return json_decode($result);
    } else {
      return false;
    }
  }
}
