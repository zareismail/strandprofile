<?php

namespace Zareismail\Strandprofile\Nova; 

use Illuminate\Http\Request; 
use Laravel\Nova\Fields\{ID, Text, Number, Date};
use DmitryBubyakin\NovaMedialibraryField\Fields\Medialibrary;
use Zareismail\NovaContracts\Nova\User;

class Reference extends Resource
{  

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Zareismail\Strandprofile\Models\StrandprofileReference::class; 

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = ['auth'];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'landlord', 'email'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Landlord Name'), 'landlord')
                ->sortable()
                ->required()
                ->rules('required'),

            Text::make(__('Landlord Email'), 'email')
                ->sortable()
                ->required()
                ->rules('required', 'email'),

            Text::make(__('Apartment Address'), 'address')
                ->sortable()
                ->required()
                ->rules('required'),

            Number::make(__('Apartment Number'), 'apartment')
                ->sortable()
                ->required()
                ->rules('required'),

            Date::make(__('Tenancy Date'), 'tenancy_date')
                ->required()
                ->rules('required'), 
        ];
    }

    /**
     * Get the text for the create resource button.
     *
     * @return string|null
     */
    public static function createButtonLabel()
    {
        return __('Request :resource', ['resource' => static::singularLabel()]);
    }
}