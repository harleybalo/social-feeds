# HarleybaloSocialBundle

## About

The HarleybaloSocialBundle get Social Media Feeds.

## Features

* Handles Twitter feeds API

## Installation

composerr require the `harleybalo/social-bundle`
package in your `composer.json` and update your dependencies.

    $ composer require harleybalo/social-bundle

Add the HarleybaloSocialBundle to your application's kernel:

```php
    public function registerBundles()
    {
        $bundles = [
            // ...
            new Harleybalo\SocialBundle\HarleybaloSocialBundle(),
            // ...
        ];
        // ...
    }
```

## Configuration

```yaml
    harleybalo_social:
        twitter:
            api_key: XXXXXXXX
            api_secret: XXXXXXXX
            access_key: XXXXXX
            access_secret: XXXXXX
            provider_key: twitter
            api_url: https://api.twitter.com/1.1/search/tweets.json?q=from%3Atwitterdev&result_type=mixed
            max_limit: 5
            provider: Harleybalo\SocialBundle\Feeds\Provider\TwitterFeedsProvider
            version: 1.0.4
```

`api_url` is the url where to fetch the tweets

## License
Released under the MIT License, see LICENSE.