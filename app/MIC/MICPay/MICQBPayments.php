<?php

namespace App\MIC\MICPay;

use DB;
use Auth;

use MICHelper;

class MICQBPayments {
  protected $payments;
  public function __construct()
  {
    $dsn = null;
    $oauth_consumer_key = 'qyprdTbzTeJ7nO0kcvi5xPCEX8YkmF';
    $oauth_consumer_secret = 'Zy1sNbVn9dl2xdjbj0tGwXO9mWS7Udpsgv7NItc9';
    $sandbox = true;

    $this->payments = new QuickBooks_Payments(
      $oauth_consumer_key, 
      $oauth_consumer_secret, 
      $sandbox
    );
  }

  public function charge($card_info, $amount, $comment=null) {
    extract($card_info);
    $currency = 'USD';
    $CreditCard = new QuickBooks_Payments_CreditCard($name, $number, $expyear, $expmonth, $street, $city, $region, $postalcode);

    if ($Transaction = $this->payments->charge(null, $CreditCard, $amount, $currency))
      return true;
    } else {
      return array(
          'status' => 'error', 
          'msg'    => $this->payments->lastError()
        );
    }
  }

}
