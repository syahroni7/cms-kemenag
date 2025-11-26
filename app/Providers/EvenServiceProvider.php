<?php
// app/Listeners/UpdateLastLogin.php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateLastLogin
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(Login $event)
    {
        $event->user->update([
            'last_login_at' => now(), // PERBAIKAN: now() bukan new()
            'last_login_ip' => $this->request->ip(), // PERBAIKAN: ip() bukan zip()
        ]);
    }
}