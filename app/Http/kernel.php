<?php 

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        // Middleware lainnya...
        \App\Http\Middleware\SeoMiddleware::class, // Menambahkan middleware SeoMiddleware
    ];
}
