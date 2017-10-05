@extends("admin::layouts.message")

@section("content")

    <div class="text-center animated fadeInDown">

        <h1>500</h1>

        <h3 class="font-bold">Internal server error</h3>

        <div class="error-desc">
            Sorry something went wrong. please contact your administrator <br/>
            <a href="{{ Request::url() }}" class="btn btn-primary m-t">Reload Page</a>
        </div>

    </div>

@stop
