<?php
namespace Themsaid\Multilingual\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Themsaid\Multilingual\Translatable;

class MULTILINGUAL_TEST_PLANET_MODEL extends Model
{
    use Translatable;

    protected $table = 'planets';
    public $translatable = ['name', 'order'];
    public $fillable = ['name', 'order'];
    public $timestamps = false;
    protected $casts = [
        'id'    => 'integer',
        'name'  => 'array',
        'order' => 'integer',
    ];

}