<?php

namespace SyscapeSpace\LaravelTranslation\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use SyscapeSpace\LaravelTranslation\Translation;

trait HasTranslation
{
//    public function __construct(array $attributes = [])
//    {
//        parent::__construct($attributes);
//
//        $this->makeAccessors();
//    }
    public function getLocaleList(){
        return [
            'ar', 'en', 'fr', 'de', 'es', 'it', 'pt', 'ru', 'zh', 'ja', 'ko', 'tr', 'nl', 'sv', 'da', 'no', 'fi', 'pl', 'cs', 'el', 'hu', 'ro', 'sk', 'sl', 'sr', 'uk', 'bg', 'hr', 'ca', 'et',
        ];
    }
    public function getNextId()
    {
        $table = $this->getTable();
        $statement = DB::select("show table status like '$table'");
        return $statement[0]->Auto_increment ?? 1;
    }

    public function translations()
    {
        return $this->morphMany(Translation::class, 'model');
    }

//    public static function bootHasTranslation()
//    {
//        static::saved(function (Model $model) {
//            $model->saveTranslations();
//        });
//
//        static::deleting(function (Model $model) {
//            if (self::$deleteTranslationsCascade === true) {
//                return $model->deleteTranslations();
//            }
//        });
//    }


//    protected function saveTranslations(): bool
//    {
//        $translations = $this->getTranslations();
//        $saved = true;
//        foreach ($translations as $attribute => $value) {
//            $this->setTranslation($attribute, $value);
//        }
//        return $saved;
//    }


//    protected function deleteTranslations(): bool
//    {
//        $translations = $this->getTranslations();
//        $deleted = true;
//        foreach ($translations as $attribute => $value) {
//            $deleted = $deleted && $this->deleteTranslationAttribute($attribute, $value);
//        }
//        return $deleted;
//    }

//    public function getTranslations(): array
//    {
//        $translations = [];
//        foreach ($this->getAttributes() as $attribute => $value) {
//            if (in_array($attribute, $this->getTranslationAttributes())) {
//                $translations[$attribute] = $value;
//            }
//        }
//        return $translations;
//    }
//
//
    private function checkIfAttributeContainsLocale($attribute)
    {
        $localeList = $this->getLocaleList();
        $locale = null;
        foreach ($localeList as $localeItem) {
            if (strpos($attribute, "_$localeItem") !== false) {
                $locale = $localeItem;
                break;
            }
        }
        return $locale;
    }
    // getLocaleFromAttribute
    private function getLocaleFromAttribute($attribute)
    {
        $arr = explode('_', $attribute);
        return end($arr);
    }
    // getAttributeWithoutLocale
    private function getAttributeWithoutLocale($attribute)
    {
        $arr = explode('_', $attribute);
        array_pop($arr);
        return implode('_', $arr);
    }
    public function getTranslationAttributes(): array
    {
        return $this->translationAttributes ?? [];
    }

    private function getTranslation($attribute, $locale)
    {
        $translation = $this->translations()->where('locale', $locale)->where('attribute', $attribute)->first();
        return $translation->value ?? null;
    }

    public function setTranslation($attribute, $value,$locale)
    {
        $this->id = $this->id ?? $this->getNextId();
        $this->translations()->updateOrCreate([
            'locale' => $locale,
            'attribute' => $attribute
        ], [
            'value' => $value,
        ]);

    }

//    public function deleteTranslationAttribute($attribute, $locale = null)
//    {
//        $locale = $locale ?? app()->getLocale();
//        $this->translations()->where([
//            'locale' => $locale,
//            'attribute' => $attribute
//        ])->delete();
//    }

//    public function makeAccessors()
//    {
//        foreach ($this->translationAttributes as $attribute) {
//            $this->makeAccessor($attribute);
//        }
//    }
//
//    public function makeAccessor($attribute)
//    {
//        $this->{$attribute} = $this->getTranslation($attribute);
//    }

    public function getAttribute($key)
    {
        if ($this->checkIfAttributeContainsLocale($key)) {
            $locale = $this->getLocaleFromAttribute($key);
            $key = $this->getAttributeWithoutLocale($key);
        }else{
            $locale = app()->getLocale();
        }
        if (in_array($key, $this->translationAttributes)) {
            return $this->getTranslation($key,$locale);
        }
        $attribute = parent::getAttribute($key);
        return $attribute;
    }

    public function setAttribute($key, $value)
    {
        if ($this->checkIfAttributeContainsLocale($key)) {
            $locale = $this->getLocaleFromAttribute($key);
            $key = $this->getAttributeWithoutLocale($key);
        }else{
            $locale = app()->getLocale();
        }
        if (in_array($key, $this->translationAttributes)) {
            $this->setTranslation($key, $value,$locale);
            return 1;
        }
        return parent::setAttribute($key, $value);
    }


}
