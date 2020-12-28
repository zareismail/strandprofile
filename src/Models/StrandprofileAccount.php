<?php

namespace Zareismail\Strandprofile\Models; 


class StrandprofileAccount extends Report 
{  
	/**
	 * Return the scope group.
	 * 
	 * @return string
	 */
    public static function resourceScope(): string
    {
    	return \Zareismail\Strandprofile\Nova\Account::class;
    }
}
