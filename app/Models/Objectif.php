<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Objectif extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','title', 'description',  'target_value', 'start_date', 'end_date', 'status'
    ];
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

    public function habitudes()
    {
        return $this->hasMany(Habitude::class, 'objectif_id', 'id');
    }
    protected static function booted()
{
    static::deleting(function ($objectif) {
        $objectif->habitudes()->each(function ($habitude) {
            $habitude->delete();
        });
    });
}

}
