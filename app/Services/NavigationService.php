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
                'text' => 'Index',
                'href' => route('index'),
                'icon' => 'mdi-calendar-edit',
                'match' => ['index'],
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
