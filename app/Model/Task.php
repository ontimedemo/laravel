<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_updated';
    protected $fillable = ['project_id', 'name', 'created_by', 'status'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id', 'created_by');
    }

    public function asignee()
    {
        return $this->belongsTo(User::class, 'user_id', 'assigned_to');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function logs()
    {
        return $this->hasMany(TimeLog::class);
    }
}
