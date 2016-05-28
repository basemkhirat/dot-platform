<?php $level++; ?>
@foreach($subItems as $subItem)
<ol class="inner dd-list">
    <li class="group iterate-item dd-item" data-item-id="{!!$subItem->id!!}" data-level='{!!$level!!}' data-parent='{!!$subItem->parent!!}' id="item_{!!$item->id!!}">
        <div class="panel-heading dd-handle">
            <span class="panel-title">{!!$subItem->name!!}</span>
            <div class="input-group input-group-sm item-text-holder" style="display: none;">
                <input type="text" class="form-control name-txt" id="txt-{!!$subItem->id!!}" value="{!!$subItem->name!!}">
                <span class="input-group-btn">
                    <button class="btn save-text" type="button" data-id="{!!$subItem->id!!}">Save</button>
                </span>
            </div>
            <a href="#" class="pull-right delete-item" data-target="{!!$subItem->id!!}"><i class="fa fa-times"></i></a>
        </div>
        @include('navigations::partials.subItem',['subItems' => $subItem->subItems,'level' => $level])
    </li>
</ol>
@endforeach
