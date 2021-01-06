<?php

namespace Zareismail\Strandprofile\Navigations;
 
use Zareismail\NovaContracts\Nova\Notification;

class Notifications extends Letters 
{    
    /**
     * Get the router name.
     *
     * @return string
     */
    public static function name()
    {
        return 'index';
    } 

    /**
     * Get the routers.
     *
     * @return string
     */
    public static function params(): array
    {
        return [
            'resourceName' => Notification::uriKey(),
        ];
    } 
}
