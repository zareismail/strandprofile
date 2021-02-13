<?php

namespace Zareismail\Strandprofile;
 
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
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
        Models\Tenant::class => Policies\Tenant::class, 
        Models\Landlord::class => Policies\Landlord::class, 
        Models\StrandprofileAccount::class => Policies\Account::class, 
        Models\StrandprofileInsurance::class => Policies\Insurance::class, 
        Models\StrandprofileReference::class => Policies\Reference::class, 
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'references'); 
        $this->loadJsonTranslationsFrom(__DIR__.'/../resources/lang'); 
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
        Relation::morphMap([
            \Zareismail\NovaContracts\Models\User::class => Models\User::class, 
        ]);

        \Event::listen(\NovaButton\Events\ButtonClick::class, function($event) {
            if($event->key === 'request-identity-verification') {
                $event->resource->notify(new Notifications\IdentityVerification($event->resource));
                

                \Storage::disk('public')->delete(data_get($event->resource, 'profile.passport'));
                \Storage::disk('public')->delete(data_get($event->resource, 'profile.payslip'));

                $event->resource->forceFill([
                    'profile->passport' => null,
                    'profile->payslip'  => null,
                ])->save();
            } 
        });
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
            Nova\Reference::class, 
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
                Navigations\References::class,
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

        Route::view('/references/{reference}', 'references::form');  

        Route::post('/references/{reference}', [
            'uses'  => Http\Controllers\ReferenceUpdateController::class.'@handle',
            'as'    => 'reference.update',
        ]);  

        Route::middleware(['nova'])->post('/nova-api/{resource}/checkout', [
            'uses'  => Http\Controllers\StripeCheckoutController::class.'@handle',
            'as'    => 'stripe.checkout',
        ]); 
    } 
}
