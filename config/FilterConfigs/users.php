<?php

return [
    'name' => 'users',
    'filters' => [
        [
            'text' => 'ID',
            'name' => 'id',
            'active' => false,
            'field' => [
                'type' => 'number'
            ],
        ],
        [
            'text' => 'Nom',
            'name' => 'name',
            'active' => true,
            'field' => [
                'type' => 'text'
            ],
        ],
        [
            'text' => 'Email',
            'name' => 'email',
            'active' => true,
            'field' => [
                'type' => 'text'
            ],
        ],
        [
            'text' => "Date de création",
            'name' => 'created_at',
            'active' => true,
            'field' => [
                'type' => 'datetime'
            ]
        ],
    ]
];
