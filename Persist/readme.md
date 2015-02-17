## Discord\Persist

Couche de persistance des données de session.

### Session

```php
<?php

use Discord\Persist\Session;

Session::set('foo', 'bar');

$foo = Session::get('foo'); // bar

Session::drop('foo');

$foo = Session::get('foo'); // null

```

Le provider natif utilise la *dot notation* qui permet de parcourir horizontalement un tableau :

```php
<?php

use Discord\Persist\Session;

Session::set('foo', [
    'bar => 'baz'
]);

$foo = Session::get('foo.bar'); // baz

```

### Message flash

L'utilisation est la même que `Session`, à la différence que les messages sont consommés :

```php
<?php

use Discord\Persist\Flash;

Flash::set('success', 'Yeah !');

$message = Session::get('success'); // Yeah !

$message = Session::get('success'); // null

```

### Authentification

Permet de garder un utilisateur authentifié et son rang (integer).

```php
<?php

use Discord\Persist\Auth;

Auth::login($rank, $user);

if(Auth::logged()) { ... }

$rank = Auth::rank();
$user = Auth::user();

Auth::logout();

```

### Implementer son système de session

Ces 3 classes `Session`, `Flash` et `Auth` utilise une instance `Session\Native`.
Vous pouvez cependant implémenter la votre en utilisant l'interface `Session\Provider`
et de passer l'instance via la méthode `::provider()` :

```php
<?php

use Discord\Persist\Session;

class MySession implements Session\Provider
{
    ...
}

Session::provider(new MySession);

```