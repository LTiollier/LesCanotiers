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
                'text' => 'Utilisateurs',
                'href' => route('users.index'),
                'icon' => 'mdi-face',
                'match' => ['users.index'],
            ],
            [
                'text' => 'Fruits/Légumes',
                'href' => route('vegetables.index'),
                'icon' => 'mdi-food-apple',
                'match' => ['vegetables.index'],
            ],
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
