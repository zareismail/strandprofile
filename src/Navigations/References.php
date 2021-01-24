<?php

namespace Zareismail\Strandprofile\Navigations; 
  

class References extends PreviousTenancy 
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
            'resourceName' => 'references'
        ];
    }
}
