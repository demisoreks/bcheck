<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class BchRequestRequirement extends Model
{
    use HasHashSlug;
    
    protected $table = "bch_request_requirements";
    
    protected $guarded = [];
    
    public function requestService() {
        return $this->belongsTo('App\BchRequestService');
    }
    
    public function requirement() {
        return $this->belongsTo('App\BchRequirement');
    }
}
