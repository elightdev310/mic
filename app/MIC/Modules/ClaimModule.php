<?php

namespace App\MIC\Modules;

use DB;

use App\MIC\Models\IQuestion;
use App\MIC\Models\Claim;
use App\MIC\Models\User;
use App\MIC\Models\Partner2Claim;

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
}
