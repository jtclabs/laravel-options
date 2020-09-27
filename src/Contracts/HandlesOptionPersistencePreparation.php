<?php

namespace JtcLabs\LaravelOptions\Contracts;

interface HandlesOptionPersistencePreparation
{
    public function prepareForStorage($value, bool $encrypt): string;
    public function undoPreparation($value, bool $encrypt);
}