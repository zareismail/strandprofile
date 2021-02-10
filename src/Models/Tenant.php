<?php

namespace Zareismail\Strandprofile\Models;
   

class Tenant extends User 
{ 
	public function references()
	{
		return $this->hasMany(StrandprofileReference::class, 'auth_id');
	}
}
