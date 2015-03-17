<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Cli\Preset;

use Discord\Cli;

class Listing extends  Cli\Command
{

    /** @var array */
    protected $commands = [];


    /**
     * register commands
     * @param array $commands
     */
    public function __construct(array $commands)
    {
        $this->commands = $commands;
    }


    /**
     * Run the command
     *
     * @param object $args
     * @param object $options
     *
     * @return bool
     */
    public function run($args, $options)
    {
        if(!$this->commands) {
            Cli\Dialog::say('no command registered');
        }
        else {
            Cli\Dialog::say('registered commands :');
            foreach($this->commands as $name => $command) {

                // display line
                $offset = 15 - strlen($name);
                if($offset <= 4) {
                    $offset = 4;
                }

                Cli\Dialog::say('- ' . $name . str_repeat(' ', $offset) . $command->description);
            }
        }

        return true;
    }

}