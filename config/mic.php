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
  'superRoute' => 'super-admin',
  
  'front_url' => '/',

  'logo_url'  => '/assets/img/logo-big.png', 
  
  'avatar_path' => 'uploads/avatar/', 
  'pending_user' => 2, 
  'admin_user' => 3, 
  'super_admin_user' => 1, 

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
      'case_manager_panel' => 'CASE_MANAGER_PANEL', 
  ), 
  // User Role
  'user_role' => array(
      'super_admin'   => 'SUPER_ADMIN', 
      'admin'         => 'ADMIN', 
      'patient'       => 'PATIENT', 
      'partner'       => 'PARTNER', 
      'case_manager'  => 'CASE_MANAGER', 
    ), 

  'user_type' => array(
      'patient'   => 'Patient', 
      'partner'   => 'Partner', 
      'employee'  => 'Employee', 
      'case_manager' => 'Case Manager', 
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

  // Resources
  'resource' => array(
      'template' => array(
        'one_column' => 'One Column Page', 
        'two_column' => 'Two Column Page',
      ), 
    ), 
];
