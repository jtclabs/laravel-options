<?php

namespace JtcLabs\LaravelOptions\Repository;

use JtcLabs\LaravelOptions\Contracts\HandlesOptionEncryption;
use JtcLabs\LaravelOptions\Contracts\HandlesOptionPersistencePreparation;

/**
 * Class OptionPersistencePreparer
 * @package JtcLabs\LaravelOptions\Repository
 */
class OptionPersistencePreparer implements HandlesOptionPersistencePreparation
{

    /**
     * @var HandlesOptionEncryption
     */
    protected $encryption;

    /**
     * OptionPersistencePreparer constructor.
     *
     * @param HandlesOptionEncryption $encryption
     */
    public function __construct(HandlesOptionEncryption $encryption)
    {
        $this->encryption = $encryption;
    }

    /**
     * @param      $value
     * @param bool $encrypt
     *
     * @return string
     */
    public function prepareForStorage($value, bool $encrypt): string
    {
        $return = serialize($value);
        if ($encrypt === true) {
            $return = $this->encryption->encryptValue($return);
        }
        return $return;
    }

    /**
     * @param      $value
     * @param bool $encrypt
     *
     * @return mixed
     */
    public function undoPreparation($value, bool $encrypt)
    {
        if ($encrypt === true) {
            return unserialize($this->encryption->decryptValue($value));
        }
        return unserialize($value);
    }

}