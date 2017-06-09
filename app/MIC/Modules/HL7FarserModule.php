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
      $this->baseUrl = 'https://hl7.cc/api';
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
    curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, false);
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

  ///////////////////////////////////////////////////////////////////////////////
  // Parse HL7 Message
  ///////////////////////////////////////////////////////////////////////////////
  public function parseHL7Message($message) {
    try {
      // Init
      $scope = $this->getHL7MessageParseInit($message);
      if (!$scope) { return false; }

      //loop through arrays and populate fieldData object with the assembleFieldData function
      // for ($q=0; $q<count($scope->segmentTypes); $q++) {
      //   $this->parseSegmentLine($scope, $q);
      // }
      
      return $scope;
    }
    catch(\Exception $e) {
      return false;
    }
  }

  public function getHL7MessageParseInit($message) {
    try {
      // Init
      $scope = new \stdClass;
      $scope->message = $message;

      $scope->segmentTypes = [];
      $fieldCount          = [];
      $scope->messageType  = '';
      $scope->fieldData    = [];
      $scope->segmentFields= [];
      $scope->components   = [];
      $scope->subcomponents= [];
      $scope->repeaters    = [];

      $scope->msgLines = explode("\n", trim($message));
      
      $msh_segment = $scope->msgLines[0];
      $msh_fields  = explode("|", $msh_segment);

      $scope->messageVersion = $msh_fields[11];
      $scope->messageType    = $msh_fields[8];

      // Array of segment names in message
      $segmentCount = count($scope->msgLines);
      for ( $c = 0; $c<$segmentCount; $c++) {
        $scope->msgLines[$c] = trim($scope->msgLines[$c]);
        $_fields = explode('|', $scope->msgLines[$c]);
        $scope->segmentTypes[$c] = (object)[
          'segmentName' => substr($scope->msgLines[$c], 0,3),
          'segmentId'   => $_fields[0] . $c
        ];
      }

      $segmentList = [];
      for ($d=0; $d<count($scope->segmentTypes); $d++) {
         $segmentList[] = $scope->segmentTypes[$d]->segmentName;
      }
      $scope->repeatingSegments = $this->getRepeatingSegments($segmentList);
      
      return $scope;
    }
    catch(\Exception $e) {
      return false;
    }
  }

  public function parseSegmentLine(&$scope, $index) {

    $fields = explode('|', $scope->msgLines[$index]);
    $fieldCount = count($fields);
    for ($m=0; $m<$fieldCount; $m++) {
      // declare some variables
      $segment = $fields[0];
      $fieldNum = $m;
      $segmentNum = $index;

      if ($segment === 'MSH') {
        if ($m === 0) {
          $fieldContents = '|';
        } else {
          $fieldContents = isset($fields[$m])? trim( $fields[$m] ) : '';
        }
      } else {
        $fieldContents = isset($fields[$m+1])? trim( $fields[$m+1] ) : '';
      }

      $this->assembleFieldData($scope, $segment, $fieldContents, $fieldNum, $segmentNum);
    }
  }

  ///////////////////////////////////////////////////////////////////////////////

  // Check for repeating segments
  public function getRepeatingSegments($arr) {
    $a = []; $b = []; $repeatingElements = []; $prev='';

    sort($arr);
    for ( $i = 0; $i < count($arr); $i++ ) {
      if ( $arr[$i] !== $prev ) {
          $a[] = $arr[$i];
          $b[] = 1;
      } else {
          $b[count($b)-1]++;
      }
      $prev = $arr[$i];
    }

    for ($j=0; $j<count($a); $j++) {
        if ($b[$j] > 1) {
          $repeatingElements[] = $a[$j];
        }
    }
    return $repeatingElements;
  }

  // function for getting the field descriptiions
  public function assembleFieldData(&$scope, $segment, $fieldContents, $fieldNum, $segmentNum) {

    if (empty($segment) || empty($fieldContents)) {
      return;
    } 

    // get segment and field info for getting field descriptions
    $segmentInfo = array(
      'fieldIndex'     => $fieldNum, 
      'messageVersion' => $scope->messageVersion,
      'messageType'    => $scope->messageType,
      'segment'        => $segment
    );

    // $http.get('/api/segment', { params: segmentInfo }).then(function(fieldDesc) {
    $fieldDesc = $this->getSegment($segmentInfo);

    if ($fieldDesc) {

      $segmentId = $segment . $segmentNum;

      if ($segment === 'MSH') {

        $mshSegment = (object)[
          'segment'         => $segment,
          'fieldNum'        => $fieldNum + 1,
          'fieldDescription'=> $fieldDesc,  // API
          'fieldContents'   => $fieldContents, 
          'fieldPanel'      => $fieldNum==1? false : $this->getFieldContentsPanel($fieldContents)
        ];

        $scope->fieldData[$segmentId][] = $mshSegment;
      } else if ( array_search($segment, $scope->repeatingSegments) !== FALSE ) {

        $repeatingSegment = (object)[
          'segment'         => $segment,
          'segmentId'       => $segmentId,
          'fieldNum'        => $fieldNum + 1,
          'fieldDescription'=> $fieldDesc,   // API
          'fieldContents'   => $fieldContents, 
          'fieldPanel'      => $this->getFieldContentsPanel($fieldContents)
        ];

        $scope->fieldData[$segmentId][] = $repeatingSegment;

      } else {

        $regularSegment = (object)[
          'segment'         => $segment,
          'fieldNum'        => $fieldNum + 1,
          'fieldDescription'=> $fieldDesc,  // API,
          'fieldContents'   => $fieldContents, 
          'fieldPanel'      => $this->getFieldContentsPanel($fieldContents)
        ];

        $scope->fieldData[$segmentId][] = $regularSegment;
      }
    } else {
      // Error 
    }
  }

  public function getFieldContentsPanel($fieldContents) {
    $b_panel = false;
    $panel = '';

    //////////////////// Fields
    $fields = explode('~', $fieldContents);
    if (count($fields) > 1) {
      $panel .= "<div class='fields-section'>";
    }

    $i_f = 0;
    foreach ($fields as $field) {
      $i_f++;
      $field = trim($field);
      if (empty($field)) { continue; }

      $panel .= "<div class='field-item'>";
      if (count($fields) > 1) {
        $panel .= $i_f. ".&nbsp;&nbsp;&nbsp;".$field;
      }
      ////////////////// Components
      $components = explode('^', $field);
      if (count($components) > 1) {
        $panel .= "<div class='components-section'>";
      }

      $i_c = 0;
      foreach ($components as $component) {
        $i_c++;
        $component = trim($component);
        if (empty($component)) { continue; }

        $panel .= "<div class='component-item'>";
        if (count($components) > 1) {
          $panel .= $i_c. ".&nbsp;&nbsp;&nbsp;".$component;
        }
        ///////////////// Sub Components
        $sub_coms = explode('&', $component);
        if (count($sub_coms) > 1) {
          $panel .= "<div class='sub-components-section'>";

          $i_s = 0;
          foreach ($sub_coms as $sub_com) {
            $i_s++;
            $sub_com = trim($sub_com);
            if (empty($sub_com)) { continue; }

            $panel .= "<div class='sub-component-item'>";
            $panel .= $i_s. ".&nbsp;&nbsp;&nbsp;".$sub_com;
            $panel .= "</div>";
          }
            
          $panel .= "</div>";
          $b_panel = true;
        } 
      }
      if (count($components) > 1) {
        $panel .= "</div>";
        $b_panel = true;
      }

      $panel .= "</div>";
    }

    if (count($fields) > 1) {
      $panel .= "</div>";
      $b_panel = true;
    }
    

    if ($b_panel) {
      return $panel;
    }
    return false;
  }
  ///////////////////////////////////////////////////////////////////////////////
}
