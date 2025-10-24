<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BadgeProgress;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    protected $fillable = ['name','title','description','image','criteria','badge_categorie_id'];

    // explicitly set the foreign key
    public function category()
    {
        return $this->belongsTo(BadgeCategorie::class, 'badge_categorie_id');
    }
    public function users()
{
    return $this->belongsToMany(User::class, 'badge_user')->withTimestamps();
}
    public function progress()
{
    return $this->hasMany(BadgeProgress::class);
}
public function goals()
{
    return $this->hasMany(BadgeGoal::class);
}

protected static function booted()
{
    static::created(function ($badge) {
        // Attach this badge to all existing users with initial progress = 0
        $users = User::all();
        foreach ($users as $user) {
            $user->badgeProgress()->create([
                'badge_id' => $badge->id,
                'current_points' =>  0,
                'is_completed' => false
            ]);
        }
    });
}


}
