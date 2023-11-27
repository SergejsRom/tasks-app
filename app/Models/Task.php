<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status_id',
        'user_id',
        'tags',
        'created_by',
    ];

    public function status(): BelongsTo {
        return $this->belongsTo(Status::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function tags(): BelongsToMany{
        return $this->belongsToMany(Tag::class);
    }

}
