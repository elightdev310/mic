<?php

/**
 * Config Menu Structure
 */

return [
  'admin' => [
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
    'i_questions' => [
      'title' => 'Injury Questions', 
      'url'   => 'admin/i-questions', 
      'icon'  => 'fa-question-circle', 
    ], 
    'users' => [
      'title' => 'User Accounts', 
      'url'   => 'admin/users', 
      'icon'  => 'fa-users', 
    ], 
  ]
];
