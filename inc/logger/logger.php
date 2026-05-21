<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

function get_logger() {
    static $logger = null;

    if ($logger === null) {
        $log_path = 'logs/app.log';

        $logger = new Logger(PROJECT_NAME);
        $handler = new StreamHandler($log_path, Logger::DEBUG);
        $formatter = new LineFormatter(
            "[%datetime%] %level_name%: %message% %context%\n",
            "Y-m-d H:i:s",
            true,
            true
        );

        $handler->setFormatter($formatter);
        $logger->pushHandler($handler);
    }

    return $logger;
}


function log_debug($msg, $context = []) {
    get_logger()->debug($msg, $context);
}

function log_info($msg, $context = []) {
    get_logger()->info($msg, $context);
}

function log_warning($msg, $context = []) {
    get_logger()->warning($msg, $context);
}

function log_error($msg, $context = []) {
    get_logger()->error($msg, $context);
}
