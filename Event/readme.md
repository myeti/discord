## Discord\Event

Gestionnaire d'évenements.

### Utilisation

```php
<?php

use Discord\Event;

$channel = new Event\Channel;
$channel->on('greet', function($name)
{
    echo 'Hello ', $name, ' !';
});

$channel->fire('greet', 'you'); // Hello you !
```

Il est possible d'attacher des objets en tant qu'écouteurs.
Les méthodes ayant le meta-tag `@event` écouteront un évenement spécifique.

```php
<?php

class Listener
{
    /**
     * @event 'greet'
     */
     public function greet($name)
     {
        echo 'Hello ', $name, ' !';
     }
}

use Discord\Event;

$channel = new Event\Channel;
$channel->attach(new Listener);
```

### Valeur de retour

Il est possible de définir une valeur ou type de valeur attendue.
Lors de l'acquisition de cette valeur, l'événement est stoppé, sauf si `true` est passé en 3e paramètre.

#### Acquisition d'une classe

```php
<?php

use Discord\Event;

$channel = new Event\Channel;
$channel->expect('user.create', 'App\Model\User');

$channel->on('user.create', function()
{
    return new App\Model\User;
});

$user = $channel->fire('user.create');
```

#### Acquisition d'autres valeurs

```php
<?php

$channel->expect('foo', true);
$channel->expect('foo', false);
$channel->expect('foo', 'some string');
$channel->expect('foo', 50);
```

#### Acquisition par callback

Le callback reçoit la vleur en argument, s'il retourne `true`, la valeur est retournée.

```php
<?php

$channel->expect('foo', function($value)
{
    return is_something($value);
});
```

### Hub : évenements globaux

Gestion statique, pour plus de souplesse.

```php
<?php

use Discord\Event;

Event\Hub::on('greet', function($name)
{
    echo 'Hello ', $name, ' !';
});

Event\Hub::fire('greet', 'you'); // Hello you !
```