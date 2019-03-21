<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessReview extends Model
{
    protected $table = 'process_review';

    protected $fillable = [
        'comments',
        'filename',
        'process_id',
        'created_by',
        'owner_id',
        'review_due_date'
    ];

    protected $dates = [
        'review_due_date',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
