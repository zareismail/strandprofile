<?php

namespace Zareismail\Strandprofile\Nova; 

use Illuminate\Http\Request; 
use Laravel\Nova\Http\Requests\NovaRequest;
use Zareismail\Maintainable\Nova\Issue as Resource; 

class Issue extends Resource
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
        return $query->authenticate();
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
}
