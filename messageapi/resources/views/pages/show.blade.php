@extends('layouts.appshow')
@section('title') Show Message API @parent @stop
@section('content')
<div class="panel-body">
    <div class="container main">
        <div class="main-body">
            @if(count($messages)>0)
                @foreach($messages as $item)
                    <div class="row message-bubble">
                        <p class="text-muted">{{$item->title}}</p>
                        <div class="row-send">
                           <p class="text-muted"></p>
                           <input type="password" class="form-control" id="password">
                           <input type="hidden" id="idmessage" value="{{$item->id}}">
                           <button class="btn btn-default decode" type="button">Decode</button>
                        </div>
                        <span id="decode"></span>
                    </div>
                @endforeach
            @else
            Message not found.
            @endif
        </div>
    </div>
@endsection