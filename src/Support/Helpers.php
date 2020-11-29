<?php

namespace JackVMTranslator\Support;

class Helpers
{
    public static function cleanOB(string $contents): string
    {
        $lines = explode(PHP_EOL, $contents);
        $cleanedLines = [];

        foreach ($lines as $line) {
            if (!$line = trim($line)) {
                continue;
            }

            $cleanedLines[] = $line;
        }

        return implode(PHP_EOL, $cleanedLines);
    }
}