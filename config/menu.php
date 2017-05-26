<?php

/**
 * Config Menu Structure
 */

return [
  // Admin Menu
  'admin' => [
    'claims' => [
      'title' => 'Claims', 
      'url'   => 'admin/claims', 
      'icon'  => 'fa-tasks', 
    ], 
    'partner_apps' => [
      'title' => 'Applications (Partner)', 
      'url'   => '#', 
      'icon'  => 'fa-envelope-o', 
      '#child' => [
        'pending_apps' => [
          'title' => 'Applications', 
          'url'   => 'admin/applications/pending', 
          'icon'  => 'fa-file-pdf-o', 
        ], 
        'approved_apps' => [
          'title' => 'Approved', 
          'url'   => 'admin/applications/approved', 
          'icon'  => 'fa-file-archive-o', 
        ], 
        'declined_apps' => [
          'title' => 'Declined', 
          'url'   => 'admin/applications/declined', 
          'icon'  => 'fa-file-code-o', 
        ],
      ]
    ], 
    'patients' => [
      'title' => 'Patients', 
      'url'   => 'admin/patients', 
      'icon'  => 'fa-user', 
    ], 
    'partners' => [
      'title' => 'Partners', 
      'url'   => 'admin/partners', 
      'icon'  => 'fa-user', 
    ], 
    'i_questions' => [
      'title' => 'Injury Questions', 
      'url'   => 'admin/i-questions', 
      'icon'  => 'fa-question-circle', 
    ], 
    'learning_videos' => [
      'title' => 'Learning Videos', 
      'url'   => 'admin/learning-videos', 
      'icon'  => 'fa-file-video-o', 
    ], 
    'users' => [
      'title' => 'User Accounts', 
      'url'   => 'admin/users', 
      'icon'  => 'fa-users', 
    ], 
  ], 

  // Case Manager Menu
  'case_manager' => [
    'claims' => [
      'title' => 'Claims', 
      'url'   => 'admin/claims', 
      'icon'  => 'fa-tasks', 
    ], 
  ], 

  // Patient Menu
  'patient' => [
    'new_claim' => [
      'title' => 'Create Claim', 
      'url'   => 'claim/create/start', 
    ], 
    'claims' => [
      'title' => 'My Claims', 
      'url'   => 'my-claims', 
    ], 
    'videos' => [
      'title' => 'Learning Center', 
      'url'   => 'learning-center', 
    ], 
  ], 

  // Partner Menu
  'partner' => [
    'claims' => [
      'title' => 'Claims', 
      'url'   => 'partner/claims', 
    ], 
    'videos' => [
      'title' => 'Learning Center', 
      'url'   => 'learning-center', 
    ], 
  ], 

  'micadmin' => [
    'admin_panel' => [
      'title' => 'Admin Panel', 
      'url'   => 'admin', 
    ], 
  ], 
];
