<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class NavigationMenuMain extends Component
{
    public $categories;

    public function render()
    {
        $this->categories = Category::whereNull('parent_id')->get();
        return view('livewire.navigation-menu-main');
    }
}
