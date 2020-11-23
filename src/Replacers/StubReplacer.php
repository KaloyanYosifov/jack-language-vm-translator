<?php

namespace JackVMTranslator\Replacers;

interface StubReplacer
{
    public function replace(string $name, string $value): self;

    public function handle(string $filename): string;
}