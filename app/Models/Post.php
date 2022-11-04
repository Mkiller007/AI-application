<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Orhanerday\OpenAi\OpenAi;
use RuliLG\StableDiffusion\StableDiffusion;
use RuliLG\StableDiffusion\Prompt;
use RuliLG\StableDiffusion\Models\StableDiffusionResult;

class Post extends Model
{
    use HasFactory;
    //Table Name
    protected $table = 'posts';
    //Timestamps
    public $timestamps = true;
    //Primary Key
    public $primarykey = 'id';
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    //Summarize the body of a post
    public function toSummarize(){
        $body = $this->body;
        // Some AI
        $prompt=$body."\n\nTl;dr";
        $open_ai = new OpenAi(env("OPENAI_API_KEY"));
        $OpenAiOutput = $open_ai->complete([
            'engine' => 'davinci-instruct-beta-v3',
            'prompt' => $prompt,
            'temperature' => 0,
            'max_tokens' => 150, 
            'frequency_penalty' => 0,
            'presence_penalty' => 0.6,
        ]);
        $output = \json_decode($OpenAiOutput,true);
        $summary = $output["choices"][0]["text"];
        return substr($summary, 2);
    }

    //Extract the 3 main ideas of the body
    public function toExtract(){
        $body = $this->body;
        // Some AI
        $prompt="Extract the 3 main ideas from the following: ".$body;
        $open_ai = new OpenAi(env("OPENAI_API_KEY"));
        $OpenAiOutput = $open_ai->complete([
            'engine' => 'davinci-instruct-beta-v3',
            'prompt' => $prompt,
            'temperature' => 0,
            'max_tokens' => 150, 
            'frequency_penalty' => 0,
            'presence_penalty' => 0.6,
        ]);
        $output = \json_decode($OpenAiOutput,true);
        $ideas = $output["choices"][0]["text"];
        return $ideas;
    }

    public function createCover_Image(){
        $summary = $this->toSummarize();
        StableDiffusion::make()
    ->withPrompt(
        Prompt::make()
            ->with($summary)
            ->photograph()
            ->resolution8k()
            ->trendingOnArtStation()
            ->highlyDetailed()
            ->dramaticLighting()
            ->octaneRender()
    )
    ->generate(1);
        $results = StableDiffusionResult::unfinished()->get();
        foreach ($results as $result) {
            StableDiffusion::get($result->replicate_id);
            sleep(25);
            $freshResults = StableDiffusion::get($result->replicate_id);
            if ($freshResults->is_successful) {
                return $freshResults->output; // List of URLs of the images
        }
        }
    }
}
