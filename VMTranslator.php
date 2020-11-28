<?php

use JackVMTranslator\Parser;
use JackVMTranslator\Generator;

if (php_sapi_name() !== PHP_SAPI) {
    echo 'Please run this in the command line!';
    exit(1);
}

if ($argc === 1) {
    echo 'Please specify the vm file to translate.';
    exit(1);
}

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$generator = new Generator();
$files = array_slice($argv, 1);

foreach ($files as $file) {
    $parser = new Parser();
    $baseDir = pathinfo($file, PATHINFO_DIRNAME);

    if ($baseDir[0] === DIRECTORY_SEPARATOR) {
        $baseDir .= DIRECTORY_SEPARATOR;
    } else {
        $baseDir = getcwd() . DIRECTORY_SEPARATOR . $baseDir . DIRECTORY_SEPARATOR;
    }

    echo $argv[1] . PHP_EOL;
    echo $baseDir . pathinfo($argv[1], PATHINFO_FILENAME) . '.asm' . PHP_EOL;

    $parser->open($argv[1]);
    $generator->open($baseDir . pathinfo($argv[1], PATHINFO_FILENAME) . '.asm');

    foreach ($parser->parseLine() as $command) {
        $generator->writeCode($command);
    }

    $parser->close();
}

$generator->close();
