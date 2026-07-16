<?php

namespace App\Services;

use \Illuminate\Http\UploadedFile;
use OpenAI\Factory;
class OpenAiService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

//     public function generatePromptFromImage(/*UploadedFile $image*/): string
// {
//     // $imageData = base64_encode(file_get_contents($image->getPathName()));
//     // $mimeType = $image->getMimeType();

//     $client = (new Factory())
//         ->withApiKey(config("services.openai.key"))
//         ->withBaseUri(config("services.openai.base_uri"))
//         ->make();

//     $response = $client->chat()->create([
//         "model" => "openai/gpt-oss-120b",
//         "messages" => [
//             [
//                 "role" => "user",
//                 "content" => [
//                     [
//                         "type" => "text",
//                         // "text" => "Analyze this image and generate a detailed descriptive prompt that can be used to recreate a similar image with an AI image generator. Describe the visual elements, style, composition, lighting, colors, and preserve the aspect ratio."
//                         "text" => "Giving the text below, generate a detailed descriptive prompt that can be used to recreate a similar image with an AI image generator. Describe the visual elements, style, composition, lighting, colors, and preserve the aspect ratio."
//                     ],
//                     // [
//                     //     "type" => "image_url",
//                     //     "image_url" => [
//                     //         "url" => "data:$mimeType;base64,$imageData"
//                     //     ]
//                     // ]
//                 ]
//             ]
//         ]
//     ]);

//     return $response->choices[0]->message->content;
// }

 public function generateImageFromPrompt($prompt): string
{

    $client = (new Factory())
        ->withApiKey(config("services.openai.key"))
        ->withBaseUri(config("services.openai.base_uri"))
        ->make();

    $response = $client->chat()->create([
        "model" => "openai/gpt-oss-120b",
        "messages" => [
            [
                "role" => "user",
                "content" => [
                    [
                        "type" => "text",
                        // "text" => "Analyze this image and generate a detailed descriptive prompt that can be used to recreate a similar image with an AI image generator. Describe the visual elements, style, composition, lighting, colors, and preserve the aspect ratio."
                        "text" => $prompt,
                    // [
                    //     "type" => "image_url",
                    //     "image_url" => [
                    //         "url" => "data:$mimeType;base64,$imageData"
                    //     ]
                    // ]
                ]
                ]
            ]
        ]
    ]);

    return $response->choices[0]->message->content;
}
}
