<?php

use JackVMTranslator\Parser;
use JackVMTranslator\Generator;
use JackVMTranslator\LineParser;
use JackVMTranslator\Support\Helpers;
use JackVMTranslator\VMCommands\CallFunctionCommand;
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

$firstFileOrDirectory = Helpers::getBaseDirFromFile($argv[1]) . $argv[1];
$generatedFileName = Helpers::getBaseDirFromFile($argv[1]) . pathinfo($argv[1], PATHINFO_FILENAME) . '.asm';

if (is_dir($firstFileOrDirectory)) {
    $files = Helpers::getFilesFromDirectory($firstFileOrDirectory, 'asm');
    // remove the single dot in the end if the user chooses the directory to translate with the `.`
    $firstFileOrDirectory = preg_replace('~\.$~', '', $firstFileOrDirectory);
    $generatedFileName = pathinfo($firstFileOrDirectory, PATHINFO_FILENAME) . '.asm';
} else {
    $files = array_slice($argv, 1);
}

if (!$files) {
    throw new \InvalidArgumentException('There are no assembly files in this directory!');
}

if (file_exists($generatedFileName)) {
    unlink($generatedFileName);
}

$generator = new Generator();
$generator->open($generatedFileName);

foreach ($files as $file) {
    $parser = new Parser(new LineParser());
    $baseDir = Helpers::getBaseDirFromFile($file);

    echo $file . PHP_EOL;
    echo $baseDir . pathinfo($file, PATHINFO_FILENAME) . '.asm' . PHP_EOL;

    $parser->open($file);

    foreach ($parser->parseLine() as $command) {
        $generator->writeCode($command);
    }

    $parser->close();
}

$generator->close();
