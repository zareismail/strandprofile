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
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Zareismail\Strandprofile\Models\User::class;   

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