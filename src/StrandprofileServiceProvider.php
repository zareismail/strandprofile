<?php

namespace Zareismail\Strandprofile;
 
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Laravel\Nova\Nova as LaravelNova; 
use Zareismail\Hafiz\Helper; 

class StrandprofileServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Models\StrandprofileAccount::class => Policies\Account::class, 
        Models\StrandprofileInsurance::class => Policies\Insurance::class, 
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations'); 
        LaravelNova::serving([$this, 'servingNova']);  
        $this->registerNovaRedirector();
        $this->registerPolicies();
        $this->routes(); 
    } 

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    } 

    public function registerNovaRedirector()
    {
        $this->app->make(\Illuminate\Contracts\Http\Kernel::class)
                    ->pushMiddleware(Http\Middleware\RedirectToNova::class);
    }

    /**
     * Register any Nova services.
     *
     * @return void
     */
    public function servingNova()
    {
        \Config::set('whisper.resource.users', \Zareismail\NovaContracts\Nova\User::class);

        LaravelNova::resources([
            Nova\Account::class,
            Nova\Insurance::class, 
            Nova\Profile::class,
            Nova\Verification::class,
            Nova\PersonalDetail::class,
            Nova\Tenant::class,
            Nova\Landlord::class, 
            Nova\Stripe::class, 
        ]); 

        LaravelNova::tools([
            \Zareismail\QuickTheme\QuickTheme::cards([
                tap(\Zareismail\Cards\Profile::make(), function($profile) {
                    $profile->resourceUsing(Nova\Profile::class)->avatarUsing(function($user) {
                        if($path = data_get($user, 'profile.image')) {
                            return \Storage::disk('public')->url($path);
                        } 
                    });
                }),
            ])
            ->navigations([
                Navigations\Tenancy::class,
                Navigations\PreviousTenancy::class,
                Navigations\Payments::class, 
                Navigations\Maturity::class,
                Navigations\Apartment::class,
                Navigations\PreviousApartments::class,
                Navigations\ReportProblem::class,
                Navigations\Issues::class,
                Navigations\SendToLandlord::class,
                Navigations\Letters::class,
                Navigations\Notifications::class,
                Navigations\ReportEnvironmental::class,
                Navigations\EnvironmentalReports::class,
            ])
            ->canSee(function($request) { 
                return ! $request->expectsJson() && Helper::isTenant($request->user());
            }),
        ]);
    } 

    public function routes()
    {  
        Route::any('/user/{user}/maturity/{maturity}/verify', [
            'uses'  => Http\Controllers\StripeVerifyController::class.'@handle',
            'as'    => 'stripe.verify',
        ]);  

        Route::middleware(['nova'])->post('/nova-api/{resource}/checkout', [
            'uses'  => Http\Controllers\StripeCheckoutController::class.'@handle',
            'as'    => 'stripe.checkout',
        ]); 
    } 
}
