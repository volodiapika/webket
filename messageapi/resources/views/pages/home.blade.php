@extends('layouts.app')
@section('title') Message API @parent @stop
@section('content')
<div class="panel-body">
    <div class="container main">
        <div class="main-body">
            @if(count($messages)>0)
                @foreach($messages as $item)
                    <div class="row message-bubble">
                        <a href="/message/{{$item->slug}}">
                            <p class="text-muted">{{$item->title}}</p>
                        </a>
                    </div>
                @endforeach
            @else
            Messages not found.
            @endif
        </div>
    </div>
@endsection