---
description: I am gonna new Models/Horse().ride() till I can't no more
---

# Yeah, I'm gonna take my Models/Horse 🐎 to the Models/OldTownRoad 🛣

## I mean, my data looks good but is there a way it can be a model?

FMVC provides models, you may know this from other packages such as ActiveModel or django.db.models. Models are a way to move your application logic from associative arrays, returned from the database, \(or even worse numeric arrays\) to full-blown PHP classes that even can have custom methods or customized constructor methods\(we know, wooow so original, it's not like everyone else can do that... but where's your PHP framework Karen?\).

### Yes, but how can I do that?

So at first, we have like a base class. `Core\Data\DataObject` This Base class is hold the basic methods to read, write, update and delete your models. 

