<?php


return [
    'create_users' => true,

    //     /**
    //      * Control if all the laratrust tables should be truncated before running the seeder.
    //      */
   'truncate_tables' => true,
    'roles_structure' => [
        'super' => [
            'users'            => 'c,r,u,d',
            'roles'            => 'c,r,u,d',
            'owners'         =>'c,r,u,d',
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];


// return [
//     /**
//      * Control if the seeder should create a user per role while seeding the data.
//      */
//     'create_users' => false,

//     /**
//      * Control if all the laratrust tables should be truncated before running the seeder.
//      */
//     'truncate_tables' => true,

//     'roles_structure' => [
//         'superadministrator' => [
//             'users' => 'c,r,u,d',
//             'payments' => 'c,r,u,d',
//             'profile' => 'r,u',
//         ],
//         'administrator' => [
//             'users' => 'c,r,u,d',
//             'profile' => 'r,u',
//         ],
//         'user' => [
//             'profile' => 'r,u',
//         ],
//         'role_name' => [
//             'module_1_name' => 'c,r,u,d',
//         ],
//     ],

//     'permissions_map' => [
//         'c' => 'create',
//         'r' => 'read',
//         'u' => 'update',
//         'd' => 'delete',
//     ],
// ];
