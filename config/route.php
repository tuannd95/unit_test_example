<?php

return [
    'login_member_api_name' => 'member.login',
    'login_appraiser_api_name' => 'appraiser.login',
    'login_admin_api_name' => 'admin.login',
    'forgot_password_member_api_name' => 'member.forgot-password',
    'ignore_log_routes' => [
       'member.register.email',
       'member.register',
       'member.forgot-password',
       'member.verify.token',
    ],
    'auth_module' => [
        'admin_login' => '/api/v1/admin/login',
        'member_login' => '/api/v1/member/login',
        'appraiser_login' => '/api/v1/appraiser/login',
        'user_logout' => '/api/v1/logout',
    ],
    'multi_log_routes' => [
        'api.v1.admin.members.update',
        'api.v1.admin.appraisers.update',
        'api.v1.admin.appraisers.update_characters'
    ]
];
