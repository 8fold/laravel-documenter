@extends('documenter::layouts.app')
@section('content')
    <h1>Software for developers
    <section class="ef-content">
        @foreach ($projects as $categoryTitle => $projects)
            <h2 class="ef-width-one-third">{{ $categoryTitle }}</h2>
            <div class="ef-width-two-thirds ef-end-row">
                @foreach($projects as $project)
                    <p><a href="{{ $project->url }}">{{ $project->title }}</a></p>
                @endforeach
            </div>
        @endforeach
    </section>
@endsection
