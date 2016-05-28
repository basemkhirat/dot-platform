@foreach($navigation->menuItems as $item)
<?php $level = 1 ?>
<li class="group iterate-item dd-item" data-item-id="{!!$item->id!!}" data-level='{!!$level!!}' data-parent='{!!$item->parent!!}' id="item_{!!$item->id!!}">
    <div class="panel-heading dd-handle">
        <span class="panel-title" id="title-{!!$item->id!!}">{!!$item->name!!}</span>
        <div class="input-group input-group-sm item-text-holder" style="display: none;">
            <input type="text" class="form-control name-txt" id="txt-{!!$item->id!!}" value="{!!$item->name!!}">
            <span class="input-group-btn">
                <button class="btn save-text" type="button" data-id="{!!$item->id!!}">Save</button>
            </span>
        </div>
        <a href="#" class="pull-right delete-item" data-target="{!!$item->id!!}"><i class="fa fa-times"></i></a>
    </div>
    @include('navigations::partials.subItem',['subItems'=> $item->subItems,'level'=>$level])
</li>
@endforeach