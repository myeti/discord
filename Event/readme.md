## Event component

Gestion des événements en PHP, essence même du framework Discord.

**Écoute d'un événement** via un simple callback.

```php
<?php

use Discord\Event;

$channel = new Event\Channel;
$channel->on('greet', function($name)
{
    echo 'Hello ', $name, ' !';
});
```

**Écoute d'un événement** via annotations dans un objet.

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

Vous pouvez attacher autant de callback ou d'objet que vous voulez.

**Déclenchement d'un événement** : tous les callbacks seront éxecutés.

```php
<?php

$channel->fire('greet', 'you'); // Hello you !
```

**Définition d'une valeur de retour** : si un callback retourne la valeur attendue (instance, bool, string),
elle sera également retournée à l'utilisateur.

Dans le cas où plusieurs callback retourne la valeur attendue, seul le dernier est pris en compte.
Si vous passez le 3e paramètre à `true`, l'éxecution s'arrète au 1e qui retournera la valeur attendue.

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