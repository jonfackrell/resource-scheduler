<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Mail\TransportManager;

use Closure;
use Mail;
use Config;
use App;

class MailOverride
{

    public function handle($request, Closure $next)
    {
        $emailSettings = App\Models\EmailSetting::first();

        $conf = [
            'driver' => 'smtp',
            'host' => $emailSettings->outgoing_host,
            'port' => $emailSettings->outgoing_port,
            'from' => [
                'address' => $emailSettings->from_address,
                'name' => $emailSettings->from_name,
            ],
            'encryption' => $emailSettings->encryption,
            'username' => $emailSettings->username,
            'password' => $emailSettings->password,
            'sendmail' => '/usr/sbin/sendmail -bs',
            'pretend' => false,
        ];

        Config::set('mail', $conf);

        $app = App::getInstance();
        $app->register('Illuminate\Mail\MailServiceProvider');

        return $next($request);
    }
}