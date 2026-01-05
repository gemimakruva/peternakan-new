<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionCategory extends Model
{
    public $table = 'permission_categories';

    protected $fillable = [
        'name',
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'permission_category_id', 'id');
    }
}
