# Zerotoprod\SpapiTokens

![](art/logo.png)

[![Repo](https://img.shields.io/badge/github-gray?logo=github)](https://github.com/zero-to-prod/spapi-tokens)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/zero-to-prod/spapi-tokens/test.yml?label=test)](https://github.com/zero-to-prod/spapi-tokens/actions)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/zero-to-prod/spapi-tokens/backwards_compatibility.yml?label=backwards_compatibility)](https://github.com/zero-to-prod/spapi-tokens/actions)
[![Packagist Downloads](https://img.shields.io/packagist/dt/zero-to-prod/spapi-tokens?color=blue)](https://packagist.org/packages/zero-to-prod/spapi-tokens/stats)
[![php](https://img.shields.io/packagist/php-v/zero-to-prod/spapi-tokens.svg?color=purple)](https://packagist.org/packages/zero-to-prod/spapi-tokens/stats)
[![Packagist Version](https://img.shields.io/packagist/v/zero-to-prod/spapi-tokens?color=f28d1a)](https://packagist.org/packages/zero-to-prod/spapi-tokens)
[![License](https://img.shields.io/packagist/l/zero-to-prod/spapi-tokens?color=pink)](https://github.com/zero-to-prod/spapi-tokens/blob/main/LICENSE.md)
[![wakatime](https://wakatime.com/badge/github/zero-to-prod/spapi-tokens.svg)](https://wakatime.com/badge/github/zero-to-prod/spapi-tokens)
[![Hits-of-Code](https://hitsofcode.com/github/zero-to-prod/spapi-tokens?branch=main)](https://hitsofcode.com/github/zero-to-prod/spapi-tokens/view?branch=main)

## Contents

- [Introduction](#introduction)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Documentation Publishing](#documentation-publishing)
    - [Automatic Documentation Publishing](#automatic-documentation-publishing)
- [Local Development](./LOCAL_DEVELOPMENT.md)
- [Contributing](#contributing)

## Introduction

Get a Restricted Data Token (RDT) for Amazon Selling Partner API (SPAPI).

## Requirements

- PHP 7.1 or higher.

## Installation

Install `Zerotoprod\SpapiTokens` via [Composer](https://getcomposer.org/):

```bash
composer require zero-to-prod/spapi-tokens
```

This will add the package to your project’s dependencies and create an autoloader entry for it.

## Usage

Call the Tokens API to get a [Restricted Data Token](https://developer-docs.amazon.com/sp-api/docs/tokens-api-v2021-03-01-reference) (RDT) for restricted resources.

```php
use Zerotoprod\SpapiTokens\SpapiTokens;

$response = SpapiTokens::from('access_token','targetApplication')
            ->createRestrictedDataToken('path', ['dataElements']);

$response['response']['restrictedDataToken'];
$response['response']['expiresIn'];
```

## Testing

You can fake the response for testing purposes.

```php
use Zerotoprod\SpapiTokens\SpapiTokens;
use Zerotoprod\SpapiTokens\Support\Testing\SpapiTokensResponseFactory;
use Zerotoprod\SpapiTokens\Support\Testing\SpapiTokensFake;

SpapiTokensFake::fake(
    SpapiTokensResponseFactory::factory()->make()
);

$response = SpapiTokens::from('access_token','targetApplication')
            ->createRestrictedDataToken('path', ['dataElements']);
```

## Documentation Publishing

You can publish this README to your local documentation directory.

This can be useful for providing documentation for AI agents.

This can be done using the included script:

```bash
# Publish to default location (./docs/zero-to-prod/spapi-tokens)
vendor/bin/zero-to-prod-spapi-tokens

# Publish to custom directory
vendor/bin/zero-to-prod-spapi-tokens /path/to/your/docs
```

### Automatic Documentation Publishing

You can automatically publish documentation by adding the following to your `composer.json`:

```json
{
    "scripts": {
        "post-install-cmd": [
            "zero-to-prod-spapi-tokens"
        ],
        "post-update-cmd": [
            "zero-to-prod-spapi-tokens"
        ]
    }
}
```

## Contributing

Contributions, issues, and feature requests are welcome!
Feel free to check the [issues](https://github.com/zero-to-prod/spapi-tokens/issues) page if you want to contribute.

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Commit changes (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Create a new Pull Request.
