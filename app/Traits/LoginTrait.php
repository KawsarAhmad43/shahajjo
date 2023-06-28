<?php

namespace App\Traits;

use App\Models\UserLoginHistory;
use Illuminate\Support\Carbon;

trait LoginTrait
{
    public function storeLoginDetails($id, $guard)
    {
        $data = [
            'user_id' => $id,
            'user_guard' => $guard,
            'login_at' => Carbon::now()->toDateTimeString(),
            'login_ip' => request()->getClientIp(),
            'login_browser_client' => $this->getBrowserName(),
        ];

        return UserLoginHistory::create($data);
    }

    public function getBrowserName()
    {
        $request = request();
        $userAgent = $request->header('User-Agent');
        $browser = '';

        if (preg_match('/MSIE/i', $userAgent) && ! preg_match('/Opera/i', $userAgent)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Mozilla Firefox';
        } elseif (preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Google Chrome';
        } elseif (preg_match('/Safari/i', $userAgent)) {
            $browser = 'Apple Safari';
        } elseif (preg_match('/Opera/i', $userAgent)) {
            $browser = 'Opera';
        } elseif (preg_match('/Netscape/i', $userAgent)) {
            $browser = 'Netscape';
        }

        return $browser;
    }
}
