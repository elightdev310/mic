<?php
/**
 * Config genrated using MIC
 */

return [

  /*
  |--------------------------------------------------------------------------
  | General Configuration
  |--------------------------------------------------------------------------
  */

  'adminRoute' => 'admin',
  
  'front_url' => url('/'),
  
  'logo_url'  => asset('assets/img/logo.png'), 

  'pending_user' => 2, 

  // User Status
  'user_status' => array(
      'active'  => 'active', 
      'pending' => 'pending', 
      'cancel'  => 'cancel', 
    ), 

  // User Role
  'user_role' => array(
      'super_admin'   => 'SUPER_ADMIN', 
      'admin'         => 'ADMIN', 
      'patient'       => 'PATIENT', 
      'partner'       => 'PARTNER', 

      // 'doctor'        => 'DOCTOR', 
      // 'pcp'           => 'PCP', 
      // 'specialist'    => 'SPECIALIST', 
      // 'therapist'     => 'THERAPIST', 
      // 'attorney'      => 'ATTORNEY', 
      // 'insurer'       => 'INSURER', 
    ), 

  'user_type' => array(
      'patient'   => 'Patient', 
      'partner'   => 'Partner', 
      'employee'  => 'Employee', 
    ), 

  'partner_type' => array(
      'doctor'        => 'Doctor', 
      'pcp'           => 'Primary Care Provider', 
      'specialist'    => 'Specialist', 
      'therapist'     => 'Therapist', 
      'attorney'      => 'Attorney', 
      'insurer'       => 'Insurer'
    ),

  'membership_level' => array(
      '1'    => 'Level 1 ($)', 
      '2'    => 'Level 2 ($$)', 
      '3'    => 'Level 3 ($$$)', 
    ), 

  'payment_type' => array(
      'visa'    => 'Visa/MC/Amex/Discover', 
      'paypal'  => 'Paypal'
    ), 

];
