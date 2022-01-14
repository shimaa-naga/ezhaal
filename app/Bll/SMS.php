<?php

namespace App\Bll;

class SMS
{
    private $template_id = "61540c92fa52681759310071";
    private $authkey = "367048AqWZK5ag613b6782P1";
    private $error = "";
    private $response = "";
    public function getResponse()
    {
        return $this->response;
    }
    public function getError()
    {
        return $this->error;
    }
    public function send($mobile)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.msg91.com/api/v5/otp?template_id={$this->template_id}&mobile=$mobile&authkey={$this->authkey}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{\"Value1\":\"Param1\",\"Value2\":\"Param2\",\"Value3\":\"Param3\"}",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $this->error = "cURL Error #:" . $err;

            return false;
        } else {
            $this->response =json_decode( $response);
            return true ;
        }
    }
}
