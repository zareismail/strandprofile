<?php

namespace Zareismail\Strandprofile\Nova; 

use Illuminate\Http\Request;  
use Laravel\Nova\Fields\Avatar;  

class Verification extends Profile
{      
    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [    
            Avatar::make(__('Passprot'), 'profile->passport')
                ->rounded(),  

            Avatar::make(__('Payslip'), 'profile->payslip')
                ->rounded(), 
        ];
    } 
}