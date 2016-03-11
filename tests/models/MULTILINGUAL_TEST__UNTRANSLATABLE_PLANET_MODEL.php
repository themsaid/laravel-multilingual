<?php
namespace Themsaid\Multilingual\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Themsaid\Multilingual\Translatable;

class MULTILINGUAL_TEST__UNTRANSLATABLE_PLANET_MODEL extends Model
{
    use Translatable;

    protected $table = 'planets';
    public $fillable = ['name'];
    public $timestamps = false;
    protected $casts = [
        'id'   => 'integer',
        'name' => 'array',
    ];

}