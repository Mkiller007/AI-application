<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Orhanerday\OpenAi\OpenAi;

class AiController extends Controller
{
    public function index(){
        return view('ai.index');
    }
    public function result(Request $request){
        $topic = $request->topic;
        $prompt="Create Five fake news topics about ".$topic;
        $open_ai = new OpenAi(env("OPEN_AI_API_KEY"));
        $OpenAiOutput = $open_ai->complete([
            'engine' => 'davinci-instruct-beta-v3',
            'prompt' => $prompt,
            'temperature' => 0.9,
            'max_tokens' => 150, 
            'frequency_penalty' => 0,
            'presence_penalty' => 0.6,
        ]);

        dd($OpenAiOutput);
        return view('ai.index',['result'=>'here is the generated text by ai']);
    }
}
