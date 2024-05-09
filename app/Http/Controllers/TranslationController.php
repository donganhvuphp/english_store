<?php

namespace App\Http\Controllers;

use App\Services\TranslationService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\Exceptions\LargeTextException;
use Stichoza\GoogleTranslate\Exceptions\RateLimitException;
use Stichoza\GoogleTranslate\Exceptions\TranslationRequestException;

class TranslationController
{
    public TranslationService $translationService;
    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        return view('translate.index');
    }

    public function translate(Request $request)
    {
        return $this->translationService->translate($request);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $result = $this->translationService->saveTranslate($request->all());

        return response()->json([
            'status' => $result,
            'redirect' => route('home')
        ]);
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function home(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        $lessons = $this->translationService->getAllLessons();

        return view('home.index', compact('lessons'));
    }

    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show($id)
    {
        $lesson = $this->translationService->getById($id);

        return view('translate.show', compact('lesson'));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $result = $this->translationService->delete($id);

        return response()->json([
            'status' => $result,
            'redirect' => route('home')
        ]);
    }
}
