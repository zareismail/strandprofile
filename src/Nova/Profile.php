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

            $this->merge(function() use ($request) {
                return $this->maturities($request)->map(function($maturity) {
                    return StripeCheckout::make($maturity->title())
                                ->endpoint(route('stripe.checkout', Maturity::uriKey()))
                                ->key(Stripe::option('publishable_key'))
                                ->currency('usd')
                                ->amount($maturity->contract->amount)
                                ->customAmount()
                                ->params([ 
                                    'resourceId'=> $maturity->id,
                                ]);
                })->all();  
            }),
        ];
    }

    public function maturities($request)
    {
        return Maturity::newModel()
                    ->limit(2)
                    ->latest()
                    ->authenticate()
                    ->orderBy('installment')
                    ->with('contract')
                    ->whereHas('contract')
                    ->whereNull('tracking_code')
                    ->get()
                    ->mapInto(Maturity::class);
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