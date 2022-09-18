<?php


namespace SyscapeSpace\LaravelTranslation;


use Illuminate\Database\Eloquent\Model;
use SyscapeSpace\LaravelTranslation\Traits\HasTranslation;

class TestModel extends Model
{
    use HasTranslation;


    protected  $translationAttributes = [
        'title',
        'body',
    ];
}
