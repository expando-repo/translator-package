<?php

declare(strict_types=1);

namespace Expando\Translator;

interface IRequest
{
    public function asArray(): array;
}