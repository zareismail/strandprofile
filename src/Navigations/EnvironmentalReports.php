<?php

namespace Zareismail\Strandprofile\Navigations; 
 
use Zareismail\QuickTheme\Navigation;
use Zareismail\Shaghool\Nova\ConsumptionReport;

class EnvironmentalReports extends Navigation 
{      
    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Environmental Records');
    }

    /**
     * Get the logical group associated with the resource.
     *
     * @return string
     */
    public static function group()
    { 
        return (string) view('hafiz::icons.environmental');
    } 

    /**
     * Get the router name.
     *
     * @return string
     */
    public static function name()
    {
        return 'index';
    }

    /**
     * Get the routers.
     *
     * @return string
     */
    public static function params(): array
    {
        return [
            'resourceName' => ConsumptionReport::uriKey(), 
        ];
    } 
}
