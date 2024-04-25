<?php

namespace App\Services;

use Google\Cloud\Translate\V2\TranslateClient;

class GoogleTranslateService
{
    protected $client;

    public function __construct()
    {
        $this->client = new TranslateClient([
            'projectId' => config('services.google_cloud.project_id'),
            'key' => config('services.google_cloud.key'),
        ]);
    }

    public function translate($text, $targetLanguage)
    {
        $translation = $this->client->translate($text, [
            'target' => $targetLanguage,
        ]);

        return $translation['text'];
    }
}
