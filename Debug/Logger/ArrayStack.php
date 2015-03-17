<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Debug\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

class DailyFile extends AbstractLogger
{

    /** @var Log[] */
    protected $logs = [];


    /**
     * Logs with an arbitrary level
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = [])
    {
        $this->logs[] = new Log($level, $message);
    }


    /**
     * Get all logs
     */
    public function logs()
    {
        return $this->logs;
    }

} 