<?php

namespace Zareismail\Strandprofile\Models;
   

class Tenant extends User 
{ 
	/**
	 * Get the related references.
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\HasOneOrMany
	 */
	public function references()
	{
		return $this->hasMany(StrandprofileReference::class, 'auth_id');
	}
}
