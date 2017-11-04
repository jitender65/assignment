<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Player Model
 *
 * This model associated with the players table.
 *
 * @author Jitender <jitender.thakur@appster.in>
 */
class Player extends Model {

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'image_uri', 'team_id', 'user_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['deleted_at'];

    /**
     * This constant is used for max length of name field.
     */
    const NAME_MAX_LENGTH = 100;

    /**
     * Define an inverse relationship to Category Model.
     *
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Define an inverse relationship to Category Model.
     *
     */
    public function team() {
        return $this->belongsTo(Team::class);
    }

    public function getImageUriAttribute($value) {
        if ($value) {
            return url('/images/players/' . $value);
        } else {
            return $value;
        }
    }

}
