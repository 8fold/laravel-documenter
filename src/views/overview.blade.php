@extends('documenter::layouts.app')
@section('content')
    <h1>Software for developers
    <section class="ef-content">
        <h2 class="ef-width-one-third">Web API SDKs</h2>
        <div class="ef-width-two-thirds ef-end-row">
            @foreach ($projects as $versions)
                @foreach($versions as $project)
                    {{ dump($project) }}
                    <p><a href="{{ url($project->url()) }}">{{ $project->title() }}</a></p>

                @endforeach
            @endforeach
        </div>
    </section>
@endsection
