<?php

namespace Zareismail\Strandprofile\Navigations; 
 
use Zareismail\QuickTheme\Navigation;

class ReportEnvironmental extends EnvironmentalReports 
{       
    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Record Environmental');
    }

    /**
     * Get the router name.
     *
     * @return string
     */
    public static function name()
    {
        return 'create';
    } 
}
