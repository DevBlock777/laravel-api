<?php

namespace App\Http\Controllers;

use App\Http\Requests\GeneratePromptRequest;
use App\Services\OpenAiService;
use Illuminate\Support\Str;

class ImageGenerationController extends Controller
{
    public function __construct(private OpenAiService $openAiService)
    {
        //
    }
    public function index()
    {

    }

    public function store(/*GeneratePromptRequest $request*/)
    {
        $user = request()->user();
        // $image = $request->file("image");
        $text = request()->input("text");
        
        // $originalName = $image->getClientOriginalName();
        // $sanitazedName = preg_replace("/[^a-zA-Z0-9._-]/", "_", 
        // pathinfo($originalName, PATHINFO_FILENAME));

        // $extension = $image->getClientOriginalExtension(); //jpg or jpeg or ...
        // $safeFileName = $sanitazedName . "_" . Str::random(10) . "." . $extension;

        // $imagePath = $image->storeAs("uploads/images", $safeFileName, "public");

        // $generatedPrompt = $this->openAiService->generatePromptFromImage($image);
// $generatedPrompt = $this->openAiService->generatePromptFromImage($text);
//         $imageGeneration = $user->imageGenerations()->create([
//             "image_path" => $imagePath,
//             "generated_prompt" => $generatedPrompt,
//             "original_file_name" => $originalName,
//             "file_size" => $image->getSize(),
//             "mime_type" => $image->getMimeType()
//         ]);

$generatedImagePath = $this->openAiService->generateImageFromPrompt($text);
// $imageGeneration = $user->imageGenerations()->create([
//     "image_path" => $generatedImagePath,
//     "generated_prompt" => $text,
//     "original_file_name" => "",
//             "file_size" => "",
//             "mime_type" => ""
// ]);

        return response()->json($generatedImagePath, 201);

    }
}