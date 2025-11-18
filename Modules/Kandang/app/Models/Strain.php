<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Strain extends Model
{
    use SoftDeletes; 
    protected $table = 'strains';
    protected $dates = ['deleted_at'];
}
