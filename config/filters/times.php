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
            'text' => 'Minutes',
            'name' => 'minutes',
            'active' => true,
            'field' => [
                'type' => 'text'
            ],
        ],
    ]
];
