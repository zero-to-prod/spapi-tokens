<?php

namespace Zerotoprod\SpapiTokens;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Zerotoprod\Container\Container;
use Zerotoprod\CurlHelper\CurlHelper;
use Zerotoprod\SpapiTokens\Contracts\SpapiTokensInterface;
use Zerotoprod\SpapiTokens\Support\Testing\SpapiTokensFake;

class SpapiTokens implements SpapiTokensInterface
{
    /**
     * @var string
     */
    private $access_token;
    /**
     * @var string
     */
    private $targetApplication;
    /**
     * @var string
     */
    private $base_uri;
    /**
     * @var string|null
     */
    private $user_agent;
    /**
     * @var array
     */
    private $options;

    /**
     * Instantiate this class.
     *
     * @param  string       $access_token       Access token to validate the request.
     * @param  string       $targetApplication  The application ID for the target application to which access is being delegated.
     * @param  string       $base_uri           The base URI for the Orders API
     * @param  string|null  $user_agent         The user-agent for the request. If none is supplied, a default one will be provided.
     * @param  array        $options            Merve curl options.
     *
     * @see  https://developer-docs.amazon.com/sp-api/docs/tokens-api-v2021-03-01-reference
     * @link https://github.com/zero-to-prod/spapi-tokens
     */
    public function __construct(
        string $access_token,
        string $targetApplication,
        string $base_uri = 'https://sellingpartnerapi-na.amazon.com/tokens/2021-03-01/restrictedDataToken',
        ?string $user_agent = null,
        array $options = []
    ) {
        $this->access_token = $access_token;
        $this->targetApplication = $targetApplication;
        $this->base_uri = $base_uri;
        $this->user_agent = $user_agent;
        $this->options = $options;
    }

    /**
     * Instantiate this class.
     *
     * @param  string       $access_token       Access token to validate the request.
     * @param  string       $targetApplication  The application ID for the target application to which access is being delegated.
     * @param  string       $base_uri           The base URI for the Orders API
     * @param  string|null  $user_agent         The user-agent for the request. If none is supplied, a default one will be provided.
     * @param  array        $options            Merve curl options.
     *
     * @return SpapiTokensInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @see  https://developer-docs.amazon.com/sp-api/docs/tokens-api-v2021-03-01-reference
     * @link https://github.com/zero-to-prod/spapi-tokens
     */
    public static function from(
        string $access_token,
        string $targetApplication,
        string $base_uri = 'https://sellingpartnerapi-na.amazon.com/tokens/2021-03-01/restrictedDataToken',
        ?string $user_agent = null,
        array $options = []
    ): SpapiTokensInterface {
        return Container::getInstance()->has(SpapiTokensFake::class)
            ? Container::getInstance()->get(SpapiTokensFake::class)
            : new self($access_token, $targetApplication, $base_uri, $user_agent, $options);
    }

    /**
     * @inheritDoc
     */
    public function createRestrictedDataToken(
        string $path,
        array $dataElements = [],
        array $options = []
    ): array {
        $CurlHandle = curl_init();

        curl_setopt_array(
            $CurlHandle,
            [
                CURLOPT_URL => $this->base_uri,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => [
                    'accept: application/json',
                    'content-type: application/json',
                    "x-amz-access-token: $this->access_token",
                    'user-agent: '.($this->user_agent ?: '(Language=PHP/'.PHP_VERSION.'; Platform='.php_uname('s').'/'.php_uname('r').')')
                ],
                CURLOPT_POSTFIELDS => json_encode([
                    'restrictedResources' => [
                        [
                            'method' => 'GET',
                            'path' => $path,
                            'dataElements' => $dataElements
                        ]
                    ],
                    'targetApplication' => $this->targetApplication
                ]),
                CURLOPT_HEADER => true,
            ] + array_merge($options, $this->options)
        );

        $response = curl_exec($CurlHandle);
        $header_size = curl_getinfo($CurlHandle, CURLINFO_HEADER_SIZE);

        curl_close($CurlHandle);

        return [
            'info' => curl_error($CurlHandle),
            'error' => curl_error($CurlHandle),
            'headers' => CurlHelper::parseHeaders($response, $header_size),
            'response' => json_decode(substr($response, $header_size), true)
        ];
    }
}