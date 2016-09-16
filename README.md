# SmileEzCDNBundle

[![Latest Stable Version](https://poser.pugx.org/edgarez/cdnbundle/v/stable)](https://packagist.org/packages/edgarez/cdnbundle) 
[![Total Downloads](https://poser.pugx.org/edgarez/cdnbundle/downloads)](https://packagist.org/packages/edgarez/cdnbundle)
[![Daily Downloads](https://poser.pugx.org/edgarez/cdnbundle/d/daily)](https://packagist.org/packages/edgarez/cdnbundle)
[![Latest Unstable Version](https://poser.pugx.org/edgarez/cdnbundle/v/unstable)](https://packagist.org/packages/edgarez/cdnbundle) 
[![License](https://poser.pugx.org/edgarez/cdnbundle/license)](https://packagist.org/packages/edgarez/cdnbundle)

This bundle aims to replace or add CDN domain to specific resource provided by web page


## Installation

### Get the bundle using composer

Add SmileEzCDNBundle by running this command from the terminal at the root of
your eZPlatform project:

```bash
composer require smile/ez-cdn-bundle
```


### Enable the bundle

To start using the bundle, register the bundle in your application's kernel class:

```php
// ezpublish/EzPublishKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Smile\EzCDNBundle\SmileEzCDNBundle(),
        // ...
    );
}
```

Care about Apache configuration when fonts (eot, woff ...) served by css, or ajax/cookie manipulation with javascript.
Refer to : http://www.w3.org/TR/cors/


### Configure bundle

```yaml
# ezpublish/config/config.yml
smile_ez_cdn:
    system:
        acme_group: #for each siteaccess
            domain: domain.tld #required, delare your CDN domain
            extensions: [png, css] # list of resource extension that would be serve by your CDN
```

