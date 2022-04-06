<?php


namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class QueryTool
{
    public static function explodeAllQueries(Request $request)
    {
        $queries = $request->query();
        $queries_new = [];
        foreach ($queries as $key => $query) {
            if (is_array($query)) {
                foreach ($query as $i => $query_value) {
                    $query_value = trim($query_value);
                    if ($query_value !== '') {
                        $queries_new[$key][] = $query_value;
                    }
                }
                if ($queries_new[$key] !== []) {
                    $queries_new[$key] = implode('.', $queries_new[$key]);
                } else {
                    unset($queries[$key]);
                }
            }
        }
        $queries = array_merge($queries, $queries_new);
        if ($queries_new !== []) {
            return url()->to(URL::current() . '?' . http_build_query($queries));
        }
        return false;
    }
}
