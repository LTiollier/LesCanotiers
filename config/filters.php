<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Classes
    |--------------------------------------------------------------------------
    |
    | Configurer ici la classe de configuration du filtre
    |
    */
    'classes' => [
        'users'    => \App\Filters\UserFilter::class,
        'vegetables' => \App\Filters\VegetableFilter::class,
        'parcels' => \App\Filters\ParcelFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Names
    |--------------------------------------------------------------------------
    |
    | Configurer ici le nom du filtre (utilisé pour le nom du fichier exporté en csv)
    |
    */
    'names' => [
        'users'    => 'Utilisateurs',
        'vegetables' => 'Fruits/Légumes',
        'parcels' => 'Parcelles'
    ],

    /*
    |--------------------------------------------------------------------------
    | Field classes
    |--------------------------------------------------------------------------
    |
    | Configurer ici les classes utilisées pour chaque type de champs
    |
    */
    'field_classes' => [
        'text'          => \App\Filters\Fields\Text::class,
        'number'        => \App\Filters\Fields\Number::class,
        'checkbox'      => \App\Filters\Fields\Checkbox::class,
        'select'        => \App\Filters\Fields\Select::class,
        'date'          => \App\Filters\Fields\Date::class,
        'datetime'      => \App\Filters\Fields\Date::class,
    ]
];
