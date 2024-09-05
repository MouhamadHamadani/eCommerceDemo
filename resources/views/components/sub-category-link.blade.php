@props(['category'])

<div>
    @if($category->subCategories->isNotEmpty())
    @foreach($category->subCategories as $subCategories)
    <div class="ml-5">
        <a href="{{ url("products?category=" . $subCategories->slug) }}" wire:navigate>{{ $subCategories->name }}</a>
        <x-sub-category :category="$subCategories" />
    </div>
    @endforeach
    @endif
</div>