<?php

namespace App\Events;
use App\Models\User;
use App\Models\Badge;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BadgeUnlocked implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $badge;

    public function __construct(User $user, Badge $badge)
    {
        $this->user = $user;
        $this->badge = $badge;
    }

    // Broadcast on a private channel
    public function broadcastOn()
    {
        return ['user-badges.' . $this->user->id];
    }

    public function broadcastAs()
    {
        return 'badge.unlocked';
    }
}
