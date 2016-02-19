<?php

namespace App\Providers;

use App\Article;
use App\Category;
use App\Comment;
use App\Course;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //
        parent::boot($router);
        $router->bind('article',function($value){
            return Article::findOrFail($value);
        });
        $router->bind('category',function($value){
            return Category::where('parent_id',null)->findOrFail($value);
        });
        $router->bind('subCategory',function($value){
            return Category::where('depth',1)->findOrFail($value);
        });
        $router->bind('course',function($value){
            return Course::findOrFail($value);
        });
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
