<?php

namespace Zareismail\Strandprofile\Nova; 

use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany; 
use Laravel\Nova\Http\Requests\NovaRequest; 
use Zareismail\Hafiz\Nova\Registration;
use Zareismail\Hafiz\Helper; 
use NovaButton\Button;

class Tenant extends User
{         
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Zareismail\Strandprofile\Models\Tenant::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $references = HasMany::make(__('References'), 'references', Reference::class);

        if(! $request->isResourceDetailRequest()) {
            return array_merge(parent::fields($request), [
                Button::make(__('Request Identity Verification'), 'request-identity-verification') 
                    ->style('primary-outline')
                    ->onlyOnIndex(),

                $references,
            ]);
        }

        return array_merge(
            parent::fields($request), 
            (new Verification($this->resource))->fields($request),
            (new PersonalDetail($this->resource))->fields($request),
            [$references],
        );
    }

    /**
     * Return the location to redirect the user after update.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Nova\Resource  $resource
     * @return string
     */
    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        return tap(parent::redirectAfterUpdate($request, $resource), function() use ($resource) {
            Helper::ensureIsTenant($resource->resource); 
        });
    }

    /**
     * Return the location to redirect the user after creation.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Nova\Resource  $resource
     * @return string
     */
    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return tap(parent::redirectAfterCreate($request, $resource), function() use ($resource) {
            Helper::ensureIsTenant($resource->resource); 
        });
    }
    
    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->whereHas('roles', function($query) {
            return $query->whereKey(intval(Registration::option('tenant_role')));
        });
    }
    
    /**
     * Determine if the resource should be available for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorizeToViewAny(Request $request)
    {
        return true;
    }


    /**
     * Determine if the resource should be available for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function authorizedToViewAny(Request $request)
    {
        return true;
    }
}
