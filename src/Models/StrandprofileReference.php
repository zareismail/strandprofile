<?php

namespace Zareismail\Strandprofile\Models;
 
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Zareismail\NovaContracts\Models\AuthorizableModel; 


class StrandprofileReference extends AuthorizableModel  
{
    use HasFactory, SoftDeletes;   

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tenancy_date' => 'datetime',
    ]; 
}
