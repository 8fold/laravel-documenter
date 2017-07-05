@extends('documenter::layouts.app')
@section('content')
<h1>{{ $project->title() }}</h1>

@if(count($classesOrdered) > 0)
    <h2>Classes</h2>
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

@if(count($traitsOrdered) > 0)
    <h2>Traits</h2>
    @include('documenter::partials.class-list', [
        'classes'      => $traitsOrdered,
        'only_process' => ['Main'],
        'typeOrder'    => ['concrete', 'abstract', 'NO_TYPE']
    ])

    @include('documenter::partials.class-list', [
        'classes'   => $traitsOrdered,
        'skip'      => ['NO_CATEGORY', 'Main'],
        'typeOrder' => ['concrete', 'abstract', 'NO_TYPE']
    ])

    @include('documenter::partials.class-list', [
        'classes'      => $traitsOrdered,
        'only_process' => ['NO_CATEGORY'],
        'typeOrder'    => ['concrete', 'abstract', 'NO_TYPE']
    ])
@endif

@endsection
