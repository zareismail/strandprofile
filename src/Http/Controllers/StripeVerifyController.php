<?php  

namespace Zareismail\Strandprofile\Http\Controllers;
 
use Laravel\Nova\Nova;
use Laravel\Nova\Http\Requests\NovaRequest; 
use Zareismail\NovaContracts\Models\user; 
use Zareismail\Bonchaq\Models\BonchaqMaturity; 
use Zareismail\Strandprofile\Notifications\{PaymentVerified, PaymentFailed};

class StripeVerifyController extends Controller
{
    public function handle(NovaRequest $request, $user, $maturity)
    {  
        $user = User::findOrFail($user);

        \Auth::login($user);

        $maturity = BonchaqMaturity::findOrFail($maturity);

        if(request()->input('type') == 'charge.succeeded') {
            // success  
            $maturity->forceFill([
                'amount' => $request->input('data.object.amount'),
                'tracking_code' => $request->input('data.object.id'),
                'payment_date'  => now(),
                'details' => request()->all(),
                'auth_id' => $user->id,
            ])->save();

            $user->notify(new PaymentVerified($maturity, [
                'amount' => $request->input('data.object.amount'),
                'receipt_url' => $request->input('data.object.receipt_url'), 
            ]));
        } else {
            // failed 
            $user->notify(new PaymentFailed([
                'amount' => $request->input('data.object.amount'),
                'receipt_url' => $request->input('data.object.receipt_url'), 
            ]));
        } 
    } 
}  