<?php

return [
    'modules' => [
        'core' => ['icon' => 'house', 'label' => 'Dashboard', 'roles' => ['*']],
        'admin' => ['icon' => 'user-shield', 'label' => 'Admin', 'roles' => ['admin']],
        'teacherpanel' => ['icon' => 'chalkboard-teacher', 'label' => 'Teacher Panel', 'roles' => ['teacher']],
        'planning' => ['icon' => 'calendar-lines-pen', 'label' => 'Planning', 'roles' => ['teacher']],
        'classrecord' => ['icon' => 'book-user', 'label' => 'Class Record', 'roles' => ['teacher']],
        'library' => ['icon' => 'books', 'label' => 'Library', 'roles' => ['teacher', 'admin']],
        'billing' => ['icon' => 'credit-card', 'label' => 'Billing', 'roles' => ['teacher']],
        'support' => ['icon' => 'headset', 'label' => 'Support', 'roles' => ['teacher']],
    ],
];
