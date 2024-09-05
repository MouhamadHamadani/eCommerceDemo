@props(['category'])

<div>
    @if($category->subCategories->isNotEmpty())
    @foreach($category->subCategories as $subCategories)
    <div class="ml-5">
        <label>{{ $subCategories->name }}</label>
        <x-sub-category :category="$subCategories" />
    </div>
    @endforeach
    @endif
</div>