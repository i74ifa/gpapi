# Gpapi is Some grapql solutions in Rest api

## Solutions

+ response specific relationships
+ response specific response params
+ ~~response params from relationships~~ ```Underway```

## how is work

The work is started in the trait class called Gpapi

We add it to the Resource Class to be supported after that

Let's start a project to show the way

Models:
```php
// App\Models\Post
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
```

```php
// App\Models\Tag
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{


    public function questions()
    {
        return $this->morphTo(Question::class);
    }
}
```

Resources:

```php
<?php

namespace App\Http\Resources;

use I74ifa\Gpapi\Gpapi;
use I74ifa\Gpapi\Interfaces\interfaceGpapi;
use I74ifa\Gpapi\RelatedModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource implements interfaceGpapi
{
    use Gpapi;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->resolveParams($request);
        return parent::toArray($request);
    }

}
```
```php

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
```

This is the default resources

Note that we have added use **Gpapi** in **PostResource**


### request form

```
localhost/bestApi/api/post/1?show&relations=tags
```

```show``` Display style starting point ```Very necessary```

```relations=tags``` We want a relationship **tags**

