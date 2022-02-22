# Gpapi is Some grapql solutions in Rest api

## Solutions

+ response specific relationships
+ response specific response params
+ ~~response params from relationships~~ ```Underway```

## how is work

The work is started in the trait class called Gpapi

We add it to the Resource Class to be supported after that

Let's start a project to show the way
### Relations param form

We will stick to this formula

```
localhost/bestApi/api/post/1?relations=tags
```

```relations=tags``` We want a relationship **tags**

Define params for a given relationship ```Not supported yet```

```
localhost/bestApi/api/post/1?relations=tags[id, name]
```


## Models

+ App\Models\Post
+ App\Models\Tag

## Resources
```php
<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray($request)
    {
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
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
```

This is the default resources

Let's support PostResource
```php
use I74ifa\Gpapi\Gpapi
use I74ifa\Gpapi\Interfaces\interfaceGpapi;

class QuestionResource extends JsonResource implements interfaceGpapi
{
    use Gpapi;
    
    public function toArray($request)
    {

        return $this->resolveRelations($request);
    }

    public function resolveRelations($request)
    {
        $data = [
            'id' => $this->getKey(),
            'table' => $this->getTable(),
            'data' => [
                'title' => $this->title,
                // ...any_params
            ],
        ];
        // If a route contains relations
        if ($request->has('relations')) {
            $data['relationships'] = $this->withRelations($request->get('relations'));
        }
    }

```