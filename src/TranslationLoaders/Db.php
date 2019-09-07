<?php

namespace Spatie\TranslationLoader\TranslationLoaders;

use Illuminate\Support\Facades\Schema;
use Spatie\TranslationLoader\LanguageLine;
use Spatie\TranslationLoader\Exceptions\InvalidConfiguration;

class Db implements TranslationLoader
{
    public function loadTranslations(string $locale, string $group): array
    {
        if (Schema::hasTable('language_lines')) {
            $model = $this->getConfiguredModelClass();

            return $model::getTranslationsForGroup($locale, $group);
        }

        return [];
    }

    protected function getConfiguredModelClass(): string
    {
        $modelClass = config('translation-loader.model');

        if (! is_a(new $modelClass, LanguageLine::class)) {
            throw InvalidConfiguration::invalidModel($modelClass);
        }

        return $modelClass;
    }
}
