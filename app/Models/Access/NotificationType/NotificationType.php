<?php

namespace App\Models\Access\NotificationType;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class NotificationType.
 */

class NotificationType extends Authenticatable {

    use SoftDeletes;

    protected $table = 'notification_type';

    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'name', 'created_by'];    

}
