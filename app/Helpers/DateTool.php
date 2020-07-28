<?php


namespace App\Helpers;


class DateTool
{
    /**
     * 絶対時間表記のデータを人間が認識しやすい相対時間表記に変更します。
     *
     * @param $unix
     * @return string|null 相対時間
     */
    public static function convert_to_relative_time($unix)
    {
        $unix = strtotime($unix);
        if ($unix === false) {
            return null;
        }
        $now        = time();
        $diff_sec   = $now - $unix;
        if ($diff_sec <= 1) {
            return trans('Now');
        }
        if ($diff_sec < 60) {
            $output = sprintf(trans('%d second(s) ago'), $diff_sec);
        } elseif ($diff_sec < 3600) {
            $output = sprintf(trans('%d minute(s) ago'), $diff_sec / 60);
        } elseif ($diff_sec < 86400) {
            $output = sprintf(trans('%d hour(s) ago'), $diff_sec / 3600);
        } elseif ($diff_sec < 2764800) {
            $output = sprintf(trans('%d day(s) ago'), $diff_sec / 86400);
        } else {
            if (date('Y') !== date('Y', $unix)) {
                $output = date(trans('F jS, Y'), $unix);
            } else {
                $output = date(trans('F jS'), $unix);
            }
        }
        return $output;
    }

    /**
     * 絶対時間表記のデータを人間が認識しやすい相対時間表記に変更します。
     *
     * @param $unix
     * @return string|null 相対時間
     */
    public static function abs2rel($unix)
    {
        return self::convert_to_relative_time($unix);
    }

    /**
     * 絶対時間表記のデータを人間が認識しやすい相対時間表記に変更します。
     *
     * @param $unix
     * @return string|null 相対時間
     */
    public static function rel($unix)
    {
        return self::convert_to_relative_time($unix);
    }
}
