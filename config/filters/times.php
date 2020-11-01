<?php

return [
    'name' => 'times',
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
            'text' => 'Utilisateur',
            'name' => 'user',
            'active' => true,
            'field' => [
                'type' => 'text'
            ],
        ],
        [
            'text' => 'Date',
            'name' => 'date',
            'active' => true,
            'field' => [
                'type' => 'date'
            ],
        ],
        [
            'text' => 'Activité',
            'name' => 'activity',
            'active' => true,
            'field' => [
                'type' => 'text'
            ],
        ],
        [
            'text' => 'Date du cycle',
            'name' => 'cycle_date',
            'active' => true,
            'field' => [
                'type' => 'text'
            ],
        ],
        [
            'text' => 'Minutes',
            'name' => 'minutes',
            'active' => true,
            'field' => [
                'type' => 'text'
            ],
        ],
    ]
];
