<?php

namespace App\Services;

class NavigationService
{
    /**
     * @return array<int, array>
     */
    public function getNav()
    {
        return [
            [
                'text' => 'Temps',
                'href' => route('home'),
                'icon' => 'mdi-clock',
                'match' => ['home'],
            ],
            [
                'text' => 'Mes temps',
                'href' => route('times.index'),
                'icon' => 'mdi-clock',
                'match' => ['times.index'],
            ],
            [
                'text' => 'Utilisateurs',
                'href' => route('users.index'),
                'icon' => 'mdi-face',
                'match' => ['users.index', 'users.create', 'users.edit'],
            ],
            [
                'text' => 'Activités',
                'href' => route('activities.index'),
                'icon' => 'mdi-face',
                'match' => ['activities.index', 'activities.create', 'activities.edit'],
            ],
            [
                'text' => 'Catégories Fruits/Légumes',
                'href' => route('vegetableCategories.index'),
                'icon' => 'mdi-food-apple',
                'match' => ['vegetableCategories.index', 'vegetableCategories.create', 'vegetableCategories.edit'],
            ],
            [
                'text' => 'Fruits/Légumes',
                'href' => route('vegetables.index'),
                'icon' => 'mdi-food-apple',
                'match' => ['vegetables.index', 'vegetables.create', 'vegetables.edit'],
            ],
            [
                'text' => 'Parcelles',
                'href' => route('parcels.index'),
                'icon' => 'mdi-gate',
                'match' => ['parcels.index', 'parcels.create', 'parcels.edit'],
            ],
            [
                'text' => 'Cycles',
                'href' => route('cycles.index'),
                'icon' => 'mdi-autorenew',
                'match' => ['cycles.index', 'cycles.create', 'cycles.edit'],
            ],
            [
                'text' => 'Compte rendu',
                'href' => route('report'),
                'icon' => 'mdi-autorenew',
                'match' => ['report'],
            ]
        ];
    }

    /**
     * @param string|null $currentRouteName
     * @return int|null
     */
    public function getActiveKey(?string $currentRouteName): ?int
    {
        if (is_null($currentRouteName)) {
            return null;
        }
        $nav = $this->getNav();
        foreach ($nav as $key => $onglet) {
            if (in_array($currentRouteName, $onglet['match'])) {
                return $key;
            }
        }
        return null;
    }
}
