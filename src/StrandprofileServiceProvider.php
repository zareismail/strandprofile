<?php

namespace Zareismail\Strandprofile;
 
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
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
        $this->registerPolicies();
    } 

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    } 

    /**
     * Register any Nova services.
     *
     * @return void
     */
    public function servingNova()
    {
        LaravelNova::resources([
            Nova\Account::class,
            Nova\Insurance::class, 
            Nova\Profile::class,
            Nova\Tenant::class,
            Nova\Landlord::class, 
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
                Navigations\Maturity::class,
                Navigations\Payments::class, 
                Navigations\Apartment::class,
                Navigations\PreviousApartments::class,
                Navigations\ReportProblem::class,
                Navigations\Issues::class,
                Navigations\SendToOwner::class,
                Navigations\Letters::class,
                Navigations\ReportEnvironmental::class,
                Navigations\EnvironmentalReports::class,
            ])
            ->canSee(function($request) { 
                return ! $request->expectsJson() && Helper::isTenant($request->user());
            }),
        ]);
    } 
}
