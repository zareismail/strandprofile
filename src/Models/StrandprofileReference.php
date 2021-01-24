<?php

namespace Zareismail\Strandprofile\Models;
 
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Zareismail\NovaContracts\Models\AuthorizableModel;
use Zareismail\Strandprofile\Mail\ReferenceRequested; 
use Zareismail\Contracts\Concerns\HasDetails;


class StrandprofileReference extends AuthorizableModel  
{
    use HasFactory, SoftDeletes, HasDetails;   

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tenancy_date' => 'datetime',
    ]; 
    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function($model) {
            if(is_null($model->hash)) {
            	$model->forceFill([
            		'hash' => md5(time(). $model),
            	]); 
            }
        });

        static::saved(function($model) {
            if(! $model->getDetails('filled')) {
                \Mail::to($model->email)->send(new ReferenceRequested($model)); 
            }
        });
    }
}
