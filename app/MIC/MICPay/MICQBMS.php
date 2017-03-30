<?php

namespace App\MIC\MICPay;

use DB;
use Auth;

use MICHelper;

class MICQBMS {
  protected $MS;
  public function __construct()
  {
    $dsn = null;
    $path_to_private_key_and_certificate = null;
    $application_login = config('services.qbms.application_login');
    $connection_ticket = config('services.qbms.connection_ticket');

    $this->MS = new QuickBooks_MerchantService(
      $dsn, 
      $path_to_private_key_and_certificate, 
      $application_login,
      $connection_ticket
    );

    if ($this->MS) {
      $this->MS->useTestEnvironment(true);
      $this->MS->useDebugMode(true);
    }
  }

  protected function noMSReturn() {
    return array(
        'status' => 'error', 
        'msg' => 'No Merchant Service Object', 
      );
  }

  public function authorize($card_info) {
    if (!$this->MS) { return $this->noMSReturn(); }

    extract($card_info);
    $Card = new QuickBooks_MerchantService_CreditCard($name, $number, 
                                                      $expyear, $expmonth, 
                                                      $address, $postalcode, 
                                                      $cvv);
    $amount = 1.0;  

    if ($Transaction = $this->MS->authorize($Card, $amount)) {
      return true;
    } else {
      return array(
          'status' => 'error', 
          'err_no' => $this->MS->errorNumber(), 
          'msg'    => $this->MS->errorMessage()
        );
    }
  }

  public function charge($card_info, $amount, $comment=null) {
    if (!$this->MS) { return $this->noMSReturn(); }

    extract($card_info);
    $Card = new QuickBooks_MerchantService_CreditCard($name, $number, 
                                                      $expyear, $expmonth, 
                                                      $address, $postalcode, 
                                                      $cvv);

    if ($Transaction = $this->MS->charge($Card, $amount, null, $comment)) {
      return true;
    } else {
      return array(
          'status' => 'error', 
          'err_no' => $this->MS->errorNumber(), 
          'msg'    => $this->MS->errorMessage()
        );
    }
  }

}
