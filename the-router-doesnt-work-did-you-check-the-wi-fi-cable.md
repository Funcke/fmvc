---
description: Introduction to the router concept
---

# The Router doesn't work? Did you check the Wi-Fi cable?

## How does FMVC find it's routes?

The essence of FMVC \(and every other MVC Framework\) is to provide routes for your view their API-calls. Normally, PHP uses the filesystem as a kind of router. The web server has its root directory and will look there for the requested file. 

FMVC makes use of a so-called rewrite condition. This condition tells the server to redirect every call to the index.php file. This file will then load  `config/routes.php` .

This file contains an array of routes, the HTTP methods these routes support and the corresponding controller methods. This may sound a bit weird but let's see:

```php
# config/routes.php
<?php
  return [
    'base_url' => '/', #please do only add subfolders
    '' => [ # index route
      'GET' =>'IndexController::index' # HTTP Method is used as key
                                       # pointing to Controller::Method
                                       # the ControllerName should also
                                       # equal the file it is stored in.
    ]
  ];
```

The key base\_url is being used, if the files are stored in subfolders or the application itself resides in such.

How such a controller implementation looks will get its own chapter.

