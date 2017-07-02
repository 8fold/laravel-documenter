@extends('documenter::layouts.app')
@section('content')
<h1>{{ $project->title() }}</h1>

@if(count($classesOrdered) > 0)
    <h2>Classes</h2>
    <p>All classes are within the <code>{{ $project_namespace }}</code> namespace.</p>
    @include('documenter::partials.class-list', [
        'classes'      => $classesOrdered,
        'only_process' => ['Main'],
        'typeOrder'    => ['concrete', 'abstract']
    ])

    @include('documenter::partials.class-list', [
        'classes'   => $classesOrdered,
        'skip'      => ['NO_CATEGORY', 'Main'],
        'typeOrder' => ['concrete', 'abstract']
    ])

    @include('documenter::partials.class-list', [
        'classes'      => $classesOrdered,
        'only_process' => ['NO_CATEGORY'],
        'typeOrder'    => ['concrete', 'abstract']
    ])
@endif
@endsection
