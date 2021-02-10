<?php

namespace Zareismail\Strandprofile\Nova; 

use Illuminate\Http\Request; 
use Laravel\Nova\Fields\{ID, Text, BelongsTo, DateTime};
use DmitryBubyakin\NovaMedialibraryField\Fields\Medialibrary;
use Zareismail\NovaContracts\Nova\User;

class Account extends Resource
{ 
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Account and Insurance';  

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Zareismail\Strandprofile\Models\StrandprofileAccount::class; 

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
            ID::make()->sortable(),

            Text::make(__('Details'), 'name')
                ->sortable()
                ->required()
                ->rules('required'),

            DateTime::make(__('Date'), 'date'),
             
            Medialibrary::make(__('Attachments'), 'attachments') 
                ->autouploading(), 
        ];
    }
}