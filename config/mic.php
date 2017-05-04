<?php
/**
 * Config genrated using MIC
 */

ini_set('memory_limit','1024M');
ini_set('upload_max_filesize','10M');

return [

  /*
  |--------------------------------------------------------------------------
  | General Configuration
  |--------------------------------------------------------------------------
  */

  'adminRoute' => 'admin',
  
  'front_url' => '/',

  'logo_url'  => '/assets/img/logo-big.png', 
  
  'avatar_path' => 'uploads/avatar/', 
  'pending_user' => 2, 
  'admin_user' => 3, 

  // User Status
  'user_status' => array(
      'active'  => 'active', 
      'pending' => 'pending', 
      'cancel'  => 'cancel', 
    ), 

  // Permission
  'permission' => array(
      'micadmin_panel' => 'MICADMIN_PANEL', 
      'patient_panel' => 'PATIENT_PANEL', 
      'partner_panel' => 'PARTNER_PANEL',
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

  // Claim Assign Request Status
  'car_status' => array(
      '0'    => '-', 
      '1'    => 'approved', 
      '2'    => 'rejected', 
    ), 

  // Video Price
  'video_price' => 5.00, 
];
