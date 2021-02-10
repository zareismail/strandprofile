<?php

namespace Zareismail\Strandprofile\Nova; 

use Laravel\Nova\Http\Requests\NovaRequest;
use Zareismail\NovaContracts\Nova\User as Resource; 

class User extends Resource
{       
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Users';    

    /**
     * Get the URI key for the resource.
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'sp-'.parent::uriKey();
    }
}