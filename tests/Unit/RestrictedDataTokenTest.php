<?php

namespace Tests\Unit;

use Tests\TestCase;
use Zerotoprod\SpapiTokens\SpapiTokens;

class RestrictedDataTokenTest extends TestCase
{
    /** @test */
    public function restrictedDataToken(): void
    {
        $response = SpapiTokens::restrictedDataToken(
            'https://httpbin.org/post',
            'access_token',
            'path',
            ['dataElements'],
            'targetApplication',
            'user-agent'
        );

        self::assertEquals(200, $response['info']['http_code']);
        self::assertEquals('access_token', $response['response']['headers']['X-Amz-Access-Token']);
        self::assertEquals('path', $response['response']['json']['restrictedResources'][0]['path']);
        self::assertEquals('dataElements', $response['response']['json']['restrictedResources'][0]['dataElements'][0]);
        self::assertEquals('targetApplication', $response['response']['json']['targetApplication']);
        self::assertEquals('user-agent', $response['response']['headers']['User-Agent']);
    }
}