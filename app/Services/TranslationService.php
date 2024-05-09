<?php

namespace App\Services;

use App\Models\Lesson;
use Google\ApiCore\ApiException;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationService
{
    public HandleFileService $handleFileService;

    public function __construct(HandleFileService $handleFileService)
    {
        $this->handleFileService = $handleFileService;
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . base_path('auth-translate.json'));
    }

    /**
     * @param $params
     * @return bool
     */
    public function saveTranslate($params)
    {
        try {
            $lesson = new Lesson();
            $lesson->name = $params['lesson']['name'] ?? '';
            $lesson->descriptions = $params['lesson']['descriptions'] ?? '';
            $lesson->save();

            $vocabulary = [];

            if (!empty($params['translate'])) {
                foreach ($params['translate'] as $key => $value) {
                    $vocabulary[] = [
                        'text' => $key,
                        'translate' => $value['result'],
                        'spelling' => $value['spelling'],
                        'pronounce' => $value['audio']
                    ];
                }
            }

            $lesson->vocabulary()->createMany($vocabulary);

            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage() . 'TranslationService@saveTranslate');
            return false;
        }
    }

    /**
     * @return Collection
     */
    public function getAllLessons(): Collection
    {
        return Lesson::all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return Lesson::find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $data = Lesson::find($id);
        $data->vocabulary()->delete();

        return $data->delete();
    }

    public function translate($request)
    {

        $tr = new GoogleTranslate($request->input_lang ?? 'en');
        $tr->setSource($request->input_lang ?? 'en');
        $tr->setTarget($request->output_lang ?? 'vi');
        $data = $this->getPhonetics($request->input_lang ?? 'en', $request->input);

        return response()->json([
            'input' => explode('|', $request->input ?? ''),
            'output' => explode('|', $tr->translate($request->input ?? '')),
            'spelling' => $data[0],
            'audio' => $data[1]
        ]);
    }

    /**
     * @param $lang
     * @param $data
     * @return array
     */
    public function getPhonetics($lang, $data)
    {
        $translateArray = explode('|', $data);
        $phonetic = [];
        $audio = [];
        foreach ($translateArray as $value) {
            $phonetics = Http::get("https://api.dictionaryapi.dev/api/v2/entries/$lang/$value");
            $phonetic[] = !empty($phonetics->json()[0]) ? collect($phonetics->json()[0]['phonetics'])->filter(function ($array) {
                return !empty($array['text']);
            })->min(function ($array) {
                return $array['text'];
            }) : '';
            $audio[] = $this->getAudio($value);
        }

        return [
            $phonetic,
            $audio
        ];
    }

    public function getAudio($data, $lang = 'en-US')
    {
        $textToSpeechClient = new TextToSpeechClient();
        $input = new SynthesisInput();
        $input->setText($data ?? '');
        $voice = new VoiceSelectionParams();
        $voice->setLanguageCode($lang);
        $audioConfig = new AudioConfig();
        $audioConfig->setAudioEncoding(AudioEncoding::MP3);
        $resp = $textToSpeechClient->synthesizeSpeech($input, $voice, $audioConfig);

        return $this->handleFileService->saveFile($resp->getAudioContent());
    }
}
