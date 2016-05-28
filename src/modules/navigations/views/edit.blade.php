
@extends("admin::layouts.master")

@section("breadcrumb")
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><i class="fa fa-tasks faa-tada animated faa-slow"></i> {!!trans('navigations::navigations.navigations')!!}</h2>
        <ol class="breadcrumb" style="background: none;">
            <li><a  href="{!!URL::to('/'.ADMIN.'/dashboard')!!}">{!!Lang::get('admin::common.dashboard')!!}</a></li>
            <li><a  href="{!!URL::to('/'.ADMIN.'/navigations')!!}">{!!Lang::get('navigations::navigations.navigations')!!}</a></li>
            <li>{!!trans('navigations::navigations.edit')!!} {!!$navigation->name!!}</li>
        </ol>
    </div>
    <div class="col-lg-2">
        <a class="btn btn-primary btn-labeled btn-main pull-right" href="{!!route(ADMIN . '.navigations.create')!!}"> <span class="btn-label icon fa fa-plus"></span> {!!Lang::get('navigations::navigations.add_new')!!}</a> 
    </div>
</div>
@stop
@section("content")
<style>
    .delete-item{
        height: 30px; width: 15px;
    }
    .panel-success a{
        color: #fff;
        font-weight: bold;
    }

    .panel-group a, .panel-group a:visited{
        color: #fff
    }
</style>
<div id="content-wrapper">
    
    @if(Session::get('flash_message'))
    <div class="alert alert-{!!Session::get('flash_message')['type']!!}" alert-dark">
         <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>
        <strong>{!!Session::get('flash_message')['text']!!}</strong>
    </div>
    @endif


    <div class="row">
        <div class="ibox float-e-margins">

            <div class="ibox-title">
                <h5> {!!trans('navigations::navigations.menu_data')!!} </h5>
            </div>
            <div class="ibox-content">
                {!!Form::open(array(
                    'route' => array(ADMIN . '.navigations.update',$navigation->id),
                    'method' => 'PUT',
                    'class' => 'form-horizontal',
                    'id' => 'edit-form'
        ))!!}
                <div class="form-group {!!$errors->has('name') ? 'has-error has-feedback' : ''!!}">
                    <label for="menu-name" class="col-sm-2 control-label">{!!trans('navigations::navigations.menu_name')!!}</label>
                    <div class="col-sm-5">
                        <input name="menu_name" type="text" class="form-control" id="menu-name" placeholder="{!!trans('navigations::navigations.menu_name')!!}" value="{!!$navigation->name!!}">
                        @if($errors->has('name'))<span class="fa fa-times-circle form-control-feedback"></span>@endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-9">
                        <button type="submit" class="btn btn-primary">{!!trans('navigations::navigations.save')!!}</button>
                    </div>
                </div>        </div>
        </div>
        <!--                <input type="hidden" name="order" id="order-holder" value="-1">-->
        {!!Form::close()!!}


        <div class="ibox float-e-margins">

            <div class="ibox-title">
                <h5> {!!trans('navigations::navigations.items')!!} </h5>
            </div>
            <div class="ibox-content">

                <div class="row">
                    <div class="row col-sm-6 dd">
                        <div class="panel-heading">
                            <span class="panel-title">{!!trans('navigations::navigations.items')!!}</span>
                            <div class="pull-right">
                                <button id="save-order" class="btn btn-primary">{!!trans('navigations::navigations.save_order')!!}</button>
                            </div>
                        </div>
                        <ol id="menu-items" class="dd-list" data-navigation-id='{!!$navigation->id!!}' style="margin-top:10px">
                            @include('navigations::partials.items')
                        </ol>
                    </div>
                    <div class="row col-sm-6">
                        <div class="col-sm-12 pull-right">

                            <!-- Success -->
                            <div class="panel-group panel-group-success" id="accordion-success-example">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <a class="accordion-toggle collapsed fetch" data-fetch-type="posts" data-toggle="collapse" data-parent="#accordion-success-example" href="#collapseOne-success">
                                            {!!trans('navigations::navigations.posts')!!}
                                        </a>
                                    </div> <!-- / .panel-heading -->
                                    <div id="collapseOne-success" class="panel-collapse collapse" style="height: 0px;">
                                        <div class="panel-body">
                                            <form class="search-form">
                                                <div class="input-group" style="margin-bottom: 7px;">
                                                    <input type="text" class="form-control search-text" placeholder="{!!trans('navigations::navigations.search')!!}" id="posts-search-text">
                                                    <span class="input-group-btn">
                                                        <button class="btn search-go" type="button" data-text-source="posts-search-text" data-for="posts">{!!trans('navigations::navigations.filter')!!}</button>
                                                    </span>
                                                </div>
                                            </form>
                                            <ul class="nav nav-pills nav-stacked" id="posts-container">
                                                <img class="" src="{!!URL::to('/')!!}/admin/images/loader.gif" style="">
                                            </ul>
                                        </div> <!-- / .panel-body -->
                                    </div> <!-- / .collapse -->
                                </div> <!-- / .panel -->
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <a class="accordion-toggle collapsed fetch" data-fetch-type="pages" data-toggle="collapse" data-parent="#accordion-success-example" href="#collapseFour-success">
                                            {!!trans('navigations::navigations.pages')!!}
                                        </a>
                                    </div> <!-- / .panel-heading -->
                                    <div id="collapseFour-success" class="panel-collapse collapse" style="height: 0px;">
                                        <div class="panel-body">
                                            <form class="search-form">
                                                <div class="input-group" style="margin-bottom: 7px;">
                                                    <input type="text" class="form-control" placeholder="{!!trans('navigations::navigations.search')!!}" id="pages-search-text">
                                                    <span class="input-group-btn">
                                                        <button class="btn search-go" type="button" data-text-source="pages-search-text" data-for="pages">{!!trans('navigations::navigations.filter')!!}</button>
                                                    </span>
                                                </div>
                                            </form>
                                            <ul class="nav nav-pills nav-stacked" id="pages-container">
                                                <img class="" src="{!!URL::to('/')!!}/admin/images/loader.gif" style="">
                                            </ul>
                                        </div> <!-- / .panel-body -->
                                    </div> <!-- / .collapse -->
                                </div> <!-- / .panel -->

                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <a class="accordion-toggle collapsed fetch" data-fetch-type="categories" data-toggle="collapse" data-parent="#accordion-success-example" href="#collapseTwo-success">
                                            {!!trans('navigations::navigations.categories')!!}
                                        </a>
                                    </div> <!-- / .panel-heading -->
                                    <div id="collapseTwo-success" class="panel-collapse collapse" style="height: 0px;">
                                        <div class="panel-body">
                                            <form class="search-form">
                                                <div class="input-group" style="margin-bottom: 7px;">
                                                    <input type="text" class="form-control" placeholder="{!!trans('navigations::navigations.search')!!}" id="category-search-text">
                                                    <span class="input-group-btn">
                                                        <button class="btn search-go" type="button" data-text-source="category-search-text" data-for="categories">{!!trans('navigations::navigations.filter')!!}</button>
                                                    </span>
                                                </div>
                                            </form>
                                            <ul class="nav nav-pills nav-stacked" id="categories-container">
                                                <img class="" src="{!!URL::to('/')!!}/admin/images/loader.gif" style="">
                                            </ul>
                                        </div> <!-- / .panel-body -->
                                    </div> <!-- / .collapse -->
                                </div> <!-- / .panel -->

                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion-success-example" href="#collapseThree-success">
                                            {!!trans('navigations::navigations.url')!!}
                                        </a>
                                    </div> <!-- / .panel-heading -->
                                    <div id="collapseThree-success" class="panel-collapse collapse" style="height: 0px;">
                                        <div class="panel-body">
                                            <form action="#" class="form-horizontal">

                                                <div class="row form-group">
                                                    <div class="col-sm-8">
                                                        <input type="text" id="url-text" name="text" placeholder="{!!trans('navigations::navigations.text')!!}" class="form-control form-group-margin">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-sm-8">
                                                        <input type="URL" id="url-url" name="url" placeholder="{!!trans('navigations::navigations.url')!!}" class="form-control form-group-margin">
                                                    </div>
                                                </div>
                                                <div class="panel-footer text-right">
                                                    <button class="btn btn-primary" id="url-add">{!!trans('navigations::navigations.add')!!}</button>
                                                </div>
                                            </form>
                                        </div> <!-- / .panel-body -->
                                    </div> <!-- / .collapse -->
                                </div> <!-- / .panel -->
                            </div> <!-- / .panel-group -->
                            <!-- / Success -->

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


@section('footer')
<script src="<?php echo assets() ?>/js/plugins/nestable/jquery.mjs.nestedSortable.js"></script>
<script src="<?php echo assets() ?>/js/plugins/validate/jquery.validate.min.js"></script>
<script>
$(document).ready(function () {
    $("#edit-form").validate({
        ignore: [],
        rules: {
            menu_name: {
                required: true
            },
        }
    });

    jQuery.extend(jQuery.validator.messages, {
        required: "{!!Lang::get('navigations::groups.required')!!}",
    });

    $('#menu-items').nestedSortable({
        handle: 'div',
        items: 'li',
        toleranceElement: '> div',
        rtl: true,
        relocate: function (ev, obj) {
            console.log('sdf');
            var item = obj.item;
            var newLevel = item.parents('ol').length;
            var newParentLevel = parseInt(newLevel) - 1;
            var newParent = item.parents().find($("[data-level='" + newParentLevel + "']"));
            newParent = newParent.attr('data-item-id');
            newParent = (typeof newParent === 'undefined') ? 0 : newParent;
            item.attr('data-level', newLevel);
            item.attr('data-parent', newParent);
        }
    });

    $('#save-order').click(function (ev) {
        var ordered = [];
        var navigationId = $('#menu-items').attr('data-navigation-id');
        $('.iterate-item').each(function (key, value) {
            ordered.push({
                'itemId': $(value).attr('data-item-id'),
                'level': $(value).attr('data-level'),
                'parent': $(value).attr('data-parent'),
                'type': $(value).attr('data-type'),
                'value': $(value).attr('data-type-value'),
                'name': $(value).attr('data-name')
            });
        });
        var deletedItems = '';
        if ($('.deleted-items').length) {
            deletedItems = $('.deleted-items').serializeArray();
            console.log(deletedItems);
        }
        $(this).prop('disabled', true);
        $.ajax({
            url: '{!! URL::to("/".ADMIN."/navigations/reorder") !!}',
            type: 'GET', dataType: 'html',
            data: {
                order: ordered,
                navigationId: navigationId,
                deletedItems: deletedItems
            },
            complete: function () {
                $('#save-order').prop('disabled', false);
                location.reload();
            }
        });
    });
    $('.fetch').click(function () {
        var self = $(this);
        if (!self.hasClass('fetched')) {
            self.addClass('fetched');
            var fetchType = self.attr('data-fetch-type');
            var containerId = '#' + fetchType + '-container';
            $.ajax({
                url: '{!! URL::to("/".ADMIN."/navigations/load") !!}' + '/' + fetchType,
                success: function (data) {
                    $(containerId).html(data);
                }
            });
        }
    });
    $(document).on('click', '.new-item', function (e) {
        e.preventDefault();
        var self = $(this);
        addItem(self.attr('data-item-id'), self.html(), self.attr('data-item-type'), self.attr('data-item-value'));
        self.remove();
    });

    $('#url-add').click(function (event) {
        event.preventDefault();
        var text = $('#url-text').val();
        var url = $('#url-url').val();
        if (text && url) {
            addItem('0', text, 'url', url);
            $('#url-text').val('');
            $('#url-url').val('');
        }

    });

    function addItem(itemId, itemName, itemType, itemTypeValue) {
        itemTypeValue = (typeof itemTypeValue === 'undefined') ? '' : itemTypeValue;
        var container = $('#menu-items');
        container.append($('<li>', {
            'class': 'group iterate-item dd-item',
            'data-item-id': itemId,
            'data-level': '1',
            'data-parent': '0',
            'id': 'item_' + itemId,
            'data-type': itemType,
            'data-type-value': itemTypeValue,
            'data-name': itemName
        }).append($('<div>', {
            'class': 'panel-heading dd-handle'
        }).append($('<span>', {
            'calass': 'panel-title'
        }).html(itemName)).append($('<a>', {
            'href': '#',
            'class': 'pull-right delete-item',
            'data-target': itemId
        }).html('<i class="fa fa-times"></i>'))));
//            scrollTo($('#item_' + itemId));
        $('html,body').animate({
            //scrollTop: $('#item_' + itemId).offset().top - 50
        });
    }
    $(document).on('click', '.delete-item', {}, function (event) {
        event.preventDefault();
        console.log('dsds');
        var self = $(this);
        var itemId = self.attr('data-target');
        $('#item_' + itemId).hide('slow', function () {
            $(this).remove();
        });
        $('#menu-items').append($('<input>', {
            'name': 'deleted_item[]',
            'type': 'hidden',
            'class': 'deleted-items',
            'value': itemId
        }));
    });
    function search() {
        var self = $(this);
        var textSourceId = self.attr('data-text-source');
        var textSource = $('#' + textSourceId);
        var q = textSource.val();
        if (q) {
            var searchFor = self.attr('data-for');
            var containerId = '#' + searchFor + '-container';
            self.prop('disabled', true);
            $.ajax({
                url: '{!! URL::to("/".ADMIN."/navigations/search") !!}' + '/' + q,
                data: {
                    searchFor: searchFor
                },
                success: function (data) {
                    $(containerId).html(data);
                    self.prop('disabled', false);
                }
            });
        }
    }
    $('.search-go').click(search);
    $('.search-form').submit(function (event) {
        event.preventDefault();
        $(this).find('button.search-go').trigger('click');
    });
    $(document).on('dblclick', '.panel-title', function (event) {
        var self = $(this);
        initNameEdit(self);
    });
    $(document).on('click', '.save-text', function (event) {
        var self = $(this);
        var itemId = self.attr('data-id');
        $('#title-' + itemId).html($('#txt-' + itemId).val());
        finishNameEdit($('#title-' + itemId));
        self.parents('li.iterate-item').attr('data-name', $('#txt-' + itemId).val());
    });
    function initNameEdit(element) {
        var inputHolder = element.hide().siblings('.item-text-holder').show();
//            if (!inputHolder.find('button').is(':focus')) {
//                inputHolder.find('input').on('blur', function() {
//                    finishNameEdit(element);
//                });
//        }
    }
    function finishNameEdit(element) {
        var inputHolder = element.show().siblings('.item-text-holder').hide();
    }
});

//    function scrollTo(target) {
//        var offset;
//        var scrollSpeed = 600;
//        var wheight = $(window).height();
//        //var targetname = target;
//        //var windowheight = $(window).height();
//        //var pagecenterH = windowheight/2;
//        //var targetheight = document.getElementById(targetname).offsetHeight;
//
//        if (viewport()["width"] > 767 && !jQuery.browser.mobile) {
//            // Offset anchor location and offset navigation bar if navigation is fixed
//            //offset = $(target).offset().top - document.getElementById('navigation').clientHeight;
//            offset = $(target).offset().top - $(window).height() / 2 + document.getElementById('navigation').clientHeight + document.getElementById('footer').clientHeight;
//        } else {
//            // Offset anchor location only since navigation bar is now static
//            offset = $(target).offset().top;
//        }
//
//        $('html, body').animate({scrollTop: offset}, scrollSpeed);
//    }
</script>
@stop
@stop