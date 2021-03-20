<?php

return [
    'name' => 'vegetables',
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
            'text' => 'Catégory',
            'name' => 'vegetableCategory',
            'active' => true,
            'field' => [
                'type' => 'text'
            ],
        ]
    ]
];
