<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class BchRequest extends Model
{
    use HasHashSlug;
    
    protected $table = "bch_requests";
    
    protected $guarded = [];
    
    public function client() {
        return $this->belongsTo('App\BchClient');
    }
    
    public function requestServices() {
        return $this->hasMany('App\BchRequestService');
    }
}
