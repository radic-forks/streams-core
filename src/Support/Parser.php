<?php

namespace Streams\Core\Support;

use Illuminate\Config\Repository;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * The parser contains values that are used when calling {@see \Illuminate\Support\Str::parse()}.
 * Streams parses variables within strings to allow dynamic configuration.
 *
 * @link https://streams.dev/docs/core/parser
 * @see \Streams\Core\Support\Macros\StrParse
 * @example
 * ```php
 * $parsedString = Str::parse('/url/to/{request.query.per_page}')
 *
 */
class Parser extends Repository
{
    static public function data()
    {
        $parsed = parse_url(Request::url());

        $data = [
            'request' => [
                'ip' => Request::ip(),
                'url' => Request::url(),
                'path' => Request::path(),
                'root' => Request::root(),
                'input' => Request::input(),
                'full_url' => Request::fullUrl(),
                'segments' => Request::segments(),
                'uri' => Request::getRequestUri(),
                'query' => Request::getQueryString(),
                'parsed' => array_merge($parsed, [
                    'domain' => explode('.', $parsed['host'])
                ]),
            ],
            'url' => [
                'previous' => URL::previous(),
            ],
            'app' => [
                'base_path' => base_path(),
            ],
            'user' => ($user = Auth::user()) ? (array) $user : null,
        ];

        if ($route = Request::route()) {

            $data['route'] = [
                'uri'                      => $route->uri(),
                'parameters'               => $route->parameters(),
                'parameters.to_urlencoded' => array_map(
                    function ($parameter) {
                        return urlencode($parameter);
                    },
                    array_filter($route->parameters())
                ),
                'parameter_names'          => $route->parameterNames(),
                'compiled'                 => [
                    'static_prefix'     => $route->getCompiled()->getStaticPrefix(),
                    'parameters_suffix' => str_replace(
                        $route->getCompiled()->getStaticPrefix(),
                        '',
                        Request::getRequestUri()
                    ),
                ],
            ];

            // Alias this key variable.
            $data['route']['prefix'] = $data['route']['compiled']['static_prefix'];
        }

        return $data;
    }
}
