<?php

namespace App\Providers;

use App\Article;
use App\Category;
use App\Course;
use App\Session;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('partials.latestArticles', function($view){
            $latestArticles = Article::published()->active()->latest()->take(10)->get();
            $view->with(['latestArticles'=>$latestArticles]);
        });

        view()->composer('partials.latestCourses', function($view){
            $latestCourses = Course::latest()->take(10)->get();
            $view->with(['latestCourses'=>$latestCourses]);
        });

        view()->composer('partials.latestSessions', function($view){
            $latestSessions = Session::latest()->take(10)->get();
            $view->with(['latestSessions'=>$latestSessions]);
        });

        view()->composer('partials.categories', function($view){
            $totalCategories = Category::whereNotNull('parent_id')->get();
            $view->with(['totalCategories'=>$totalCategories]);
        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


}
