<?php

namespace App\MIC\Modules;

use DB;
use Auth;

use App\Models\Upload;
use App\MIC\Models\IQuestion;
use App\MIC\Models\Claim;
use App\MIC\Models\User;
use App\MIC\Models\Partner2Claim;
use App\MIC\Models\ClaimPhoto;
use App\MIC\Models\ClaimDoc;
use App\MIC\Models\ClaimDocAccess;
use App\User as UserModel;

class ClaimModule {
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
  public function __construct($app)
  {
      $this->app = $app;
  }

  public function getIQuestions()
  {
    $i_questions = IQuestion::orderBy('weight', 'ASC')->orderBy('id', 'ASC')->get();

    return $i_questions;
  }

  public function getIQuestion($id) {
    $i_quiz = IQuestion::withTrashed()
                ->find($id);
    return $i_quiz;
  }
  public function getIQuestionsByAnswers($answers) {
    $ids = array_keys($answers);

    $i_questions = IQuestion::withTrashed()
                      ->whereIn('id', $ids)
                      ->orderBy('weight', 'ASC')
                      ->orderBy('id', 'ASC')
                      ->get();

    return $i_questions; 
  }


  public function insertP2C($partner_uid, $claim_id) {
    $p2c = new Partner2Claim;
    $p2c->partner_uid = $partner_uid;
    $p2c->claim_id    = $claim_id;
    $p2c->save();
  }
  public function removeP2C($partner_uid, $claim_id) {
    $p2c = Partner2Claim::where('partner_uid', $partner_uid)
                  ->where('claim_id', $claim_id)
                  ->first();
    if ($p2c) {
      $p2c->forceDelete();
    }
  }
  public function checkP2C($partner_uid, $claim_id) {
    $p2c = Partner2Claim::where('partner_uid', $partner_uid)
                  ->where('claim_id', $claim_id)
                  ->first();
    if ($p2c) {
      return true;
    }
    return false;
  }
  public function getPartnersByClaim($claim_id) {
    $p2cs = Partner2Claim::where('claim_id', $claim_id)->get();
    $uids = array();
    foreach ($p2cs as $p2c) {
      $uids[] = $p2c->partner_uid;
    }
    $u_partners = User::find($uids);

    return $u_partners;
  }

  public function getClaimsByPartner($partner_uid) {
    $p2cs = Partner2Claim::where('partner_uid', $partner_uid)->get();
    $claim_ids = array();
    foreach ($p2cs as $p2c) {
      $claim_ids[] = $p2c->claim_id;
    }
    $claims = Claim::find($claim_ids);

    return $claims;
  }

  public function getClaimPhotos($claim_id) {
    $photos = ClaimPhoto::where('claim_id', $claim_id)
                        ->orderBy('id', 'ASC')
                        ->get();
    return $photos;
  }

  public function getCDAdocs($uid) {
    $data = array();
    $cda = ClaimDocAccess::where('partner_uid', $uid)->get();
    foreach ($cda as $item) {
      $data[] = $item->doc_id;
    }
    return $data;
  }

  public function getClaimDocs($claim_id, $uid) {
    $user = UserModel::find($uid);
    $docs = array();

    if ($user->can(config('mic.permission.micadmin_panel'))) {
      $docs = ClaimDoc::where('claim_id', $claim_id)
                    ->orderBy('id', 'DESC')
                    ->get();
    }
    else if ($user->hasRole(config('mic.user_role.patient'))) {
      $docs = ClaimDoc::where('claim_id', $claim_id)
                    ->where('type', '')
                    ->orderBy('id', 'DESC')
                    ->get();
    }
    else {
      $cda_docs = $this->getCDAdocs($uid);
      $sub_query = "creator_uid = $uid";
      if (!empty($cda_docs)) {
        $ids = join(", ",$cda_docs);
        $sub_query .= " OR id IN($ids) ";
      }
      $docs = ClaimDoc::where('claim_id', $claim_id)
                    ->whereRaw($sub_query)
                    ->orderBy('id', 'DESC')
                    ->get(); 
    }
    
    return $docs;
  }

  public function deleteClaimDoc($doc) {
    $this->deleteClaimDocAccess($doc->id);

    $upload = Upload::find($doc->file_id);
    if ($upload) {
      unlink($upload->path);
      $upload->forceDelete();
    }
    $doc->forceDelete();
  }

  public function deleteClaimDocAccess($doc_id) {
    DB::table('claimdocaccesses')->where('doc_id', $doc_id)->delete();
  }

  public function getClaimDocAccessData($claim, $doc) {

    $data = array();
    $data[$claim->patient_uid] = 'patient';

    $partners = $this->getPartnersByClaim($claim->id);
    foreach ($partners as $partner) {
      $data[$partner->id] = false;
    }

    $cda = ClaimDocAccess::where('doc_id', $doc->id)->get();
    foreach ($cda as $item) {
      $data[$item->partner_uid] = 'access';
    }

    return $data;
  }



}
