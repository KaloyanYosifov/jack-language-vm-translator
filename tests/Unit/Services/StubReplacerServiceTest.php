<?php

namespace Tests\Unit\Services;

use Tests\Setup\Retrievers\TestStubFileRetriever;
use JackVMTranslator\Services\StubReplacerService;

it('gets just the content if no replacers are set', function () {
    $service = new StubReplacerService(new TestStubFileRetriever());
    $content = $service->handle('SimpleStub.stub');
    expect($content)->toEqual('The stub is {STUB_REPLACE} to {STUB_REPLACE_2}');
});

it('replaces the content from a stub file', function () {
    $service = new StubReplacerService(new TestStubFileRetriever());
    $content = $service
        ->replace('STUB_REPLACE', 'hacker')
        ->replace('STUB_REPLACE_2', 'test')
        ->handle('SimpleStub.stub');
    expect($content)->toEqual('The stub is hacker to test');
});
