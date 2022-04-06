<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\HtmlString;
use Str;

class Util
{
    /**
     * @param int $length
     * @return string
     */
    public static function randomHex(int $length): string
    {
        try {
            return $length % 2 === 0
                ? bin2hex(random_bytes($length / 2))
                : substr(bin2hex(random_bytes(($length + 1) / 2)), 1);
        } catch (Exception $e) {
            return Str::random($length);
        }
    }

    public static function link(string $data): HtmlString
    {
        $content = str_replace("\n", "<br>", e($data));
        $content = preg_replace('/(#(([0-9A-Za-zＡ-Ｚａ-ｚ０-９ー～_]|\p{Hiragana}|\p{Katakana}|\p{Han}|\p{Hangul})+))/u', '<a href="/search?tags=$2">#$2</a>', $content);

        return new HtmlString($content);
    }

    /**
     * Laravel向けにラップしたnl2br関数です
     *
     * @param $data
     * @return HtmlString
     */
    public static function nl2br($data): HtmlString
    {
        return new HtmlString(nl2br($data));
    }

    public static function flattenOptions(array|Collection $data): array
    {
        $result = [];
        foreach($data as $value) {
            if (isset($value['value']))
                $result[$value['value']] = $value['label'];
            if (isset($value['options']))
                $result = array_merge($result, static::flattenOptions($value['options']));
        }

        return $result;
    }

    public static function validate($data, string|array $rules): bool
    {
        $validator = Validator::make(['data' => $data], [
            'data' => $rules,
        ]);

        return $validator->passes();
    }

    public static function getJsLang(): array
    {
        $langRaw = Lang::get('javascript');
        $lang = [];
        foreach ($langRaw as $key => $value) {
            $lang[str_replace(' ', '', lcfirst(ucwords($key)))] = $value;
        }
        return $lang;
    }
}
