<?php  

namespace Zareismail\Strandprofile\Http\Controllers;
 
use Laravel\Nova\Nova;
use Laravel\Nova\Http\Requests\NovaRequest;
use Stripe\{Stripe, Checkout\Session}; 
use Zareismail\Bonchaq\Models\BonchaqMaturity;
use Zareismail\Strandprofile\Nova\Stripe as Config;

class StripeCheckoutController extends Controller
{
    public function handle(NovaRequest $request)
    {  
        $resource = $request->findResourceOrFail(); 

        $this->setStripeKey($request);

        $session = Session::create([
            'customer_email' => $request->user()->email, 
            'payment_method_types' => ['card'],
            'line_items' => [[ 
                'quantity' => $request->get('quantity', 1),
                'price_data' => [
                    'currency' => $request->currency ?? 'USD',
                    'unit_amount_decimal' => $request->amount,
                    'product_data' => [
                      'name' => $resource->title() ?? ($resource::label() .' #'. $resource->getKey()), 
                    ],
                ],
            ]],
            'mode' => 'payment',
            'client_reference_id' => $resource->getKey(),
            'success_url' => url(Nova::path().'/resources/maturities/'. $request->resourceId),
            'cancel_url' => url(Nova::path()),
        ]);

        return response()->json([
            'sessionId' => $session->id, 
        ]); 
    }

    public function setStripeKey($request)
    { 
        Stripe::setApiKey(Config::option('secret_key')); 

        $endpoint = \Stripe\WebhookEndpoint::create([
          'url' => route('stripe.verify', [$request->user()->id, $request->resourceId]),
          'enabled_events' => [
            'charge.failed',
            'charge.succeeded',
          ],
        ]);

        return $this;
    }
}
