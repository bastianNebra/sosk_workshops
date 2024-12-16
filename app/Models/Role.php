<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Permission;
class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public $table = 'role';

    public function users(){
        return $this->hasMany(User::class);
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class,'role_permission_migration');
    }

    
}
