<?php

return [
    'name' => 'parcels',
    'filters' => [
        [
            'text' => 'ID',
            'name' => 'id',
            'active' => true,
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
