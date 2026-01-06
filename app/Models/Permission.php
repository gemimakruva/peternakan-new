<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends \Spatie\Permission\Models\Permission
{
    protected $fillable = [
        'permission_category_id',
        'name',
        'modul',
        'guard_name',
    ];

    public function permissionCategory()
    {
        return $this->belongsTo(PermissionCategory::class, 'permission_category_id', 'id');
    }
}
