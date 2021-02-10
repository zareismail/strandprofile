<?php

namespace Zareismail\Strandprofile\Models;
  
use Zareismail\NovaContracts\Models\User as Model; 
use Zareismail\Chapar\Contracts\Recipient;
use Zareismail\Chapar\Concerns\InteractsWithLetters;

class User extends Model implements Recipient
{
	use InteractsWithLetters;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users'; 
}
