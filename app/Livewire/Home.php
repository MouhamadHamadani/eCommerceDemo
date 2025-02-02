<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Slides;
use App\Models\Category;

class Home extends Component
{
    public $slides;
    public $categories;

    public function render()
    {
        $this->slides = Slides::all();
        $this->categories = Category::whereNull('parent_id')->get();

        return view('livewire.home')->title('Home');
    }
}
