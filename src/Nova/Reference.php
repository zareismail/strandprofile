<?php

namespace Zareismail\Strandprofile\Nova; 

use Illuminate\Http\Request; 
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\{ID, Text, Number, Boolean, Date};
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

            Boolean::make(__('Answered'), function() {
                return $this->getDetails('filled');
            })->onlyOnIndex(),

            Text::make(__('Landlord Email'), 'email')
                ->sortable()
                ->required()
                ->rules('required', 'email')
                ->onlyOnDetail(),

            Text::make(__('Apartment Address'), 'address')
                ->sortable()
                ->required()
                ->rules('required'),

            Number::make(__('Apartment Number'), 'apartment')
                ->sortable()
                ->required()
                ->rules('required'),

            Date::make(__('Tenancy Start Date'), 'started_at')
                ->required()
                ->rules('required'), 

            Date::make(__('Tenancy End Date'), 'finished_in')
                ->required()
                ->rules('required'), 

            Panel::make(__('Answer Detail'), [
                Text::make(__('Landlord'), function() {
                    return $this->getDetails('firstname').PHP_EOL.$this->getDetails('lastname');
                })->onlyOnDetail(),

                Text::make(__('Tenancy address'), 'details->address')
                    ->onlyOnDetail(),

                Text::make(__('Monthly rent'), 'details->rent')
                    ->onlyOnDetail(),

                Number::make(__('Time at this addresss'), 'details->duration')
                    ->onlyOnDetail(),

                Number::make(__('Score from 5'), 'details->score')
                    ->onlyOnDetail(),

                Boolean::make(__('Tenant caused damage?'), 'details->damage')
                    ->onlyOnDetail(),

                Boolean::make(__('Was the property maintained well?'), 'details->maitained')
                    ->onlyOnDetail(),

                Boolean::make(__('Rent always paid on time?'), 'details->ontime')
                    ->onlyOnDetail(),

                Boolean::make(__('Any breach of tenancy?'), 'details->breach')
                    ->onlyOnDetail(),

                Boolean::make(__('Would re-let to the tenant?'), 'details->relet')
                    ->onlyOnDetail(),

                Boolean::make(__('Was the deposit returned?'), 'details->deposit')
                    ->onlyOnDetail(),

                $this->when(! $this->getDetails('deposit'), function() {
                    return Text::make(__('Deposit holding reason'), 'details->deposit_comment')->onlyOnDetail();
                }),
            ]),
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