<?php

return [
    'name' => 'parcels',
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
    ]
];
