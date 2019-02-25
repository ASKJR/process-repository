<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessCategory extends Model
{
    protected $table = 'process_category';

    const PUBLIC_PERMISSION = 'public';
    const RESTRICTED_PERMISSION = 'restricted';

    protected $fillable = ['name', 'permission'];
}
