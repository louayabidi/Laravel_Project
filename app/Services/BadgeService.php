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
    public function calculateBadgePoints(User $user, array $data)
{
    $badges = Badge::with('goals')->get();

    foreach ($badges as $badge) {
        $progress = BadgeProgress::firstOrCreate(
            ['user_id' => $user->id, 'badge_id' => $badge->id],
            ['current_points' => 0, 'is_completed' => false]
        );

        if ($progress->is_completed) continue;

        $totalPoints = 0;

        foreach ($badge->goals as $goal) {
            $field = $goal->field;
            $comparison = $goal->comparison;
            $value = $goal->value;
            $points = $goal->points;

            if (!isset($data[$field])) continue;

            switch ($comparison) {
                case '>=':
                    if ($data[$field] >= $value) $totalPoints += $points;
                    break;
                case '<=':
                    if ($data[$field] <= $value) $totalPoints += $points;
                    break;
            }
        }

        // Update progress
        $progress->current_points += $totalPoints;

        // Mark badge completed if points >= badge criteria
        if ($progress->current_points >= $badge->criteria) {
            $progress->is_completed = true;
            $progress->current_points = $badge->criteria;

            // Assign badge to user
            $user->badges()->syncWithoutDetaching($badge->id);

            // Optional: trigger notification/event
            event(new \App\Events\BadgeUnlocked($user, $badge));
        }

        $progress->save();
    }
}

}
