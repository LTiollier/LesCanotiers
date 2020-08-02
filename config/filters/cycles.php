<?php

return [
    'name' => 'cycles',
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
            'text' => 'Date de début',
            'name' => 'starts_at',
            'active' => true,
            'field' => [
                'type' => 'date'
            ],
        ],
        [
            'text' => 'Date de fin',
            'name' => 'ends_at',
            'active' => true,
            'field' => [
                'type' => 'date'
            ],
        ],
        [
            'text' => 'Fruit/Légume',
            'name' => 'vegetable',
            'active' => true,
            'field' => [
                'type' => 'text'
            ],
        ],
        [
            'text' => 'Parcelle',
            'name' => 'parcel',
            'active' => true,
            'field' => [
                'type' => 'text'
            ],
        ],
    ]
];
