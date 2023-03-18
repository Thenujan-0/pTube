@extends("layouts.app")

@section("content")
<div class="container d-flex flex-column align-items-center justify-content-center">
    <h3>{{$title}}</h3>
    <video controls>
        <source src="/video/{{$videoLink}}" type="video/mp4"/>
    </video>
    <script defer src="https://vjs.zencdn.net/8.0.4/video.min.js"></script>
</div>
@endsection