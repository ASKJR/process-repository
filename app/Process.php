<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $fillable = [
        'name',
        'description',
        'cover',
        'created_by',
        'process_category_id'
    ];

    protected $dates = [
        'created_at'
    ];

    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function category()
    {
        return $this->belongsTo('App\ProcessCategory', 'process_category_id');
    }

    public function reviews()
    {
        return $this->hasMany('App\ProcessReview')->orderBy('created_at', 'DESC');
    }

    public function latestReview()
    {
        return $this->reviews()->limit(1);
    }
}
