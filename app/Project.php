<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    public $timestamps = true;
    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_updated';
    protected $fillable = ['name', 'url', 'info'];
}
