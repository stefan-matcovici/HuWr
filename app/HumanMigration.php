<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HumanMigration extends Model
{
    //table name from database
    protected $table = 'human_migrations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'departure_city','departure_country','departure_longitude', 'departure_latitude', 'arrival_city',
        'arrival_country','arrival_longitude','arrival_latitude','adults','children','reason', 'created_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
