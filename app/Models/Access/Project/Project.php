<?php

namespace App\Models\Access\Project;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    protected $fillable = ['name', 'handle', 'status', 'created_by'];

}
