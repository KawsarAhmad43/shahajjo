<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait SMSTrait
{
    protected function sendSms($contacts = null, $msg = null)
    {
        $apiKey = '';
        $contacts = $contacts;
        $type = 'text';
        // $sender     = "";
        $sender = '';
        $msg = urlencode($msg);

        $url = "https://880sms.com/smsapi?api_key={$apiKey}&senderid={$sender}&type={$type}&msg={$msg}&contacts={$contacts}";

        $res = Http::get($url);

        return $res->successful();
    }
}

/**
 * use your controller.
 *
 * @return $this
 */

/******************************************
    use App\Traits\SMSTrait;
    use SMSTrait; //use it inside the controller

    $this->sendSms("01883847733", "SMS Send successfully");
 */
