<?php

namespace JtcLabs\LaravelOptions\Repository;

use Illuminate\Support\Facades\Crypt;
use JtcLabs\LaravelOptions\Contracts\HandlesOptionEncryption;
use JtcLabs\LaravelOptions\Contracts\HandlesOptionPersistence;
use JtcLabs\LaravelOptions\Contracts\HandlesOptionPersistencePreparation;
use JtcLabs\LaravelOptions\Models\Option;

/**
 * Class OptionPersistenceHandler
 * @package JtcLabs\LaravelOptions\Repository
 */
class OptionDatabasePersistenceHandler implements HandlesOptionPersistence
{

    /**
     * @var HandlesOptionPersistencePreparation
     */
    protected $preparer;

    /**
     * OptionPersistenceHandler constructor.
     *
     * @param HandlesOptionPersistencePreparation $preparer
     */
    public function __construct(HandlesOptionPersistencePreparation $preparer)
    {
        $this->preparer = $preparer;
    }

    /**
     * @param string $option
     * @param        $value
     * @param bool   $encrypted
     * @param bool   $autoload
     *
     * @return mixed|void
     */
    public function persistOption(string $option, $value, bool $encrypted = false, bool $autoload = true)
    {
        Option::updateOrCreate(
            ['config' => $option],
            [
                'is_encrypted' => $encrypted,
                'is_autoloaded' => $autoload,
                'value' => $this->preparer->prepareForStorage($value, $encrypted)
            ]
        );
    }

    /**
     * @param string $option
     *
     * @return string|null
     */
    public function retrievePersistedOption(string $option)
    {
        $model = Option::where('config', '=', $option)->first();
        if (is_null($model)) {
            return null;
        }
        return $this->preparer->undoPreparation($model->value, (bool)$model->is_encrypted);
    }

}