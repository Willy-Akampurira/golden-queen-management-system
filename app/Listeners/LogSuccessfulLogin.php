<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin
{
    /**
     * Handle the login event and update the user's last login timestamp.
     */
    public function handle(Login $event): void
    {
        if ($event->user) {
            $event->user->update([
                'last_login_at' => now(),
            ]);
        }
    }
}
