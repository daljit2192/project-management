<?php

namespace App\Models\Access\Task;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Access\TaskAssignees\TaskAssignees;
use App\Models\Access\Project\Project;
use JWTAuth;

/**
 * Class User.
 */
class Task extends Authenticatable {

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    
    protected $fillable = ['name', 'tag_name', 'project_id','description', 'status' ,'created_by', 'deleted_at', 'created_at', 'updated_at'];

    public function project() {
        return $this->hasOne('App\Models\Access\Project\Project', 'id', 'project_id');
    }

    public function user() {
        return $this->hasOne('App\Models\Access\User\User', 'id', 'created_by');
    }
    
    public function statuses() {
        return $this->hasMany('App\Models\Access\Statuses\Statuses', 'id', 'status');
    }

    public function priority() {
        return $this->hasMany('App\Models\Access\Priority\Priority', 'id', 'priority_id');
    }
    
}
