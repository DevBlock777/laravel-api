1. php artisan make:request StorePostRequest
  - Permet de valider les données et les règles de validation

2. php artisan make:resource UserResource
 - Permet de montrer les données à envoyer au client

3. composer require laravel/breeze --dev

4. php artisan breeze:install

# OpenAI image generation
Ajouter ca dans services.php
"openai" => [
        "key" => env("OPENAI_API_KEY")
    ]
- php artisan make:class Services/OpenAiService
 Pour créer la classe OpenAiService dans le dossier Services