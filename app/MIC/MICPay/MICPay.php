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

  public function charge($payment_info, $amount, $comment=null) {
    $card_info = $this->getCardInfo($payment_info);
    if ($card_info) {
      $result = $this->qbms->charge($card_info, $amount, $comment);
      return $result;
    }
    return false;
  }

  protected function getCardInfo($paymentInfo) {
    if ($paymentInfo) {
      list($exp_month, $exp_year) = explode('-', $paymentInfo->exp);
      $card_info = array(
          'name'      => $paymentInfo->name_card, 
          'number'    => $paymentInfo->cc_number, 
          'expyear'   => $exp_year, 
          'expmonth'  => $exp_month, 
          'address'   => $paymentInfo->address, 
          'postalcode'=> $paymentInfo->zip, 
          'cvv'       => $paymentInfo->cid, 
        );
      return $card_info;
    }
    return false;
  }
}
