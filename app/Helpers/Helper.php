<?php

if (!function_exists('isActive')) {
    /**
     * Check active menu for sidebar
     */
    function isActive($route, $activeClass = '', $inactiveClass = 'collapsed')
    {
        if (request()->is($route) || request()->is($route . '/*')) {
            return $activeClass;
        }
        
        return $inactiveClass;
    }
}

if (!function_exists('isMenuActive')) {
    /**
     * Check active menu for nav items
     */
    function isMenuActive($route, $activeClass = 'active')
    {
        if (request()->is($route) || request()->is($route . '/*')) {
            return $activeClass;
        }
        
        return '';
    }
}