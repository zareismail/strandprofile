<?php

namespace Zareismail\Strandprofile\Nova; 

use Illuminate\Http\Request;  
use Laravel\Nova\Fields\{ID, Text, Number, Avatar};
use Zareismail\NovaContracts\Nova\User;
use Zareismail\StripeCheckout\StripeCheckout;
use Zareismail\Bonchaq\Nova\Maturity;

class Profile extends User
{    
    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

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

            StripeCheckout::make(__('Make Payment'))
                ->endpoint(route('stripe.checkout', Maturity::uriKey()))
                ->key(Stripe::option('publishable_key'))
                ->amount(1000)
                ->customAmount()
                ->params([ 
                    'resourceId'=> 96,
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