<?php

namespace JackVMTranslator\Services;

use JackVMTranslator\Retrievers\StubRetriever;

class StubReplacerService
{
    protected StubRetriever $stubRetriever;
    protected array $stubNamesToReplace = [];

    /**
     * StubReplacerService constructor.
     * @param StubRetriever $stubRetriever
     */
    public function __construct(StubRetriever $stubRetriever)
    {
        $this->stubRetriever = $stubRetriever;
    }

    public function replace(string $name, string $value): self
    {
        $this->stubNamesToReplace[$name] = $value;

        return $this;
    }

    public function reset(): self
    {
        $this->stubNamesToReplace = [];

        return $this;
    }

    public function handle(string $stubName): string
    {
        $content = $this->stubRetriever->handle($stubName);

        if (!$content) {
            return '';
        }

        foreach ($this->stubNamesToReplace as $name => $value) {
            $content = preg_replace("~\{$name\}~m", $value, $content);
        }

        return $content;
    }
}
