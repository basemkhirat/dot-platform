@foreach($categories as $category)
<li class="dd-list">
    <a href="#" class="new-item dd-handle" data-item-id="{!!$category->id!!}" data-item-type="category" data-item-value="{!!URL::to('/category/'.$category->slug)!!}">{!!$category->name!!}</a>
</li>
@endforeach