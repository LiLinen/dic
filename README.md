# Dependency Injection Container

Very slim PSR-11 compatible Dependency Injection Container (DIC) example. 
Inspired by [Twittee](http://www.twittee.org/).

## Installation

```bash
composer require lilinen/dic
```

## Usage

```php
<?php

use LiLinen\Dic\Container;

class ExampleClient
{
    private $dependency;
    
    public function __construct(ExampleDependency $dependency) 
    {
        $this->dependency = $dependency;
    }
    
    public function foo()
    {
        return $this->dependency->bar();
    }
}

class ExampleDependency
{
    public function bar() { return 'Baz'; }
}

$dic = new Container();

$dic->set('dependency', function () {
    return new ExampleDependency();
});
$dic->set('client', function (Container $dic) {
    return new ExampleClient($dic->get('dependency'));
});

echo $dic->get('client')->foo();
```