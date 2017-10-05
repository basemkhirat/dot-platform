@extends("admin::layouts.message")

@section("content")

    <div class="text-center animated fadeInDown">

        <h1>403</h1>

        <h3 class="font-bold">Access denied</h3>

        <div class="error-desc">
            Sorry you are not authorized to view this page <br/>
            <a href="{{ admin_url() }}" class="btn btn-primary m-t">Go Back</a>
        </div>

    </div>

@stop
