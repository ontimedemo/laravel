<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_updated';
    protected $fillable = ['name', 'url', 'info'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
