<?php

namespace App\MIC\MICPay;

use DB;
use Auth;

use App\MIC\Models\User;

use MICHelper;
use App\MIC\MICPay\MICQBMS;



class MICPay {
  /**
   * Laravel application
   *
   * @var \Illuminate\Foundation\Application
   */
  public $app;

  protected $qbms;
  protected $paypal;
  protected $qbpayments;
  
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
      $this->qbms = new MICQBMS();
  }

  public function authorize($user_id) {
    return true;

    $card_info = $this->getCardInfo($user_id);
    if ($card_info) {
      //$this->qbms->authorize($card_info);
    }
  }

  public function charge($user_id, $amount, $comment=null) {
    $card_info = $this->getCardInfo($user_id);
    if ($card_info) {
      $result = $this->qbms->charge($card_info, $amount, $comment);
      dd($result);
      if ($result['status'] == 'success') {
        return true;
      }
    }
    return false;
  }

  protected function getCardInfo($user_id) {
    $user = User::find($user_id);
    if ($paymentInfo = $user->paymentInfo) {
      list($exp_month, $exp_year) = explode('-', $paymentInfo->exp);
      $card_info = array(
          'name'      => $paymentInfo->name_card, 
          'number'    => $paymentInfo->cc_number, 
          'expyear'   => $exp_year, 
          'expmonth'  => $exp_month, 
          'address'   => $paymentInfo->address, 
          'postalcode'=> $paymentInfo->zip, 
          'cvv'       => '', 
        );
      return $card_info;
    }
    return false;
  }
}
