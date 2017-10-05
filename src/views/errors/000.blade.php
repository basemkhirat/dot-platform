@extends("admin::layouts.message")

@section("content")

    <div class="text-center animated fadeInDown">

        <h1>Site Offline</h1>

        <h3 class="font-bold"></h3>

        <div class="error-desc">
            {{ config("offline_message") }}
        </div>

    </div>

@stop
