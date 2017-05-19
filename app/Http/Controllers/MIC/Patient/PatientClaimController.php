<?php
/**
 * Using by ClaimController genrated using Kevin
 * 
 */

namespace App\Http\Controllers\MIC\Patient;

use Illuminate\Http\Request;
use Auth;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

use MICHelper;
use MICClaim;
use MICNotification;

use App\MIC\Models\User;
use App\MIC\Models\Claim;
use App\MIC\Models\ClaimPhoto;
use App\MIC\Models\ClaimAssignRequest;
use App\Models\Upload;

trait PatientClaimController
{
  /**
   * GET: myclaims
   */
  public function myClaimsPage(Request $request) {
    $user = MICHelper::currentUser();
    $claims = Claim::where('patient_uid', $user->id)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(self::PAGE_LIMIT);

    $params = array();
    $params['claims'] = $claims;
    
    return view('mic.patient.claim.myclaims', $params);
  }

  protected function getPatientClaim($claim_id, $user) {
    $claim = Claim::where('id', $claim_id)
                  ->where('patient_uid', $user->id)
                  ->first();
    if (!$claim) {
      return false;
    }

    return $claim;
  }

  /**
   * Get: claim/{claim_id}
   */
  public function patientClaimViewPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);
    if (!$claim) {
      return view('errors.404');
    }

    // Activity Feeds
    $ca_feeds = MICClaim::getCAFeeds($claim_id, 'patient');
    if ($ca_feeds) {
      $ca_feeds = $ca_feeds->splice(0, 5);
    }

    // Photo
    $photos = MICClaim::getClaimPhotos($claim_id);
    $photo_count = $photos->count();

    if ($photos) {
      $photos = $photos->splice(0, 6);
    }

    // Doc
    $docs = MICClaim::getClaimDocs($claim_id, $user->id);
    if ($docs) {
      $docs = $docs->splice(0, 3);
    }

    $params = array();
    $params['user']       = $user;
    $params['claim']      = $claim;
    $params['ca_feeds']   = $ca_feeds;
    $params['photos']     = $photos;
    $params['docs']       = $docs;
    $params['photo_count']= $photo_count;
    
    $params['no_message'] = 'partial';

    return view('mic.patient.claim.claim_view', $params);
  }

  /**
   * Get: claim/{claim_id}/ioi
   */
  public function patientClaimIOIPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = $this->getPatientClaim($claim_id, $user);
    if (!$claim) {
      return view('errors.404');
    }

    // IOI
    // $answers = $claim->getAnswers();
    // $questions = MICClaim::getIQuestionsByAnswers($answers);
    $questions = MICClaim::getIQuestions(1);
    $answers   = MICClaim::getAnwsersByQuestions($claim_id, $questions);
    $addi_questions = MICClaim::getIQuestions(0);
    $addi_answers   = MICClaim::getAnwsersByQuestions($claim_id, $addi_questions);

    $params = array();
    $params['user']       = $user;
    $params['claim']      = $claim;
    $params['questions']  = $questions;
    $params['answers']    = $answers;
    $params['addi_questions']  = $addi_questions;
    $params['addi_answers']    = $addi_answers;

    $params['tab'] = 'ioi';
    $params['no_message'] = 'partial';

    return view('mic.patient.claim.claim_ioi', $params);
  }

  /**
   * Get: claim/{claim_id}/activity
   */
  public function patientClaimActivityPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = $this->getPatientClaim($claim_id, $user);
    if (!$claim) {
      return view('errors.404');
    }

    // Activity Feeds
    $ca_feeds = MICClaim::getCAFeeds($claim_id, 'patient');

    $params = array();
    $params['user']       = $user;
    $params['claim']      = $claim;
    $params['ca_feeds']   = $ca_feeds;

    $params['tab'] = 'activity';
    $params['no_message'] = 'partial';

    return view('mic.patient.claim.claim_activity', $params);
  }

  /**
   * Get: claim/{claim_id}/docs
   */
  public function patientClaimDocsPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = $this->getPatientClaim($claim_id, $user);
    if (!$claim) {
      return view('errors.404');
    }

    // Doc
    $docs = MICClaim::getClaimDocs($claim_id, $user->id);

    $params = array();
    $params['user']       = $user;
    $params['claim']      = $claim;
    $params['docs']       = $docs;

    $params['tab'] = 'docs';
    $params['no_message'] = 'partial';

    return view('mic.patient.claim.claim_docs', $params);
  }

  /**
   * Get: claim/{claim_id}/photos
   */
  public function patientClaimPhotosPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = $this->getPatientClaim($claim_id, $user);
    if (!$claim) {
      return view('errors.404');
    }

    // Photo
    $photos = MICClaim::getClaimPhotos($claim_id);

    $params = array();
    $params['user']       = $user;
    $params['claim']      = $claim;
    $params['photos']     = $photos;

    $params['tab'] = 'photos';
    $params['no_message'] = 'partial';

    return view('mic.patient.claim.claim_photos', $params);
  }

  /**
   * Get: claim/{claim_id}/action
   */
  public function patientClaimActionPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = $this->getPatientClaim($claim_id, $user);
    if (!$claim) {
      return view('errors.404');
    }

    // Action

    $params = array();
    $params['user']       = $user;
    $params['claim']      = $claim;


    $params['tab'] = 'action';
    $params['no_message'] = 'partial';

    return view('mic.patient.claim.claim_action', $params);
  }

  /**
   * Get: claim/{claim_id}/partners
   */
  public function patientClaimPartnersPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = $this->getPatientClaim($claim_id, $user);
    if (!$claim) {
      return view('errors.404');
    }

    // Partners
    $assign_requests = MICClaim::getCARsByClaim($claim_id, 'patient');
    $assigned_partners = MICClaim::getPartnersByClaim($claim_id);

    $params = array();
    $params['user']       = $user;
    $params['claim']      = $claim;
    $params['assign_requests'] = $assign_requests;
    $params['partners'] = $assigned_partners;

    $params['tab'] = 'partners';
    $params['no_message'] = 'partial';

    return view('mic.patient.claim.claim_partners', $params);
  }

  /**
   * Get: patient/claim/{claim_id}
   */
  public function patientClaimPage(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = Claim::where('id', $claim_id)
                  ->where('patient_uid', $user->id)
                  ->first();
    if (!$claim) {
      return view('errors.404');
    }

    // IOI
    // $answers = $claim->getAnswers();
    // $questions = MICClaim::getIQuestionsByAnswers($answers);
    $questions = MICClaim::getIQuestions(1);
    $answers   = MICClaim::getAnwsersByQuestions($claim_id, $questions);
    $addi_questions = MICClaim::getIQuestions(0);
    $addi_answers   = MICClaim::getAnwsersByQuestions($claim_id, $addi_questions);
    
    // Activity Feeds
    $ca_feeds = MICClaim::getCAFeeds($claim_id, 'patient');

    // Photo
    $photos = MICClaim::getClaimPhotos($claim_id);

    // Doc
    $docs = MICClaim::getClaimDocs($claim_id, $user->id);

    // Partners
    $assign_requests = MICClaim::getCARsByClaim($claim_id, 'patient');
    $assigned_partners = MICClaim::getPartnersByClaim($claim_id);
    
    $params = array();
    $params['user']       = $user;
    $params['claim']      = $claim;
    $params['questions']  = $questions;
    $params['answers']    = $answers;
    $params['addi_questions']  = $addi_questions;
    $params['addi_answers']    = $addi_answers;
    $params['ca_feeds']   = $ca_feeds;
    $params['photos']     = $photos;
    $params['docs']       = $docs;
    $params['assign_requests'] = $assign_requests;
    $params['partners'] = $assigned_partners;

    $params['no_message'] = 'partial';

    return view('mic.patient.claim.page', $params);
  }

  public function updateIOI(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);

    if ($claim) {
      $answers = $request->input('answer');
      $claim->setAnswers($answers);
      $claim->save();

      // Activity Feed
      $ca_params = array(
          'user'  => $user, 
          'claim' => $claim, 
        );
      MICClaim::addClaimActivity($claim->id, $user->id, 'update_ioi', $ca_params);
      MICNotification::sendNotification('claim.update_ioi', $ca_params);

      return redirect()->back()
              ->with('status', 'Updated answers, successfully.');
    } else {
      return redirect()->back()
              ->withErrors('Failed to update answers.');
    }
  }

  /**
   * Upload Photos
   */
  public function patientUploadPhoto(Request $request, $claim_id) {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);

    if($claim && Input::hasFile('file')) {

      $file = Input::file('file');
      
      $photo_folder = "claims".DIRECTORY_SEPARATOR."photos".DIRECTORY_SEPARATOR;
      $folder = storage_path($photo_folder.$claim_id);
      $upload = MICClaim::uploadClaimFile($file, $folder);

      if( $upload ) {
        $photo = ClaimPhoto::create([
          'claim_id' => $claim_id,
          'file_id'  => $upload->id, 
        ]);
        $photo->save();

        $claim = Claim::find($claim_id);
        // Activity Feed
        $ca_params = array(
            'claim' => $claim, 
            'user'  => $user, 
            'photo' => $photo, 
          );
        MICClaim::addClaimActivity($claim->id, $user->id, 'upload_photo', $ca_params);
        MICNotification::sendNotification('claim.upload_photo', $ca_params);

        return response()->json([
          "status" => "success",
          "upload" => $upload
        ], 200);
      } else {
        return response()->json([
          "status" => "error"
        ], 400);
      }
    } else {
      return response()->json('error: upload file not found.', 400);
    }
  }

  public function patientDeletePhoto(Request $request, $claim_id, $photo_id) {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);

    if ($claim) {
      $photo = ClaimPhoto::where('id', $photo_id)
                         ->where('claim_id', $claim_id)
                         ->first();
      if ($photo) {
        $claim = Claim::find($claim_id);
        // Activity Feed
        $ca_params = array(
            'claim' => $claim, 
            'user'  => $user, 
            'photo' => $photo, 
          );
        MICClaim::addClaimActivity($claim->id, $user->id, 'delete_photo', $ca_params);
        MICNotification::sendNotification('claim.delete_photo', $ca_params);
        
        $upload = Upload::find($photo->file_id);
        if ($upload) {
          unlink($upload->path);
          $upload->forceDelete();
        }
        $photo->forceDelete();
      }

      return response()->json([
          "status" => "success",
        ], 200);
    } else {
      return response()->json([
          "status" => "error",
          "action" => "reload"
        ]);
    }
  }
  public function claimPhotoList(Request $request, $claim_id)
  {
    $user = MICHelper::currentUser();
    $claim = MICClaim::accessibleClaim($user, $claim_id);

    $photo_list = '';
    if ($claim) {
      $photos = MICClaim::getClaimPhotos($claim_id);
      $view = View::make('mic.patient.claim.partials.photo_list', ['claim'=>$claim, 'photos'=>$photos]);
      $photo_list = $view->render();
    }

    return response()->json(['photo_html' => $photo_list]);
  }

  public function patientCARAction(Request $request, $claim_id, $car_id, $action) {
    $currentUser = MICHelper::currentUser();
    $car = ClaimAssignRequest::find($car_id);
    if (!$car) {
      return redirect()->back()->withErrors("Failed to handle a request.");
    }

    $claim = MICClaim::accessibleClaim($currentUser, $claim_id);

    if ($claim) {
      if ($action == 'approve') {
        $car->patient_approve = 1;
        $car->status = 'approved';
        $car->save();
        
        // Activity Feed
        $ca_params = array(
            'partner' => $car->partnerUser, 
            'claim'   => $claim
          );
        MICClaim::addClaimActivity($claim->id, $currentUser->id, 'patient_approve_request', $ca_params);
        MICNotification::sendNotification('claim.patient_approve_request', $ca_params);

        // Assign Partner to Claim
        $this->claimAssignPartner($claim_id, $car->partner_uid);

        return redirect()->back()
                  ->with('status', "Approved {$car->partnerUser->name} for claim #$claim_id")
                  ->with('_panel', 'partners');;
      } else if ($action == 'reject') {
        $car->patient_approve = 2;
        $car->status = 'rejected';
        $car->save();

        // Activity Feed
        $ca_params = array(
            'partner' => $car->partnerUser, 
            'claim'   => $claim
          );
        MICClaim::addClaimActivity($claim->id, $currentUser->id, 'patient_reject_request', $ca_params);
        MICNotification::sendNotification('claim.patient_reject_request', $ca_params);

        return redirect()->back()
                ->with('status', "Rejected {$car->partnerUser->name} for claim #$claim_id")
                ->with('_panel', 'partners');
      }
    } else {
      return view('errors.404');
    }
  }

  protected function claimAssignPartner($claim_id, $partner_uid) {
    $currentUser = MICHelper::currentUser();

    $user = User::find($partner_uid);
    if (MICClaim::checkP2C($partner_uid, $claim_id)) {
      return false;
    } else {
      MICClaim::insertP2C($partner_uid, $claim_id);

      $claim = Claim::find($claim_id);
      // Activity Feed
      $ca_params = array(
          'partner' => $user, 
          'claim'   => $claim
        );
      MICClaim::addClaimActivity($claim->id, $currentUser->id, 'assign_partner', $ca_params);
      MICNotification::sendNotification('claim.assign_partner', $ca_params);
      
    }
  }

}
