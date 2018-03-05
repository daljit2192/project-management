<?php

namespace App\Models\Access\CommentType;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class CommentType.
 */

class CommentType extends Authenticatable {

    use SoftDeletes;

    protected $table = 'comment_type';

    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'name', 'created_by'];    

}
