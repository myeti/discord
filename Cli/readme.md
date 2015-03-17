## Discord\Cli

Mode CLI de PHP


#### Création d'une commande

```php
<?php

use Discord\Cli\Command;
use Discord\Cli\Dialog;

class SayHelloCommand extends Command
{

    /** @var string */
    public $name = 'say:hello';

    /** @var string */
    public $description = 'Morning greetings';


    /**
     * Execute command
     *
     * @param object $args
     * @param object $options
     *
     * @return bool
     */
    public function run($args, $options)
    {
        Dialog::say('Hello :)');
    }

}
```


#### Ajout de la commande dans la console

```php
#console.php
<?php

use Discord\Cli\Console;

$console = new Console(
    new SayHelloCommand
);

$console->run();
```


#### Execution de la commande

`php console.php say:hello`


#### Arguments et options

...