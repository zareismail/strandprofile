<?php

namespace Zareismail\Strandprofile\Nova; 

use Illuminate\Http\Request;
use Laravel\Nova\Nova;
use Laravel\Nova\Http\Requests\NovaRequest;
use Zareismail\Bonchaq\Contracts\Contractable;
use Zareismail\Chapar\Nova\Letter as Resource; 

class Letter extends Resource
{       
    /**
     * Get the URI key for the resource.
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'sp-'.parent::uriKey();
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
        return $query->authenticate()->orWhere(function($query) use ($request) {
            $user = $request->user();
            
            $query->where('recipient_type', $user->getMorphClass())
                  ->where('recipient_id', $user->id);
        });
    }
    
    /**
     * Determine if this resource is available for navigation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function availableForNavigation(Request $request)
    {
        return false;
    }

    /**
     * Determine if the current user can view the given resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $ability
     * @return bool
     */
    public function authorizedTo(Request $request, $ability)
    {
        return parent::authorizedTo($request, $ability) || $ability === 'view';
    }
}
