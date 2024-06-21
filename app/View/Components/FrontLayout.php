<?php

namespace App\View\Components;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FrontLayout extends Component
{
    public $title;
    public $category;
    public $categories;

    /**
     * Create a new component instance.
     */
    public function __construct($title = null)
    {
        $this->title = $title ?? config('app.name');
        $category = Category::whereNull('parent_id')->with('children')->get();
        $this->categories = Category::limit(5)->get();
        $this->category = $category;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.front-layout');
    }
}
