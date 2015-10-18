# EdgarEzCDNBundle

This bundle aims to replace or add CDN domain to specific resource provided by web page


## Installation

### Get the bundle using composer

Add EdgarEzCDNBundle by running this command from the terminal at the root of
your eZPlatform project:

```bash
composer require edgarez/cdnbundle
```


### Enable the bundle

To start using the bundle, register the bundle in your application's kernel class:

```php
// ezpublish/EzPublishKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new EdgarEz\CDNBundle\EdgarEzCDNBundle(),
        // ...
    );
}
```

### Configure bundle

```yaml
# ezpublish/config/config.yml
edgar_ez_cdn:
    system:
        acme_group: #for each siteaccess
            domain: domain.tld #required, delare your CDN domain
            extensions: [png, css] # list of resource extension that would be serve by your CDN