<?php
/**
 * Copyright (c) 2021. YiiMan\apiStorm
 * Authors
 * info@yiiman.ir
 * https://yiiman.ir
 * develop@ariaservice.net
 * https://ariaservice.net
 ******************************************************************************/

namespace YiiMan\ApiStorm\Core;

/**
 * Class Connection
 * @package YiiMan\ApiStorm\Core
 *
 * @property
 */
class Connection
{

    const CONTENT_TYPE_JSON = 'json';
    const CONTENT_TYPE_JSONP = 'jsonp';
    const CONTENT_TYPE_FORM_DATA = 'formdata';
    const CONTENT_TYPE_RAW = 'raw';
    const CONTENT_TYPE_SERIALIZED = 'serialize';

    public $protocol = 'https';
    public $baseURL = '';

    public $responseType = self::CONTENT_TYPE_JSON;

    function call($path, $get = [], $post = [], $cookies = [], $method = 'post')
    {

        $url = ($this->protocol).'://'.$this->baseURL.'/'.$path;
        if (!empty($get)) {
            $url .= '?'.http_build_query($get);
        }


        // Set the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);


        //conten-type
        $headers = [
            "Accept: application/json",
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


        // Time OUT
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);

        // Turn off the server and peer verification (TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // UserAgent
        curl_setopt($ch, CURLOPT_USERAGENT, 'Softaculous');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        // Cookies
        if (!empty($cookies)) {
            curl_setopt($ch, CURLOPT_COOKIESESSION, true);
            curl_setopt($ch, CURLOPT_COOKIE, http_build_query($cookies, '', '; '));
        }

        if (!empty($post)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Get response from the server.

        $resp = curl_exec($ch);
        $httpcode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);


        // The following line is a method to test
        //if(preg_match('/sync/is', $url)) echo $resp;

        $res = new Res();
        if ($httpcode == 200) {
            $res->setSuccess();
        } else {
            $res->setUnSuccess();
        }

        if ($res->isSuccess()) {
            $res->setData($this->parseResponse($resp));
        } else {
            $res->setError($httpcode, $this->parseResponse($resp));
        }

        return $res;
    }


    /**
     *
     * this method will convert data based on $this->responseType
     * @param $data
     * @return mixed
     */
    private function parseResponse($data)
    {
        switch ($this->responseType) {
            case self::CONTENT_TYPE_JSON:
            case self::CONTENT_TYPE_JSONP:
                return json_decode($data);
                break;
            case self::CONTENT_TYPE_FORM_DATA:
            case self::CONTENT_TYPE_RAW:
                return $data;
                break;
            case self::CONTENT_TYPE_SERIALIZED:
                return unserialize($data);
                break;
        }
    }

}