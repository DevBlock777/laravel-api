<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
        
        //Definir le rate limit ici et 
        //ajouter ca dans le middleware avec
        //throttle:api
        RateLimiter::for("api",function(Request $request){
         return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        Scramble::afterOpenApiGenerated(function(OpenApi $openApi){
            $openApi->secure(
                SecurityScheme::http("bearer","BearerAuth")
            );
        });
    }

    
}
