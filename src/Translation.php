<?php

namespace SyscapeSpace\LaravelTranslation;

use Illuminate\Database\Eloquent\Model;
class Translation extends Model
{
    protected $fillable = [
        'locale',
        'attribute',
        'value',
    ];

    public function model()
    {
        return $this->morphTo();
    }
}