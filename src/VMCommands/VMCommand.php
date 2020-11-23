<?php

namespace JackVMTranslator\VMCommands;

interface VMCommand
{
    public function getVMCode(): string;

    public function getAssemblerCode(): string;
}
