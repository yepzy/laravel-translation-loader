<?php

namespace Spatie\TranslationLoader\TranslationLoaders;

use Illuminate\Support\Arr;
use Symfony\Component\Yaml\Yaml as YamlFileLoader;

class Yaml implements TranslationLoader
{
    public function loadTranslations(string $locale, string $group): array
    {
        $translations = [];

        foreach (glob(resource_path("lang/$locale/*.yml")) as $yamlFile) {
            $translations = array_merge(
                $translations,
                Arr::dot([
                    last(
                        preg_replace(
                            '#\.yml#',
                            '',
                            preg_split('#/#', $yamlFile)
                        )
                    ) => YamlFileLoader::parseFile($yamlFile),
                ])
            );
        }

        return $translations;
    }
}
