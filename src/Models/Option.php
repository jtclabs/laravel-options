<?php

namespace JtcLabs\LaravelOptions\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Option
 * @package JtcLabs\LaravelOptions\Models
 */
class Option extends Model
{

    /**
     * @var string[]
     */
    protected $fillable = ['config', 'value', 'is_encrypted', 'is_autoloaded'];

}