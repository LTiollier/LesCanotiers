<?php

namespace App\Services;

use App\Models\User;

class NavigationService
{
    private array $nav = [];

    /**
     * @return array<int, array>
     */
    public function getNav()
    {
        if (!auth()->check()) {
            return [];
        }

        $this->insertTab([
            'text' => 'Temps',
            'href' => route('home'),
            'icon' => 'mdi-clock',
            'match' => ['home'],
        ])->insertTab([
            'text' => 'Mes temps',
            'href' => route('times.index'),
            'icon' => 'mdi-clock',
            'match' => ['times.index'],
        ])->insertTab([
            'text' => 'Utilisateurs',
            'href' => route('users.index'),
            'icon' => 'mdi-face',
            'match' => ['users.index', 'users.create', 'users.edit'],
        ], User::_ROLE_ADMIN)
            ->insertTab([
                'text' => 'Activités',
                'href' => route('activities.index'),
                'icon' => 'mdi-face',
                'match' => ['activities.index', 'activities.create', 'activities.edit'],
            ], User::_ROLE_ADMIN)
            ->insertTab([
                'text' => 'Catégories Fruits/Légumes',
                'href' => route('vegetableCategories.index'),
                'icon' => 'mdi-food-apple',
                'match' => ['vegetableCategories.index', 'vegetableCategories.create', 'vegetableCategories.edit'],
            ], User::_ROLE_ADMIN)
            ->insertTab([
                'text' => 'Fruits/Légumes',
                'href' => route('vegetables.index'),
                'icon' => 'mdi-food-apple',
                'match' => ['vegetables.index', 'vegetables.create', 'vegetables.edit'],
            ], User::_ROLE_ADMIN)
            ->insertTab([
                'text' => 'Parcelles',
                'href' => route('parcels.index'),
                'icon' => 'mdi-gate',
                'match' => ['parcels.index', 'parcels.create', 'parcels.edit'],
            ], User::_ROLE_ADMIN)
            ->insertTab([
                'text' => 'Cycles',
                'href' => route('cycles.index'),
                'icon' => 'mdi-autorenew',
                'match' => ['cycles.index', 'cycles.create', 'cycles.edit'],
            ], User::_ROLE_ADMIN)
            ->insertTab([
                'text' => 'Compte rendu',
                'href' => route('report'),
                'icon' => 'mdi-autorenew',
                'match' => ['report'],
            ], User::_ROLE_ADMIN);

        return $this->nav;
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

    /**
     * @param array $tab
     * @param string|null $role
     * @return $this
     */
    protected function insertTab(array $tab, string $role = null): NavigationService
    {
        if ($role) {
            /** @var User user */
            $user = auth()->user();

            if (!$user->hasRole($role)) {
                return $this;
            }
        }

        $this->nav[] = $tab;

        return $this;
    }
}
