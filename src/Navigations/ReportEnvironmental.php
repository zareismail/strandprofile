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
    /**
     * Get the router name.
     *
     * @return string
     */
    public static function name()
    {
        return 'create';
    } 

    /**
     * Get the router name.
     *
     * @return string
     */
    public static function query() : array
    { 
        $contracts = request()->user()->load('activeContracts.contractable')->contracts->filter(function($contract) {
            return $contract->contractable_type === HafizApartment::class;
        }); 
        $percapita = PerCapita::newModel()->where('measurable_type', HafizApartment::class)->where('measurable_id', optional($contracts->pop())->contractable_id)->first();
        
        if(is_null($percapita)) {
            return [];
        }
        
        return [
            'viaRelationship' => 'reports',
            'viaResource' => PerCapita::uriKey(),
            'viaResourceId' => optional($percapita)->id,
        ];
    }
}
