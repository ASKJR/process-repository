<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessCategory extends Model
{
    protected $table = 'process_category';

    const PUBLIC_PERMISSION = 'public';
    const RESTRICTED_PERMISSION = 'restricted';

    protected $fillable = ['name', 'permission', 'visibility'];

    protected $dates = ['created_at'];

    public function getVisibilityTranslatedAttribute()
    {
        return ($this->visibility == 'public') ? 'Pública' : 'Restrita';
    }

    public function getVisibilityIconAttribute()
    {
        return ($this->visibility == 'public') ? "<i class='fas fa-lock-open'></i>" : "<i class='fas fa-lock'></i>";
    }
}
