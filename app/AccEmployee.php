<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AccEmployee extends Model
{
    use HasHashSlug;
    
    protected $table = "acc_employees";
    
    protected $guarded = [];
    
    public function activities() {
        return $this->hasMany('App\BchActivity');
    }
    
    public function employeeRoles() {
        return $this->hasMany('App\AccEmployeeRole');
    }
    
    public function investigator() {
        return $this->hasOne('App\BchInvestigator');
    }
}
