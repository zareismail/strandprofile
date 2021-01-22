<?php

namespace Zareismail\Strandprofile\Navigations;
 
use Zareismail\StripeCheckout\StripeCheckout;
use Zareismail\Bonchaq\Nova\Maturity as BonchaqMaturity;
use Zareismail\Strandprofile\Nova\Stripe;

class Maturity extends Payments 
{    
    /**
     * Get the router name.
     *
     * @return string
     */
    public static function name()
    {
        return 'create';
    }

    /**
     * Get the routers.
     *
     * @return string
     */
    public static function fields(): array
    {
        return static::maturities()->map(function($maturity) {
            return StripeCheckout::make($maturity->payment_date->format('Y M'))
                        ->endpoint(route('stripe.checkout', BonchaqMaturity::uriKey()))
                        ->key(Stripe::option('publishable_key')) 
                        ->amount($maturity->contract->amount)
                        ->customAmount()
                        ->params([ 
                            'resourceId'=> $maturity->id,
                        ]);
        })->values()->all();
    }


    public static function maturities()
    {
        return BonchaqMaturity::newModel()
                    ->limit(2)
                    ->latest()
                    ->authenticate()
                    ->orderBy('installment')
                    ->with('contract')
                    ->whereHas('contract')
                    ->whereNull('tracking_code')
                    ->get()
                    ->mapInto(BonchaqMaturity::class);
    }
}
