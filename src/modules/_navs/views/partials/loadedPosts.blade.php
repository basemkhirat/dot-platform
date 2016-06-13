@foreach($posts as $post)
<li>
    <a href="#" class="new-item  dd-handle" data-item-id="{!!$post->id!!}" data-item-type="post">{!!$post->title!!}</a>
</li>
@endforeach