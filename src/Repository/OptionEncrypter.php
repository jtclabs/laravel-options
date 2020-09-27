<?php

namespace JtcLabs\LaravelOptions\Repository;

use Illuminate\Support\Facades\Crypt;
use JtcLabs\LaravelOptions\Contracts\HandlesOptionEncryption;

/**
 * Class OptionEncrypter
 * @package JtcLabs\LaravelOptions\Repository
 */
class OptionEncrypter implements HandlesOptionEncryption
{
    /**
     * @param string $value
     *
     * @return string
     */
    public function encryptValue(string $value): string
    {
        return Crypt::encryptString($value);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function decryptValue(string $value): string
    {
        return Crypt::decryptString($value);
    }

}