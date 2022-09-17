<?php

namespace SyscapeSpace\LaravelTranslation;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SyscapeSpace\LaravelTranslation\Skeleton\SkeletonClass
 */
class LaravelTranslationFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-translation';
    }
}
