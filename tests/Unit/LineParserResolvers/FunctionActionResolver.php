<?php

namespace Tests\Unit\LineParserResolvers;

use JackVMTranslator\VMCommands\FunctionCommand;
use JackVMTranslator\LineParserResolvers\FunctionActionResolver;

it('it retrieves the function command', function () {
    $resolver = new FunctionActionResolver();

    $functionCommand = $resolver->handle(['function', 'test', '0']);
    expect($functionCommand)->toBeInstanceOf(FunctionCommand::class);
});