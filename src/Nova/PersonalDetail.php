<?php

namespace Zareismail\Strandprofile\Nova; 

use Illuminate\Http\Request;  
use Laravel\Nova\Fields\{Text, Number, Boolean, Select, Date, Country};
use Laravel\Nova\Panel;
use Zareismail\NovaContracts\Nova\User;

class PersonalDetail extends Profile
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
            Country::make(__('Nationality'), 'profile->nationality')
                ->required()
                ->rules('required'),

            Number::make(__('Age'), 'profile->age'),

            Date::make(__('Date Of Birth'), 'profile->birthday')
                ->resolveUsing(function($date) {
                    if(! is_null($date)) {
                        return \Carbon\Carbon::make($date);
                    }
                })
                ->displayUsing(function($date) {
                    if(! is_null($date)) {
                        return \Carbon\Carbon::make($date)->format('Y M d');
                    }
                })->required()
            ->rules('required'),

            Number::make(__('Earning'), 'profile->earning')
                ->required()
                ->rules('required')
                ->hideFromDetail(boolval($request->get('card') == 'profile')),

            Text::make(__('Current Address'), 'profile->current_address')
                ->required()
                ->rules('required')
                ->hideFromDetail(boolval($request->get('card') == 'profile')),

            Text::make(__('Previous Address 1'), 'profile->previous_address->0')
                ->required()
                ->rules('required')
                ->hideFromDetail(boolval($request->get('card') == 'profile')),

            Text::make(__('Previous Address 2'), 'profile->previous_address->1')
                ->nullable()
                ->hideFromDetail(boolval($request->get('card') == 'profile')),

            Text::make(__('Previous Address 2'), 'profile->previous_address->2')
                ->nullable()
                ->hideFromDetail(boolval($request->get('card') == 'profile')), 

            Panel::make(__('Main Income'), [
                Select::make(__('Work Status'), 'profile->work_status')
                    ->required()
                    ->rules('required')
                    ->displayUsingLabels()
                    ->options([
                        'employed' => __('Employed'),
                        'self_employed' => __('Self Employed'),
                    ])
                    ->hideFromDetail(boolval($request->get('card') == 'profile')),

                Select::make(__('Contract Type'), 'profile->contract')
                    ->required()
                    ->rules('required')
                    ->displayUsingLabels()
                    ->options([
                        'permanent' => __('Permanent'),
                        'part_time' => __('Part Time'),
                    ]),

                Text::make(__('Job Title'), 'profile->job_title')
                    ->required()
                    ->rules('required')
                    ->hideFromDetail(boolval($request->get('card') == 'profile')),

                Text::make(__('Company'), 'profile->company')
                    ->required()
                    ->rules('required')
                    ->hideFromDetail(boolval($request->get('card') == 'profile')),

                Boolean::make(__('In probationary period'), 'profile->probationary')
                    ->hideFromDetail(boolval($request->get('card') == 'profile')),

                Date::make(__('In probationary adte'), 'profile->probationary_date')
                    ->resolveUsing(function($date) {
                        if(! is_null($date)) {
                            return \Carbon\Carbon::make($date);
                        }
                    })
                    ->displayUsing(function($date) {
                        if(! is_null($date)) {
                            return \Carbon\Carbon::make($date)->format('Y M d');
                        }
                    })
                    ->nullable()
                    ->hideFromDetail(boolval($request->get('card') == 'profile')),

                Text::make(__('Confirm annual income'), 'profile->annual_income')
                    ->hideFromDetail(boolval($request->get('card') == 'profile')),

                Text::make(__('Employment period'), 'profile->employment')
                    ->hideFromDetail(boolval($request->get('card') == 'profile')),

                Boolean::make(__('Employment may change in 12 months?'), 'profile->change_employment')
                    ->hideFromDetail(boolval($request->get('card') == 'profile')),

                Boolean::make(__('On long term leave'), 'profile->leave')
                    ->hideFromDetail(boolval($request->get('card') == 'profile')),
            ]),

            Panel::make(__('Further Detail'), [  
                Select::make(__('Tenancy Type'), 'profile->tenancy_type')
                    ->default('single')
                    ->rules('required')
                    ->required()
                    ->displayUsingLabels()
                    ->options([
                        'sahre' => __('Share'),
                        'single' => __('Single'),
                    ])
                    ->hideFromDetail(boolval($request->get('card') == 'profile')), 

                Select::make(__('Perefer tenancy period'), 'profile->tenancy_period')
                    ->default('single')
                    ->rules('required')
                    ->required()
                    ->displayUsingLabels()
                    ->options([
                        12 => 12,
                        24 => 24,
                        36 => 36,
                    ])
                    ->hideFromDetail(boolval($request->get('card') == 'profile')), 

                Text::make(__('How children living with you?'), 'profile->children_living')
                    ->nullable()
                    ->hideFromDetail(boolval($request->get('card') == 'profile')), 
            ]),
        ];
    } 
}