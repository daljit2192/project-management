<?php

namespace App\Models\Access\Project;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Project.
 */
class Project extends Authenticatable
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    
    protected $fillable = ['handle', 'name','status','created_by', 'description', 'privacy_status', 'created_at', 'updated_at'];

    public function statuses() {
        return $this->hasMany('App\Models\Access\Statuses\Statuses', 'id', 'status');
    } 

    public function user() {
        return $this->hasMany('App\Models\Access\User\User', 'id', 'created_by');
    }

    public function assignees() {
        return $this->hasMany('App\Models\Access\ProjectAssignees\ProjectAssignees', 'project_id', 'id');
    }

}
