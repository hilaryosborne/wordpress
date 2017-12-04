# Local Packages

For if you want to develop composer packages locally. Add the following to your composer.json.
```
 "repositories": [
    {
        "type": "path",
        "name": "acme/example-package",
        "version": "dev",
        "url": "./packages/acme/example-package",
        "packagist.org": false
    }
  ]
```