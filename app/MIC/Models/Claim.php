<?php
/**
 *
 */

namespace App\MIC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Claim as ClaimModule;

class Claim extends ClaimModule
{
  public function patientUser() {
    return $this->belongsTo('App\MIC\Models\User', 'patient_uid');
  }

  public function getAnswers() {
    $answers = unserialize($this->answers);
    return $answers;
  }
  public function setAnswers($answers) {
    $this->answers = serialize($answers);
  }
  
}
