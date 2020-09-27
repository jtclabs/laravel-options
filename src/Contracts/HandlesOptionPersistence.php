<?php

namespace JtcLabs\LaravelOptions\Contracts;

/**
 * Interface HandlesOptionPersistence
 * @package JtcLabs\LaravelOptions\Contracts
 */
interface HandlesOptionPersistence
{
    /**
     * @param string $option
     * @param        $value
     * @param bool   $encrypted
     * @param bool   $autoload
     *
     * @return mixed
     */
    public function persistOption(string $option, $value, bool $encrypted = false, bool $autoload = true);

    /**
     * @param string $option
     *
     * @return mixed|null
     */
    public function retrievePersistedOption(string $option);
}