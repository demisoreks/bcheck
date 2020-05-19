<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class BchInvestigator extends Model
{
    use HasHashSlug;
    
    protected $table = "bch_investigators";
    
    protected $guarded = [];
    
    public function employee() {
        return $this->hasOne('App\AccEmployee');
    }
}
