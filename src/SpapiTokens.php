<?php

namespace Zerotoprod\SpapiTokens;

use Zerotoprod\CurlHelper\CurlHelper;

class SpapiTokens
{
    /**
     * @param  string       $url
     * @param  string       $access_token
     * @param  string       $path
     * @param  array        $dataElements
     * @param  string|null  $targetApplication
     * @param  string|null  $user_agent
     *
     * @return array{info: mixed, error: string, response: array{restrictedDataToken: string, expiresIn: integer}}
     * @link https://developer-docs.amazon.com/sp-api/docs/tokens-api-v2021-03-01-reference
     */
    public static function restrictedDataToken(string $url, string $access_token, string $path, array $dataElements = [], ?string $targetApplication = null, ?string $user_agent = null): array
    {
        $CurlHandle = curl_init($url);

        curl_setopt_array($CurlHandle, [
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                "x-amz-access-token: $access_token",
                'user-agent: '.($user_agent ?: '(Language=PHP/'.PHP_VERSION.'; Platform='.php_uname('s').'/'.php_uname('r').')')
            ],
            CURLOPT_POSTFIELDS => json_encode([
                'restrictedResources' => [
                    [
                        'method' => 'GET',
                        'path' => $path,
                        'dataElements' => $dataElements
                    ]
                ],
                'targetApplication' => $targetApplication
            ]),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
        ]);

        $response = curl_exec($CurlHandle);
        $info = curl_getinfo($CurlHandle);
        $error = curl_error($CurlHandle);
        $header_size = curl_getinfo($CurlHandle, CURLINFO_HEADER_SIZE);

        curl_close($CurlHandle);

        return [
            'info' => $info,
            'error' => $error,
            'headers' => CurlHelper::parseHeaders($response, $header_size),
            'response' => json_decode(substr($response, $header_size), true)
        ];
    }
}