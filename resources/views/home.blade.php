@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex flex-wrap">
            @foreach ($videos as $video)
                <div class="videoCard m-3 d-flex align-items-center flex-column" data-video="{{$video->file}}">
                    <img src="{{$video->thumbnail}}" class="" alt="" srcset="">
                    <div class="card-body p-2">
                        <h5>{{$video->name}}</h5>
                    </div>
                </div>
            @endforeach
    </div>
</div>
@endsection
