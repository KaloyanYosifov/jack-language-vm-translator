<?php

namespace JackVMTranslator\VMCommands;

interface VMCommandWithFileKnowledge
{
    public function setFile(string $filename): self;

    public function getFile(): string;
}