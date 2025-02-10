<?php

namespace Zerotoprod\SpapiTokens;

use Zerotoprod\CurlHelper\CurlHelper;

/**
 * The Selling Partner API for Tokens provides a secure way to access a customer's PII
 * (Personally Identifiable Information). You can call the Tokens API to get a
 * Restricted Data Token (RDT) for one or more restricted resources that you
 * specify. The RDT authorizes subsequent calls to restricted operations
 * that correspond to the restricted resources that you specified.
 *
 * @link https://developer-docs.amazon.com/sp-api/docs/tokens-api-v2021-03-01-reference
 */
class SpapiTokens
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
     * @link https://developer-docs.amazon.com/sp-api/docs/tokens-api-v2021-03-01-reference
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
     * @link https://developer-docs.amazon.com/sp-api/docs/tokens-api-v2021-03-01-reference
     */
    public static function from(
        string $access_token,
        string $targetApplication,
        string $base_uri = 'https://sellingpartnerapi-na.amazon.com/tokens/2021-03-01/restrictedDataToken',
        ?string $user_agent = null,
        array $options = []
    ): self {
        return new self($access_token, $targetApplication, $base_uri, $user_agent, $options);
    }

    /**
     * @param  string  $path                    The path in the restricted resource. Here are some path examples:
     *                                          - /orders/v0/orders. For getting an RDT for the getOrders operation of the Orders API. For bulk orders.
     *                                          - /orders/v0/orders/123-1234567-1234567. For getting an RDT for the getOrder operation of the Orders API. For a specific order.
     *                                          - /orders/v0/orders/123-1234567-1234567/orderItems. For getting an RDT for the getOrderItems operation of the Orders API. For the order items in a specific order.
     *                                          - /mfn/v0/shipments/FBA1234ABC5D. For getting an RDT for the getShipment operation of the Shipping API. For a specific shipment.
     *                                          - /mfn/v0/shipments/{shipmentId}. For getting an RDT for the getShipment operation of the Shipping API. For any of a selling partner's shipments that you specify when you call the getShipment operation.
     * @param  array   $dataElements            Indicates the type of Personally Identifiable Information requested. This parameter is required only when getting an RDT for use with the getOrder, getOrders, or getOrderItems operation of the Orders API. For more information, see the Tokens API Use Case Guide. Possible values include:
     *                                          - buyerInfo. On the order level this includes general identifying information about the buyer and tax-related information. On the order item level this includes gift wrap information and custom order information, if available.
     *                                          - shippingAddress. This includes information for fulfilling orders.
     *                                          - buyerTaxInformation. This includes information for issuing tax invoices
     * @param  array   $options                 Curl options.
     *
     * @return array{
     *  info: array{
     *      url: string,
     *      content_type: string,
     *      http_code: int,
     *      header_size: int,
     *      request_size: int,
     *      filetime: int,
     *      ssl_verify_result: int,
     *      redirect_count: int,
     *      total_time: float,
     *      namelookup_time: float,
     *      connect_time: float,
     *      pretransfer_time: float,
     *      size_upload: int,
     *      size_download: int,
     *      speed_download: int,
     *      speed_upload: int,
     *      download_content_length: int,
     *      upload_content_length: int,
     *      starttransfer_time: float,
     *      redirect_time: float,
     *      redirect_url: string,
     *      primary_ip: string,
     *      certinfo: array,
     *      primary_port: int,
     *      local_ip: string,
     *      local_port: int,
     *      http_version: int,
     *      protocol: int,
     *      ssl_verifyresult: int,
     *      scheme: string,
     *      appconnect_time_us: int,
     *      connect_time_us: int,
     *      namelookup_time_us: int,
     *      pretransfer_time_us: int,
     *      redirect_time_us: int,
     *      starttransfer_time_us: int,
     *      total_time_us: int
     *  },
     *  error: string,
     *  headers: array{
     *      Server: string,
     *      Date: string,
     *      Content-Type: string,
     *      Content-Length: string,
     *      Connection: string,
     *      'x-amz-rid': string,
     *      'x-amzn-RateLimit-Limit': string,
     *      'x-amzn-RequestId': string,
     *      'x-amz-apigw-id': string,
     *      'X-Amzn-Trace-Id': string,
     *      Vary: string,
     *      'Strict-Transport-Security': string
     *  },
     *  response: array{
     *      expiresIn: int,
     *      restrictedDataToken: string
     *  }
     *
     * @link https://developer-docs.amazon.com/sp-api/docs/tokens-api-v2021-03-01-reference
     */
    public function createRestrictedDataToken(
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