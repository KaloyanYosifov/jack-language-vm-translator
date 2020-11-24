<?php

use JackVMTranslator\Parser;
use JackVMTranslator\Generator;

if (php_sapi_name() !== PHP_SAPI) {
    echo 'Please run this in the command line!';
    exit(1);
}

if ($argc !== 2) {
    echo 'Please specify the vm file to translate.';
    exit(1);
}

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$parser = new Parser();
$generator = new Generator();

$parser->open($argv[1]);
$generator->open(getcwd() . DIRECTORY_SEPARATOR . pathinfo($argv[1], PATHINFO_FILENAME) . '.asm');

foreach ($parser->parseLine() as $command) {
    $generator->writeCode($command);
}

$generator->close();
$parser->close();
