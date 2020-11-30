<?php

use JackVMTranslator\Parser;
use JackVMTranslator\Generator;
use JackVMTranslator\LineParser;
use JackVMTranslator\VMCommands\InitializationCommand;

if (php_sapi_name() !== PHP_SAPI) {
    echo 'Please run this in the command line!';
    exit(1);
}

if ($argc === 1) {
    echo 'Please specify the vm file to translate.';
    exit(1);
}

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

function getBaseDirFromFile(string $file)
{
    $baseDir = pathinfo($file, PATHINFO_DIRNAME);

    if ($baseDir[0] === DIRECTORY_SEPARATOR) {
        $baseDir .= DIRECTORY_SEPARATOR;
    } else {
        $baseDir = getcwd() . DIRECTORY_SEPARATOR . $baseDir . DIRECTORY_SEPARATOR;
    }

    return $baseDir;
}

$generator = new Generator();
$files = array_slice($argv, 1);
$generator->open(getBaseDirFromFile($argv[1]) . pathinfo($argv[1], PATHINFO_FILENAME) . '.asm');

$generator->writeCode(new InitializationCommand());

foreach ($files as $file) {
    $parser = new Parser(new LineParser());
    $baseDir = getBaseDirFromFile($file);

    echo $file . PHP_EOL;
    echo $baseDir . pathinfo($file, PATHINFO_FILENAME) . '.asm' . PHP_EOL;

    $parser->open($file);

    foreach ($parser->parseLine() as $command) {
        $generator->writeCode($command);
    }

    $parser->close();
}

$generator->close();
