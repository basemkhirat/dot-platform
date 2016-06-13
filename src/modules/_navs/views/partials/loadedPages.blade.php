@foreach($pages as $page)
<li>
    <a href="#" class="new-item  dd-handle" data-item-id="{!!$page->id!!}" data-item-type="page">{!!$page->title!!}</a>
</li>
@endforeach