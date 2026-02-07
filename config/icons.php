<?php

return [
    'modules' => [
        'core' => ['icon' => 'house', 'label' => 'Dashboard', 'roles' => ['*']],
        'admin' => ['icon' => 'user-shield', 'label' => 'Admin', 'roles' => ['Admin']],
        'teacherpanel' => ['icon' => 'chalkboard-teacher', 'label' => 'Teacher Panel', 'roles' => ['Professor Free', 'Professor Pro']],
        'planning' => ['icon' => 'calendar-lines-pen', 'label' => 'Planning', 'roles' => ['Professor Free', 'Professor Pro']],
        'classrecord' => ['icon' => 'book-user', 'label' => 'Class Record', 'roles' => ['Professor Free', 'Professor Pro']],
        'library' => ['icon' => 'books', 'label' => 'Library', 'roles' => ['Professor Free', 'Professor Pro', 'Admin']],
        'billing' => ['icon' => 'credit-card', 'label' => 'Billing', 'roles' => ['Professor Free', 'Professor Pro']],
        'support' => ['icon' => 'headset', 'label' => 'Support', 'roles' => ['Professor Free', 'Professor Pro']],
    ],
];
