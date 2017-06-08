<?php
/**
 *
 */

namespace App\Http\Controllers\MIC\HL7;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as FacadeResponse;
use Illuminate\Support\Facades\Input;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Helpers\LAHelper;
use Zizaco\Entrust\EntrustFacade as Entrust;

use App\MIC\Models\ClaimDoc;
use Auth;
use DB;
use File;
use Validator;
use Datatables;

use MICClaim;
use MICHL7Farser;
use MICHelper;
/**
 * Class FileController
 * @package App\Http\Controllers\MIC\HL7
 */
class HL7FarserController extends Controller
{
  public function claimDocMessageViewPanel(Request $request, $claim_id, $doc_id) {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);
    $doc = ClaimDoc::find($doc_id);
    if (!$claim && $doc && $doc->isHL7Message()) {
      return view('errors.404');
    }
    
    $data = MICHL7Farser::getSegment(array());
    $message = $doc->message;

    $params = array();
    $params['claim'] = $claim;
    $params['doc']   = $doc;

    /* Sample */
    $message =  "MSH|^~\&|ADT1|MCM|LABADT|MCM|198808181126|SECURITY|ADT^A04|MSG00001|P|2.4\n" .
                "EVN|A01-|198808181123\n" .
                "PID|||PATID1234^5^M11||JONES^WILLIAM^A^III||19610615|M-||2106-3|1200 N ELM STREET^^GREENSBORO^NC^27401-1020|GL|(919)379-1212|(919)271-3434~(919)277-3114||S||PATID12345001^2^M10|123456789|9-87654^NC\n" .
                "NK1|1|JONES^BARBARA^K|SPO|||||20011105\n" .
                "NK1|1|JONES^MICHAEL^A|FTH\n" .
                "PV1|1|I|2000^2012^01||||004777^LEBAUER^SIDNEY^J.|||SUR||-||1|A0-\n" .
                "AL1|1||^PENICILLIN||PRODUCES HIVES~RASH\n" .
                "AL1|2||^CAT DANDER\n" .
                "DG1|001|I9|1550|MAL NEO LIVER, PRIMARY|19880501103005|F||\n" .
                "PR1|2234|M11|111^CODE151|COMMON PROCEDURES|198809081123\n" .
                "ROL|45^RECORDER^ROLE MASTER LIST|AD|CP|KATE^SMITH^ELLEN|199505011201\n" .
                "GT1|1122|1519|BILL^GATES^A\n" .
                "IN1|001|A357|1234|BCMD|||||132987\n" .
                "IN2|ID1551001|SSN12345678\n" .
                "ROL|45^RECORDER^ROLE MASTER LIST|AD|CP|KATE^ELLEN|199505011201\n";

    $scope = $this->parseHL7Message($message);
    if ($scope) {
      $params['hl7'] = $scope;
    } else {
      $params['invalid_hl7_message'] = 'Invalid';
    }

    return view('mic.patient.claim.claim_doc_message_panel', $params);
  }

  ///////////////////////////////////////////////////////////////////////////////
  private function parseHL7Message($message) {
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

      $msgLines = explode("\n", $message);
      
      $msh_segment = $msgLines[0];
      $msh_fields  = explode("|", $msh_segment);

      $scope->messageVersion = $msh_fields[11];
      $scope->messageType    = $msh_fields[8];

      // Array of segment names in message
      $segmentCount = count($msgLines);
      for ( $c = 0; $c<$segmentCount; $c++) {
        $msgLines[$c] = trim($msgLines[$c]);
        $_fields = explode('|', $msgLines[$c]);
        $scope->segmentTypes[$c] = (object)[
          'segmentName' => substr($msgLines[$c], 0,3),
          'segmentId'   => $_fields[0] . $c
        ];
      }

      $segmentList = [];
      for ($d=0; $d<count($scope->segmentTypes); $d++) {
         $segmentList[] = $scope->segmentTypes[$d]->segmentName;
      }
      $scope->repeatingSegments = $this->getRepeatingSegments($segmentList);

      //loop through arrays and populate fieldData object with the assembleFieldData function
      $segment        = '';
      $fieldContents  = [];
      $fieldNum       = '';
      $segmentNum     = '';

      for ($q=0; $q<count($scope->segmentTypes); $q++) {
        $fields = explode('|', $msgLines[$q]);
        $fieldCount = count($fields);
        for ($m=0; $m<$fieldCount; $m++) {
          // declare some variables
          $segment = $fields[0];
          $fieldNum = $m;
          $segmentNum = $q;

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
      
      return $scope;
    }
    catch(\Exception $e) {
      return false;
    }
  }

  // Check for repeating segments
  private function getRepeatingSegments($arr) {
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
  private function assembleFieldData(&$scope, $segment, $fieldContents, $fieldNum, $segmentNum) {

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
    $fieldDesc = MICHL7Farser::getSegment($segmentInfo);
    if ($fieldDesc) {

      $segmentId = $segment . $segmentNum;

      if ($segment === 'MSH') {

        $mshSegment = (object)[
          'segment'         => $segment,
          'fieldNum'        => $fieldNum + 1,
          'fieldDescription'=> $fieldDesc,  // API
          'fieldContents'   => $fieldContents
        ];

        $scope->fieldData[$segmentId][] = $mshSegment;
      } else if ( array_search($segment, $scope->repeatingSegments) !== FALSE ) {

        $repeatingSegment = (object)[
          'segment'         => $segment,
          'segmentId'       => $segmentId,
          'fieldNum'        => $fieldNum + 1,
          'fieldDescription'=> $fieldDesc,   // API
          'fieldContents'   => $fieldContents
        ];

        $scope->fieldData[$segmentId][] = $repeatingSegment;

      } else {

        $regularSegment = (object)[
          'segment'         => $segment,
          'fieldNum'        => $fieldNum + 1,
          'fieldDescription'=> $fieldDesc,  // API,
          'fieldContents'   => $fieldContents
        ];

        $scope->fieldData[$segmentId][] = $regularSegment;
      }
    } else {
      // Error 
    }
  }

}
