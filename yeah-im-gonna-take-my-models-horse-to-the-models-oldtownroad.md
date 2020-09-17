---
description: I am gonna new Models/Horse().ride() till I can't no more
---

# Yeah, I'm gonna take my Models/Horse 🐎 to the Models/OldTownRoad 🛣

## I mean, my data looks good but is there a way it can be a model?

FMVC provides models, you may know this from other packages such as ActiveModel or django.db.models. Models are a way to move your application logic from associative arrays, returned from the database, \(or even worse numeric arrays\) to full-blown PHP classes that even can have custom methods or customized constructor methods\(we know, wooow so original, it's not like everyone else can do that... but where's your PHP framework Karen?\).

### Yes, but how can I do that?

So at first, we have like a base class. `FMVC\Data\DataObject` This Base class is hold the basic methods to read, write, update and delete your models. 

Then we create out desired model like this:

```php
<?php
namespace Models;
use FMVC\Data\DataObject;

/**
 * Class User
 * @package Models
 * @table User
 */
class User extends DataObject
{
    /**
     * @var integer PRIMARY KEY AUTOINCREMENT
     */
    public $id;
    /**
     * @var VARCHAR(50)
     */
    public $Username;
    /**
     * @var VARCHAR(50)
     */
    public $Email;
    /**
     * @var VARCHAR(100)
     */
    public $Password;
    /**
     * @var date
     */
    public $Birthdate;
    /**
     * @var date
     */
    public $CreatedAt;
        
    function __construct()
    {
        parent::__construct();
        $this->CreatedAt = date("Y-m-d H:i:s");
    }
}
```

All fields we want to be represented as column in our dataset are being declared as public variable. Please be careful, as the names of the field will be used as the field names as-is. This means, that casing will also be taken into account. To tell the database adapter, what the name of the table is, we annotate the class with PHPDoc-property `@table`.

If we want to create the table for our class automatically, we need to also add PHPDoc to our fields. use the `@var` property to tell the database how the field should be realized in the database.

Now we have our entity. But behold! This entity is also equipped with some ass-kicking methods:

```php
# instance methods
# stores current object in database
$user->store();
# deletes current object from database
$user->delete();
# updates current object in database
$user->update();
# and class methods
# searches for entity via Id
User::findById(int $id);
# @param $conditions: 'field' => 'value' will be evaluated to 'field' = 'value'
User::find(array $conditions);
```

