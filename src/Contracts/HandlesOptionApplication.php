<?php

namespace JtcLabs\LaravelOptions\Contracts;

/**
 * Interface HandlesOptionApplication
 * @package JtcLabs\LaravelOptions\Contracts
 */
interface HandlesOptionApplication
{
    /**
     * @return array
     */
    public function retrieveAutoloadOptions(): array;

    /**
     * @param array $options
     *
     * @return mixed
     */
    public function applyOptions(array $options);
}