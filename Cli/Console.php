<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Cli;

class Console
{

    /** @var Command[] */
    protected $commands = [];


    /**
     * Setup commands
     *
     * @param array $commands
     */
    public function __construct(Command ... $commands)
    {
        foreach($commands as $command) {
            $this->commands[$command->name] = $command;
        }

        $this->commands[null] = new Preset\Listing($this->commands);
    }


    /**
     * Parse input and run command
     *
     * @param string $input
     *
     * @return bool
     */
    public function run($input = null)
    {
        if($input) {
            $argv = explode(' ', $input);
        }
        else {
            $argv = $_SERVER['argv'];
            array_shift($argv);
        }

        $name = array_shift($argv);

        if(!isset($this->commands[$name])) {
            Dialog::say('command ' . $name . ' not found');
            return false;
        }

        $command = $this->commands[$name];

        try {
            list($args, $options) = $this->parse($argv, $command);
            return $command->run($args, $options);
        }
        catch(\RuntimeException $e) {
            Dialog::say($e->getMessage());
            return false;
        }
    }


    /**
     * Parse command arguments
     *
     * @param array $argv
     * @param Command $command
     *
     * @return array
     */
    protected function parse(array $argv, Command $command)
    {
        // init
        $args = $options = [];

        // parse args
        foreach($command->args() as &$arg) {

            // init
            $args[$arg->name] = false;

            // is valid argument ?
            $valid = (substr(current($argv), 0, 1) !== '-');

            // is required & not valid argument
            if($arg->isRequired() and (!$argv or !$valid)) {
                throw new \RuntimeException('missing argument "', $arg->name, '"');
            }
            // valid argument
            elseif($valid) {
                $args[$arg->name] = array_shift($argv);
            }
            // not valid argument
            else {
                break;
            }

        }

        // prepare argv for options parsing
        $query = implode('&', $argv);
        foreach($command->options() as $opt) {
            if($opt->isMultiple()) {
                $query = str_replace('-' . $opt->name, '-' . $opt->name . '[]', $query);
            }
        }
        parse_str($query, $argv);

        // parse options
        foreach($command->options() as $opt) {

            // init
            $options[$opt->name] = $opt->isMultiple() ? array() : false;
            $key = (strlen($opt->name) === 1 ? '-' : '--') . $opt->name;

            // option exists
            if(isset($argv[$key])) {

                // clean
                if($argv[$key] == '') {
                    $argv[$key] = null;
                }

                // error : must not have a value
                if($opt->isEmpty() and $argv[$key] != null) {
                    throw new \RuntimeException('option "', $opt->name, '" accepts no value');
                }
                // error : must have a value
                elseif($opt->isRequired() and $argv[$key] == null) {
                    throw new \RuntimeException('option "', $opt->name, '" must have a value');
                }
                // error : must have one or many value
                elseif($opt->isMultiple() and empty($argv[$key])) {
                    throw new \RuntimeException('option "', $opt->name, '" must have at least one value');
                }

                // valid value, set option
                $options[$opt->name] = ($argv[$key] == null) ? true : $argv[$key];

                unset($argv[$key]);
            }

        }

        // unknown params
        if($argv) {
            $name = is_int(key($argv)) ? current($argv) : key($argv);
            throw new \RuntimeException('unknown parameter "', $name, '"');
        }

        return [
            (object)$args,
            (object)$options
        ];
    }

} 