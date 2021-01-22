<?php

namespace Zareismail\Strandprofile\Nova; 

use Illuminate\Http\Request;  
use Laravel\Nova\Fields\{ID, Text, Number, Boolean, Select, Avatar, Date, Country};
use Laravel\Nova\Panel;
use NovaButton\Button;
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
            Text::make(__('Username'), 'name')
                ->onlyOnForms(),

            Text::make(__('Firstname'), 'profile->firstname'),

            Text::make(__('Lastname'), 'profile->lastname'),

            Text::make(__('Mobile'), 'mobile'),

            Text::make(__('Email'), 'email'),

            Avatar::make(__('Image'), 'profile->image')
                ->rounded()
                ->hideFromDetail(boolval($request->get('card') == 'profile')),   
            
            Button::make('Personal Details')    
                ->edit(PersonalDetail::class, $request->user()->id)
                ->style('primary-outline')
                ->withMeta([
                    'withoutLabel' => true,
                    'width' => 'w-1/3',
                ]),
            
            Button::make('ID Verification')    
                ->edit(Verification::class, $request->user()->id)
                ->style('primary-outline')
                ->withMeta([
                    'withoutLabel' => true,
                    'width' => 'w-1/3',
                ]),
            
            Button::make('References')    
                ->edit(PersonalDetail::class, $request->user()->id)
                ->style('primary-outline')
                ->withMeta([
                    'withoutLabel' => true,
                    'width' => 'w-1/3',
                ]),
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