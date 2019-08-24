# The Controller 🎮

## Up and Running 👟

Every route you specify in your application will end in the static method of a controller. Controller are PHP classes that are derived from the `Core/Controller` base class.

```
$ give me super-powers
```

This will look something like this:

```php
#Controllers/MyController.php
use Core\Controller;
class MyController extends Controller {
    # Do your magic!
}
```

Now, after you got your fancy new controller, we need to populate it with some methods. These methods have to be public, static and need to get a reference on a `Core/Request` class instance. Like this:

```php
#Contorllers/MyController.php
use Core\Controller;
class MyController extends Controller {
    public static function handler(&$request) {
         self::render(
              'profile/index', 
              array(
              'title' => 'Profile', 
              'user' => $request->session['user'])
         );
    }
}
```

Here we utilized a method already provided by the `Core/Controller` parent class:

```php
render(string $template, array $params);
```

It takes the path to the template to render and an array with variables that should be available in the template.

All templates resign in `views/` of your project. FMVC will automatically start looking there so you do not have to include this folder in the path.

{% hint style="info" %}
 All your output will be printed onto the document like you are used to from PHP. So you can also just use echo or print to create your output.
{% endhint %}

