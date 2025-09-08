<?php

namespace Zerotoprod\SpapiTokens\Support\Testing;

use Zerotoprod\Container\Container;
use Zerotoprod\SpapiTokens\Contracts\SpapiTokensInterface;

/**
 * @link https://github.com/zero-to-prod/spapi-tokens
 */
class SpapiTokensFake implements SpapiTokensInterface
{
    /**
     * @var array
     */
    private $response;

    /**
     * @link https://github.com/zero-to-prod/spapi-tokens
     */
    public function __construct(array $response = [])
    {
        $this->response = $response;
    }

    /**
     * @link https://github.com/zero-to-prod/spapi-tokens
     */
    public static function fake(array $response = [], ?SpapiTokensInterface $fake = null): SpapiTokensInterface
    {
        Container::getInstance()
            ->instance(
                __CLASS__,
                $instance = $fake ?? new self($response)
            );

        return $instance;
    }

    /**
     * @link https://github.com/zero-to-prod/spapi-tokens
     */
    public function createRestrictedDataToken(string $path, array $dataElements = [], array $options = []): array
    {
        return $this->response;
    }
}