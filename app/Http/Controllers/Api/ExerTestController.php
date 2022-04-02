<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lang;
use http\Env\Response;
use Illuminate\Http\Request;

class ExerTestController extends Controller
{
    public function GetExercises(Request $request){
        $langFrom = $request->route('exerciseLang');
        $words = Lang::where('lang', $langFrom)->get();
        $wordsList = [];
        $transWordsList = [];
        foreach ($words as $word){
            array_push($wordsList,$word->word);
            array_push($transWordsList,$word->transWord);
        }
        return response()->json([
            'words'=>$wordsList,
            'translated'=>$transWordsList
        ]);

    }
}
