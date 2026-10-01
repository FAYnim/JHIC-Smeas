<?php

namespace App\Providers;

use App\Models\CalonSiswa;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('spmb.dashboard.*', function ($view) {
            $nisn = session('spmb_nisn');
            $calonSiswa = $nisn ? CalonSiswa::where('nisn', $nisn)->first() : null;
            $view->with('calonSiswa', $calonSiswa);
        });
    }
}
