<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class BchActivity extends Model
{
    use HasHashSlug;
    
    protected $table = "bch_activities";
    
    protected $guarded = [];
    
    public function employee() {
        return $this->belongsTo('App\AccEmployee');
    }
}
