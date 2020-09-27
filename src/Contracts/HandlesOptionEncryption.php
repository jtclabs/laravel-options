<?php

namespace JtcLabs\LaravelOptions\Contracts;

/**
 * Interface HandlesOptionEncryption
 * @package JtcLabs\LaravelOptions\Contracts
 */
interface HandlesOptionEncryption
{
    /**
     * @param string $value
     *
     * @return string
     */
    public function encryptValue(string $value): string;

    /**
     * @param string $value
     *
     * @return string
     */
    public function decryptValue(string $value): string;
}