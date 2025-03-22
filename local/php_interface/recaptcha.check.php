<?
if ($_REQUEST["AJAX_CALL"] == "Y" && $_REQUEST["PostAction"] == "Add" && $_REQUEST["EMAIL"]) {

    global $APPLICATION;

    $g_recaptcha_response = $_REQUEST["g_recaptcha_response"];
    if (!empty($g_recaptcha_response)) {
        $ch = curl_init();
        // set url
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify?secret=6LeSmfwqAAAAAPE5XwyYoAc9S8XsX9tC_s3fQJ2J&response=" . $g_recaptcha_response . "&remoteip=" . $_SERVER["REMOTE_ADDR"]);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string
        $output = curl_exec($ch);
        // close curl resource to free up system resources
        curl_close($ch);
        $response = json_decode($output, true);
        $g_recaptcha_response_check = false;

        if (($response["success"] and $response["score"] >= 0.5 and $response["action"] == 'feedback')) {
            $g_recaptcha_response_check = true;
        }

        if (!$g_recaptcha_response_check) {
            $APPLICATION->ThrowException('Не пройдена проверка Google reCAPTCHA v3.');
            die();
        }
    }
    else {
        $APPLICATION->ThrowException('Не пройдена проверка Google reCAPTCHA v3.');
        die();
    }

}

