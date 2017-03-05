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
use App\MIC\Models\ClaimActivity;
use App\MIC\Models\ClaimActivityFeed;
use App\User as UserModel;

use App\MIC\Helpers\MICHelper;

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

  public function getCAFeeds($claim_id, $user_type) {
    $user = MICHelper::currentUser();
    $feeds = array();
    switch ($user_type) {
      case 'patient':
        $feeds = ClaimActivity::where('claim_id', $claim_id)
                              ->where('public_patient', 1)
                              ->orderBy('created_at', 'DESC')
                              ->get();
        break;
      case 'partner':
        // $feeds = DB::table('claimactivities')
        //            ->rightJoin('claimactivityfeeds', function($join) use($claim_id, $user) {
        //                 $join->on('claimactivities.id', '=', 'claimactivityfeeds.ca_id')
        //                      ->where('claimactivityfeeds.claim_id', '=', $claim_id)
        //                      ->where('claimactivityfeeds.feeder_uid', '=', $user->id);
        //               })
        //            ->get();
        $cafs = DB::table('claimactivityfeeds')
                    ->where('claim_id', $claim_id)
                    ->where('feeder_uid', $user->id)
                    ->pluck('ca_id');
        
        $feeds = ClaimActivity::whereIn('id', $cafs)
                              ->orderBy('created_at', 'DESC')
                              ->get();

        break;
      case 'employee':
        $feeds = ClaimActivity::where('claim_id', $claim_id)
                              ->orderBy('created_at', 'DESC')
                              ->get();
        break;
    }

    if (empty($feeds)) {
      $feeds = array();
    }

    return $feeds;
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

    if ($user->type == 'employee') {
      $docs = ClaimDoc::where('claim_id', $claim_id)
                    ->orderBy('id', 'DESC')
                    ->get();
    }
    else if ($user->type == 'patient') {
      $docs = ClaimDoc::where('claim_id', $claim_id)
                    ->where('type', '')
                    ->orderBy('id', 'DESC')
                    ->get();
    }
    else if ($user->type == 'partner') {
      $cda_docs = $this->getCDAdocs($uid);
      $sub_query = "creator_uid = $uid";
      if (!empty($cda_docs)) {
        $ids = join(", ",$cda_docs);
        $sub_query .= " OR id IN($ids) ";
      }
      $sub_query = "claim_id = $claim_id AND ($sub_query)";
      $docs = ClaimDoc::whereRaw($sub_query)
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

  public function getCDA($doc_id) {
    $cdas = ClaimDocAccess::where('doc_id', $doc_id)
                         ->get();
    if (!$cdas) { return arrau(); }
    return $cdas;
  }

  /**
   * Check if user has access to claim doc
   */
  public function checkCDA($user_id, $doc_id) {
    $doc = ClaimDoc::find($doc_id);
    $claim = $doc->claim;

    // Doc Author, Claim Creator
    if ($doc->creator_uid == $user_id || $claim->patient_uid == $user_id) {
      return true;
    }

    // Check CDA
    $cda = ClaimDocAccess::where('doc_id', $doc_id)
                         ->where('partner_uid', $user_id)
                         ->first();
    if ($cda) {
      return true;
    }
    
    return false;
  }

  public function insertClaimActivity($claim_id, $content, $author_uid, $type, $public_patient=1) {
    $ca = new ClaimActivity;
    $ca->claim_id = $claim_id;
    $ca->content  = $content;
    $ca->author_uid = $author_uid;
    $ca->type     = $type;
    $ca->public_patient = $public_patient;
    $ca->save();

    return $ca;
  }

  public function getCAContent($type, $params) {
    $content = '';
    extract($params);
    switch ($type) {
      case 'create_claim':
        // use $claim, $user
        $msg = '%s submitted claim #%d';
        $content = sprintf($msg, $claim->id);
        break;
      case 'upload_photo':
        // use $claim, $user, $photo
        $msg = 'Uploaded photo (%s) to claim #%d';
        $content = sprintf($msg, $photo->file->name, $claim->id);
        break;
      case 'delete_photo':
        // use $claim, $user, $photo
        $msg = 'Deleted photo (%s) from claim #%d';
        $content = sprintf($msg, $photo->file->name, $claim->id);
        break;

      case 'upload_doc':
        // use $claim, $user, $doc
        $msg = 'Uploaded document (%s) to claim #%d';
        $content = sprintf($msg, $doc->file->name, $claim->id);
        break;
      case 'delete_doc':
        // use $claim, $user, $doc
        $msg = 'Deleted document (%s) from claim #%d';
        $content = sprintf($msg, $doc->file->name, $claim->id);
        break;
      case 'post_comment':
        // use $claim, $user, $doc, $comment
        $msg = 'Posted comment to document (%s) <br/><div class="comment-text">%s</div>';
        $content = sprintf($msg, $doc->file->name, nl2br($comment->comment));
        break;
      case 'assign_partner':
        // use $partner, $claim
        $msg = 'Assigned %s to claim #%d';
        $content = sprintf($msg, $partner->name, $claim->id);
        break;
      case 'unassign_partner':
        // use $partner, $claim
        $msg = 'Unassigned %s from claim #%d';
        $content = sprintf($msg, $partner->name, $claim->id);
        break;
    }

    return $content;
  }

  public function getCAFeeders($type, $params) {
    $feeders = array();
    extract($params);
    switch ($type) {
      case 'create_claim':
        break;
      case 'upload_photo':
      case 'delete_photo':
        // use $claim, $user, $photo
        $p2cs = Partner2Claim::where('claim_id', $claim->id)->get();
        foreach ($p2cs as $p2c) {
          $feeders[$p2c->partner_uid] = $p2c->partner_uid;
        }
        break;
      case 'upload_doc': 
        // use $claim, $user, $doc
        if (MICHelper::isPartner($doc->creator_uid)) {
          $feeders[$doc->creator_uid] = $doc->creator_uid;   // Partner Author
        }
        break;
      case 'delete_doc':
      case 'post_comment':
        // use $claim, $user, $doc
        $cdas = $this->getCDA($doc->id);
        foreach ($cdas as $cda) {
          $feeders[$cda->partner_uid] = $cda->partner_uid;
        }
        if (MICHelper::isPartner($doc->creator_uid)) {
          $feeders[$doc->creator_uid] = $doc->creator_uid;   // Partner Author
        }
        break;
      case 'assign_partner': 
      case 'unassign_partner': 
        // use $partner, $claim
        $feeders[$partner->id] = $partner->id;    // Assigned Partner
        break;
    }

    return $feeders;
  }

  public function insertCAFeeds($claim_id, $claim_activity_id, $feeders) {
    foreach ($feeders as $feeder_uid) {
      $caf = new ClaimActivityFeed;
      $caf->claim_id    = $claim_id;
      $caf->feeder_uid  = $feeder_uid;
      $caf->ca_id       = $claim_activity_id;
      $caf->save();
    }    
  }

}
