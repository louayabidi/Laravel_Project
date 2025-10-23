<?php

namespace App\Services;

use App\Models\User;
use App\Models\Badge;
use App\Models\BadgeProgress;
use App\Events\BadgeUnlocked;
class BadgeService
{
    public function addPoints(User $user, Badge $badge, int $points)
    {
        $progress = BadgeProgress::firstOrCreate(
            ['user_id' => $user->id, 'badge_id' => $badge->id],
            ['current_points' => $badge->criteria, 'is_completed' => false]
        );

        if ($progress->is_completed) return;

        $progress->current_points -= $points;

        if ($progress->current_points <= 0) {
            $progress->current_points = 0;
            $progress->is_completed = true;
            $user->badges()->syncWithoutDetaching($badge->id);
        }
        if ($progress->is_completed) {
            event(new BadgeUnlocked($user, $badge));
        }
        $progress->save();
    }

    public function initUserProgress(User $user)
    {
        $badges = Badge::all();
        foreach ($badges as $badge) {
            BadgeProgress::firstOrCreate(
                ['user_id' => $user->id, 'badge_id' => $badge->id],
                ['current_points' => $badge->criteria, 'is_completed' => false]
            );
        }
    }

    public function initBadgeProgress(Badge $badge)
    {
        $users = User::all();
        foreach ($users as $user) {
            BadgeProgress::firstOrCreate(
                ['user_id' => $user->id, 'badge_id' => $badge->id],
                ['current_points' => $badge->criteria, 'is_completed' => false]
            );
        }
    }
}
