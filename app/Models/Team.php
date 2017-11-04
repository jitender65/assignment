<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Team Model
 *
 * This model associated with the sections table.
 *
 * @author Jitender <jitender.thakur@appster.in>
 */
class Team extends Model {

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'logo_uri'];

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
     * Define an inverse relationship to User Model.
     *
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * The relation to players
     *
     */
    public function players() {
        return $this->hasMany(Player::class, 'team_id');
    }

    public function getLogoUriAttribute($value) {
        if ($value) {
            return url('/images/teams/' . $value);
        } else {
            return $value;
        }
    }

}
