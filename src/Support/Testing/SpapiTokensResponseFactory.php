<?php

namespace Zerotoprod\SpapiTokens\Support\Testing;

use Zerotoprod\Factory\Factory;

/**
 * @link https://github.com/zero-to-prod/spapi-lwa
 * @link https://github.com/zero-to-prod/spapi-tokens
 */
class SpapiTokensResponseFactory
{
    use Factory;

    private function definition(): array
    {
        return [
            "info" => [
                "url" => "https://sellingpartnerapi-na.amazon.com/tokens/2021-03-01/restrictedDataToken",
                "content_type" => "application/json",
                "http_code" => 200,
                "header_size" => 516,
                "request_size" => 865,
                "filetime" => -1,
                "ssl_verify_result" => 0,
                "redirect_count" => 0,
                "total_time" => 0.484815,
                "namelookup_time" => 0.200763,
                "connect_time" => 0.283517,
                "pretransfer_time" => 0.377993,
                "size_upload" => 217,
                "size_download" => 1801,
                "speed_download" => 3721,
                "speed_upload" => 448,
                "download_content_length" => -1,
                "upload_content_length" => 217,
                "starttransfer_time" => 0.484233,
                "redirect_time" => 0,
                "redirect_url" => "",
                "primary_ip" => "44.215.139.122",
                "certinfo" => [],
                "primary_port" => 443,
                "local_ip" => "172.22.0.2",
                "local_port" => 60062,
            ],
            "error" => "",
            "headers" => [
                "Server" => "Server",
                "Date" => "Sat, 22 Feb 2025 09:57:07 GMT",
                "Content-Type" => "application/json",
                "Transfer-Encoding" => "chunked",
                "Connection" => "keep-alive",
                "X-Amz-Rid" => "GQ5SFG1J8GFJTYKMSDZ2",
                "X-Amzn-Ratelimit-Limit" => "1.0",
                "X-Amzn-Requestid" => "82cfd8f6-7c6e-4aec-a296-9c22297ca45e",
                "X-Amz-Apigw-Id" => "OPF82cfd8f67c6e",
                "X-Amzn-Trace-Id" => "Root=1-67b99f73-82cfd8f67c6e4aec",
                "Content-Encoding" => "gzip",
                "Vary" => "accept-encoding,Content-Type,Accept-Encoding,User-Agent",
                "Strict-Transport-Security" => "max-age=47474747; includeSubDomains; preload",
            ],
            "response" => [
                "expiresIn" => 3600,
                "restrictedDataToken" => "restrictedDataToken",
            ],
        ];
    }

    /**
     * Generates an error response.
     *
     * @link https://github.com/zero-to-prod/spapi-lwa
     * @link https://github.com/zero-to-prod/spapi-tokens
     */
    public function asError(array $merge = []): self
    {
        return $this->state(
            'response',
            [
                'errors' => [
                    [
                        'code' => 'InvalidInput',
                        'message' => 'Application does not have access to one or more requested data elements: [buyerInfo, shippingAddress]',
                        'details' => 'invalid_client',
                    ] + $merge
                ]
            ]
        )->state('info.http_code', 400);
    }
}