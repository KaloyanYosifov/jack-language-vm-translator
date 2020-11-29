<?php

namespace Tests\Unit\VMCommands;

use JackVMTranslator\Services\StubReplacerService;
use JackVMTranslator\Retrievers\StubFileRetriever;
use JackVMTranslator\VMCommands\CallFunctionCommand;

$functionCalledIndex = 0;

it('can reveal its vm code', function () {
    $command = new CallFunctionCommand('Test', 2);
    expect($command->getVMCode())->toEqual('call Test 2');
});

it('can prepares a big assembly code for calling a function', function () use (&$functionCalledIndex) {
    $command = new CallFunctionCommand('TestingFunction', 0);
    $assemblyCode = $command->getAssemblerCode(new StubReplacerService(new StubFileRetriever()));
    $expectedAssemblyCode = (new StubReplacerService(new StubFileRetriever()))
        ->replace('CALLER_RETURN_ADDRESS_INDEX', $functionCalledIndex++)
        ->replace('CALLED_FUNCTION_NAME', 'TestingFunction')
        ->replace('ARGUMENTS_SUBTRACTION', '')
        ->handle('CallFunction.stub');

    expect($assemblyCode)->toEqual($expectedAssemblyCode);
});

it('can prepares a big assembly code for calling a function with arguments', function () use (&$functionCalledIndex) {
    $command = new CallFunctionCommand('TestingFunctionWithArguments', 2);
    $assemblyCode = $command->getAssemblerCode(new StubReplacerService(new StubFileRetriever()));
    $expectedAssemblyCode = (new StubReplacerService(new StubFileRetriever()))
        ->replace('CALLER_RETURN_ADDRESS_INDEX', $functionCalledIndex++)
        ->replace('CALLED_FUNCTION_NAME', 'TestingFunctionWithArguments')
        ->replace('ARGUMENTS_SUBTRACTION', '@2' . PHP_EOL . 'D=D-A')
        ->handle('CallFunction.stub');

    expect($assemblyCode)->toEqual($expectedAssemblyCode);
});
