<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class BchRequirement extends Model
{
    use HasHashSlug;
    
    protected $table = "bch_requirements";
    
    protected $guarded = [];
    
    public function service() {
        return $this->belongsTo('App\BchService');
    }
    
    public function requestRequirements() {
        return $this->hasMany('App\BchRequestRequirement');
    }
}
