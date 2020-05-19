<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class BchClient extends Model
{
    use HasHashSlug;
    
    protected $table = "bch_clients";
    
    protected $guarded = [];
    
    public function requests() {
        return $this->hasMany('App\BchRequest');
    }
}
