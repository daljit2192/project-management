<?php

namespace App\Models\Access\Comment;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use JWTAuth;

/**
 * Class Comment.
 */
class Comment extends Authenticatable
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    protected $fillable = ['name','type_id', 'user_id','message', 'source_id', 'updated_at'];

    public function user() {
        return $this->hasOne('App\Models\Access\User\User', 'id', 'user_id');
    }

}
