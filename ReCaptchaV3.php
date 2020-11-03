<?php
/**
 * User: Black_Core
 * Date: 03/11/2020
 * Time: 11:46
 */

class ReCaptchaV3
{
    const SITE_KEY = '';
    const SECRET_KEY = '';
    const CAPTCHA_CHECK_URL = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * Проверяет юзера, возвращает объект с данными проверки
     * @param $userKey
     * @return object
     * {
     *   "success": true|false,
     *   "challenge_ts": timestamp,  // timestamp of the challenge load (ISO format yyyy-MM-dd'T'HH:mm:ssZZ)
     *   "hostname": string,         // the hostname of the site where the reCAPTCHA was solved
     *   "error-codes": [...]        // optional
     *   }
     */
    public static function captchaCheck ($userKey) {
        $response = file_get_contents(self::CAPTCHA_CHECK_URL . "?secret=".self::SECRET_KEY."&response=".$userKey);
        return json_decode($response);
    }

    /**
     * Прверяет юзера, возвращает true если юзер вероятнее всего человек (0.5 балов Google NoCaptcha)
     * @param $userKey
     * @return boolean
     */
    public static function isHuman ($userKey) {
        $result = self::captchaCheck($userKey);
        if ($result->success && $result->score > 0.5) {
            return true;
        }
        return false;
    }
}
