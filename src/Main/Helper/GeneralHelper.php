<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 13/11/2557
 * Time: 10:24 น.
 */

namespace Main\Helper;

class GeneralHelper {
    public static function url_socket() {
        return 'ws://'.gethostname().':8081';
    }

    public static function base_url(){
        return 'http://localhost/hospital_queue';
    }

    public static function curl_post($url, $data=null)
    {
        $data = is_array($data) ? http_build_query($data) : $data ;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);

        curl_close ($ch);

        return json_decode($server_output, true);
    }

}