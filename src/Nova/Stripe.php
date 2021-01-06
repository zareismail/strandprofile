<?php

namespace Zareismail\Strandprofile\Nova; 

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;   
use Zareismail\NovaContracts\Nova\BiosResource;

class Stripe extends BiosResource
{    
    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    { 
        return [  
            Text::make(__('Publishable key'), static::prefix('publishable_key')) 
                ->required()
                ->rules('required'),

            Text::make(__('Secret key'), static::prefix('secret_key')) 
                ->required()
                ->rules('required'), 
        ];
    }
}