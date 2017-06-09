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
use Illuminate\Support\Facades\View;

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
  public function claimDocMessageSegmentPanel(Request $request, $claim_id, $doc_id) {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);
    $doc = ClaimDoc::find($doc_id);

    try {
      if (!$claim && $doc && $doc->isHL7Message() && $request->has('segment')) {
        throw new \Exception();
      }

      $seg_index = $request->input('segment');

      $message = $doc->message;

      $params = array();
      $params['claim'] = $claim;
      $params['doc']   = $doc;
      $params['message'] = $message;

      /* Sample */
      // $message =  "MSH|^~&|ADT1|MCM|LABADT|MCM|198808181126|SECURITY|ADT^A04|MSG00001|P|2.4\n" .
      //             "EVN|A01-|198808181123\n" .
      //             "PID|||PATID1234^5^M11||JONES^WILLIAM^A^III||19610615|M-||2106-3|1200 N ELM STREET^^GREENSBORO^NC^27401-1020|GL|(919)379-1212|(919)271-3434~(919)277-3114||S||PATID12345001^2^M10|123456789|9-87654^NC\n" .
      //             "NK1|1|JONES^BARBARA^K|SPO|||||20011105\n" .
      //             "NK1|1|JONES^MICHAEL^A|FTH\n" .
      //             "PV1|1|I|2000^2012^01||||004777^LEBAUER^SIDNEY^J.|||SUR||-||1|A0-\n" .
      //             "AL1|1||^PENICILLIN||PRODUCES HIVES~RASH\n" .
      //             "AL1|2||^CAT DANDER\n" .
      //             "DG1|001|I9|1550|MAL NEO LIVER, PRIMARY|19880501103005|F||\n" .
      //             "PR1|2234|M11|111^CODE151|COMMON PROCEDURES|198809081123\n" .
      //             "ROL|45^RECORDER^ROLE MASTER LIST|AD|CP|KATE^SMITH^ELLEN|199505011201\n" .
      //             "GT1|1122|1519|BILL^GATES^A\n" .
      //             "IN1|001|A357|1234|BCMD|||||132987\n" .
      //             "IN2|ID1551001|SSN12345678\n" .
      //             "ROL|45^RECORDER^ROLE MASTER LIST|AD|CP|KATE^ELLEN|199505011201\n";

    
      // Init
      $scope = MICHL7Farser::getHL7MessageParseInit($message);
      if (!$scope) { throw new \Exception(); }

      $segment = $scope->segmentTypes[$seg_index];
      MICHL7Farser::parseSegmentLine($scope, $seg_index);
      
      $params['hl7'] = $scope;
      $params['segment'] = $segment;
    }
    catch(\Exception $e) {
      $params['invalid_hl7_segment'] = 'Invalid';
    }

    if ($scope) {
      $params['hl7'] = $scope;
    } else {
      $params['invalid_hl7_message'] = 'Invalid';
    }

    $view = View::make('mic.patient.claim.partials.doc_message_segment', $params);
    $segment_panel = $view->render();

    return response()->json(['segment_html' => $segment_panel]);
  }

  public function claimDocMessageViewPanel(Request $request, $claim_id, $doc_id) {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);
    $doc = ClaimDoc::find($doc_id);
    if (!$claim && $doc && $doc->isHL7Message()) {
      return view('errors.404');
    }

    $message = $doc->message;

    $params = array();
    $params['claim'] = $claim;
    $params['doc']   = $doc;
    $params['hl7_message'] = $message;
    /* Sample */
    // $message =  "MSH|^~&|ADT1|MCM|LABADT|MCM|198808181126|SECURITY|ADT^A04|MSG00001|P|2.4\n" .
    //             "EVN|A01-|198808181123\n" .
    //             "PID|||PATID1234^5^M11||JONES^WILLIAM^A^III||19610615|M-||2106-3|1200 N ELM STREET^^GREENSBORO^NC^27401-1020|GL|(919)379-1212|(919)271-3434~(919)277-3114||S||PATID12345001^2^M10|123456789|9-87654^NC\n" .
    //             "NK1|1|JONES^BARBARA^K|SPO|||||20011105\n" .
    //             "NK1|1|JONES^MICHAEL^A|FTH\n" .
    //             "PV1|1|I|2000^2012^01||||004777^LEBAUER^SIDNEY^J.|||SUR||-||1|A0-\n" .
    //             "AL1|1||^PENICILLIN||PRODUCES HIVES~RASH\n" .
    //             "AL1|2||^CAT DANDER\n" .
    //             "DG1|001|I9|1550|MAL NEO LIVER, PRIMARY|19880501103005|F||\n" .
    //             "PR1|2234|M11|111^CODE151|COMMON PROCEDURES|198809081123\n" .
    //             "ROL|45^RECORDER^ROLE MASTER LIST|AD|CP|KATE^SMITH^ELLEN|199505011201\n" .
    //             "GT1|1122|1519|BILL^GATES^A\n" .
    //             "IN1|001|A357|1234|BCMD|||||132987\n" .
    //             "IN2|ID1551001|SSN12345678\n" .
    //             "ROL|45^RECORDER^ROLE MASTER LIST|AD|CP|KATE^ELLEN|199505011201\n";

    $scope = MICHL7Farser::parseHL7Message($message);

    if ($scope) {
      $params['hl7'] = $scope;
      // dump($scope);
    } else {
      $params['invalid_hl7_message'] = 'Invalid';
    }

    return view('mic.patient.claim.claim_doc_message_panel', $params);
  }

  
}
