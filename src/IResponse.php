<?php

declare(strict_types=1);

namespace Expando\Translator;

interface IResponse
{
    public function getHash(): string;
}
