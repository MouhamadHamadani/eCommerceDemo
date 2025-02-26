<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class ProductFilter extends Component
{
  public $selectedCategories = [];
  public $categories;
  public $category;
  public $price_min;
  public $price_max;

  protected $listeners = ['parameterUpdated'];

  public function mount()
  {
    $this->selectedCategories = $this->category != "" ? explode(",", $this->category) : [];
  }

  public function render()
  {
    $this->categories = Category::all();
    return view('livewire.product-filter');
  }

  public function updateCategories()
  {
    $this->dispatch('filterUpdated', $this->selectedCategories, $this->price_min, $this->price_max);
  }

  public function updatePrice()
  {
    $this->dispatch('filterUpdated', $this->selectedCategories, $this->price_min, $this->price_max);
  }

  public function resetFilters()
  {
    $this->selectedCategories = [];
    $this->price_min = null;
    $this->price_max = null;
    $this->dispatch('filterUpdated', $this->selectedCategories, $this->price_min, $this->price_max);
  }
}
