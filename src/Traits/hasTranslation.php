<?php

namespace SyscapeSpace\LaravelTranslation\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use SyscapeSpace\LaravelTranslation\Translation;

trait hasTranslation
{

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->makeAccessors();
    }

    public function translations()
    {
        return $this->morphMany(Translation::class, 'model');
    }

    public static function bootHasTranslation()
    {
        static::saved(function (Model $model) {
            $model->saveTranslations();
        });

        static::deleting(function (Model $model) {
            if (self::$deleteTranslationsCascade === true) {
                return $model->deleteTranslations();
            }
        });
    }


    protected function saveTranslations(): bool
    {
        $translations = $this->getTranslations();
        $saved = true;
        foreach ($translations as $attribute => $value) {
            $saved = $saved && $this->setTranslationAttribute($attribute, $value);
        }
        return $saved;
    }


    protected function deleteTranslations(): bool
    {
        $translations = $this->getTranslations();
        $deleted = true;
        foreach ($translations as $attribute => $value) {
            $deleted = $deleted && $this->deleteTranslationAttribute($attribute, $value);
        }
        return $deleted;
    }

    public function getTranslations(): array
    {
        $translations = [];
        foreach ($this->getAttributes() as $attribute => $value) {
            if (in_array($attribute, $this->getTranslationAttributes())) {
                $translations[$attribute] = $value;
            }
        }
        return $translations;
    }


    public function getTranslationAttributes(): array
    {
        return $this->translationAttributes ?? [];
    }

    public function setTranslationAttribute($attribute, $value, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $this->translations()->updateOrCreate([
            'locale' => $locale,
            'attribute' => $attribute
        ], [
            'value' => $value,
        ]);
    }

    public function deleteTranslationAttribute($attribute, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $this->translations()->where([
            'locale' => $locale,
            'attribute' => $attribute
        ])->delete();
    }

    public function makeAccessors()
    {
        foreach ($this->translationAttributes as $attribute) {
            $this->makeAccessor($attribute);
        }
    }

    public function makeAccessor($attribute)
    {
        $this->{$attribute} = $this->getTranslation($attribute);
    }

    public function getTranslation($attribute, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        $translation = $this->translations()->where('locale', $locale)->where('attribute', $attribute)->first();

        if ($translation) {
            return $translation->value;
        }

        return $this->{$attribute};
    }
}
