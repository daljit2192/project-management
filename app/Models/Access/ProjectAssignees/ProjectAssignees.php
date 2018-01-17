<?php

namespace App\Models\Access\ProjectAssignees;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class ProjectAssignees.
 */
class ProjectAssignees extends Authenticatable
{
    use SoftDeletes;
    protected $table = 'projects_assignees';
    protected $fillable = ['id', 'user_id', 'project_id', 'created_by', 'deleted_at', 'created_at', 'updated_at'];

    /*
     * Assignee table  association with user table.
     */
    public function user() {
        return $this->hasOne('App\Models\Access\User\User', 'id', 'user_id');
    }
    
    public function project() {
        return $this->hasOne('App\Models\Access\Project\Project', 'id', 'project_id');
    }

}
