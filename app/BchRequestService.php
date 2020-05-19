<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class BchRequestService extends Model
{
    use HasHashSlug;
    
    protected $table = "bch_request_services";
    
    protected $guarded = [];
    
    public function request() {
        return $this->belongsTo('App\BchRequest');
    }
    
    public function service() {
        return $this->belongsTo('App\BchService');
    }
    
    public function requestRequirements() {
        return $this->hasMany('App\BchRequestRequirement');
    }
}
