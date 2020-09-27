<?php

namespace JtcLabs\LaravelOptions\Repository;

use Illuminate\Support\Facades\Config;
use JtcLabs\LaravelOptions\Contracts\HandlesOptionApplication;
use JtcLabs\LaravelOptions\Models\Option;

/**
 * Class OptionApplier
 * @package JtcLabs\LaravelOptions\Repository
 */
class OptionApplier implements HandlesOptionApplication
{

    /**
     * @var OptionPersistencePreparer
     */
    protected $preparer;

    /**
     * OptionApplier constructor.
     *
     * @param OptionPersistencePreparer $preparer
     */
    public function __construct(OptionPersistencePreparer $preparer)
    {
        $this->preparer = $preparer;
    }

    /**
     * @param array $options
     *
     * @return mixed|void
     */
    public function applyOptions(array $options)
    {
        foreach($options as $option => $value){
            Config::set($option, $value);
        }
    }

    /**
     * @return array
     */
    public function retrieveAutoloadOptions(): array
    {
        $return = [];
        foreach(Option::where('is_autoloaded', '=', true)->get() as $model){
            $return[$model->config] = $this->preparer->undoPreparation($model->value, (bool)$model->is_encrypted);
        }
        return $return;
    }

}