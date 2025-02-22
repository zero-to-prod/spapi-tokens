<?php

namespace Tests\Unit;

use Tests\TestCase;
use Zerotoprod\SpapiTokens\SpapiTokens;
use Zerotoprod\SpapiTokens\Support\Testing\SpapiTokensResponseFactory;
use Zerotoprod\SpapiTokens\Support\Testing\SpapiTokensFake;

class RestrictedDataTokenTest extends TestCase
{
    /** @test */
    public function restrictedDataToken(): void
    {
        SpapiTokensFake::fake(
            SpapiTokensResponseFactory::factory()->make()
        );

        $response = SpapiTokens::from(
            'access_token',
            'targetApplication',
            'https://httpbin.org/post',
            'user-agent'
        )
            ->createRestrictedDataToken('path', ['dataElements']);

        self::assertEquals(200, $response['info']['http_code']);
        self::assertEquals('restrictedDataToken', $response['response']['restrictedDataToken']);
        self::assertEquals(3600, $response['response']['expiresIn']);
    }

    /** @test */
    public function asError(): void
    {
        SpapiTokensFake::fake(
            SpapiTokensResponseFactory::factory()->asError()->make()
        );

        $response = SpapiTokens::from(
            'access_token',
            'targetApplication',
            'https://httpbin.org/post',
            'user-agent'
        )
            ->createRestrictedDataToken('path', ['dataElements']);

        self::assertEquals(400, $response['info']['http_code']);
        self::assertEquals('InvalidInput', $response['response']['errors'][0]['code']);
    }
}