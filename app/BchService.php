<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class BchService extends Model
{
    use HasHashSlug;
    
    protected $table = "bch_services";
    
    protected $guarded = [];
    
    public function requirements() {
        return $this->hasMany('App\BchRequirement');
    }
    
    public function requestServices() {
        return $this->hasMany('App\BchRequestService');
    }
}
