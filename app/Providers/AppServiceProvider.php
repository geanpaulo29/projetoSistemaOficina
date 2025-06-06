<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;

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
    public function boot()
    {
        Carbon::setLocale('pt_BR');
        
        Blade::directive('money', function ($amount) {
            return "<?php echo 'R$ ' . number_format($amount, 2, ',', '.'); ?>";
        });
    }
}