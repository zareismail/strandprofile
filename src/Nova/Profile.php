<?php

namespace Zareismail\Strandprofile\Nova; 

use Illuminate\Http\Request;  
use Laravel\Nova\Fields\{ID, Text, Number, Avatar};
use Laravel\Nova\Panel;
use Zareismail\NovaContracts\Nova\User;

class Profile extends User
{    
    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = ['maturiteis'];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [ 
            Text::make(__('Username'), 'name'),

            Text::make(__('Firstname'), 'profile->firstname'),

            Text::make(__('Lastname'), 'profile->lastname'),

            Text::make(__('Mobile'), 'mobile'),

            Number::make(__('Age'), 'profile->age'),

            Avatar::make(__('Image'), 'profile->image')
                ->rounded()
                ->hideFromDetail(boolval($request->get('card') == 'profile')), 
        ];
    }

    /**
     * Determine if the given resource is authorizable.
     *
     * @return bool
     */
    public static function authorizable()
    {
        return false;
    }
}