<?php

namespace App\Misc;

class Social
{
    public static function shareToFacebook($url, $appId = null)
    {
        $query = [
            'u' => $url,
        ];

        if ($appId) {
            $query['app_id'] = $appId;
        }

        return 'https://www.facebook.com/sharer/sharer.php?' . http_build_query($query);
    }

    public static function shareToGooglePlus($url)
    {
        $query = [
            'url' => $url,
        ];

        return 'https://plus.google.com/share?' . http_build_query($query);
    }

    public static function shareToOdnoklassniki($url)
    {
        $query = [
            'st._surl' => $url,
        ];

        return 'http://www.ok.ru/dk?st.cmd=addShare&st.s=1&' . http_build_query($query);
    }

    public static function shareToTwitter($url, $status = null)
    {
        $query = [
            'status' => ($status ? $status . "\n" : '') . $url,
        ];

        return 'https://twitter.com/home?' . http_build_query($query);
    }

    public static function shareToVkontakte($url)
    {
        $query = [
            'url' => $url,
        ];

        return 'http://vkontakte.ru/share.php?' . http_build_query($query);
    }
}
