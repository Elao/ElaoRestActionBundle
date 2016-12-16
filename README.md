REST Action Bundle
==================

This bundle provides CRUD + List REST Actions to be used with [ElaoAdminBundle](https://github.com/Elao/ElaoAdminBundle)

## Installation

Require the bundle in _Composer_:


```bash
$ composer require elao/rest-action-bundle
```

Install the bundle in your _AppKernel_:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        //...
        new Elao\Bundle\RestActionBundle\ElaoRestActionBundle(),
    );
}
```

# Configuration:

```
elao_rest_action:
    serializer: elao_rest_action.serializer.jms
```
