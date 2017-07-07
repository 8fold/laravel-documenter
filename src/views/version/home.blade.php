@extends('documenter::layouts.app')
@section('content')
<h1>{{ $project->title() }}</h1>

@if(count($classesOrdered) > 0)
    <h2>Classes</h2>
    {!! $project->definitionListForSymbols($classesOrdered, [
            'onlyCategories' => ['Main']
        ]) !!}

    {!! $project->definitionListForSymbols($classesOrdered, [
            'skipCategories' => ['NO_CATEGORY', 'Main']
        ]) !!}

    {!! $project->definitionListForSymbols($classesOrdered, [
            'onlyCategories' => ['NO_CATEGORY']
        ]) !!}

@endif

@if(count($traitsOrdered) > 0)
    <h2>Traits</h2>
    {!! $project->definitionListForSymbols($traitsOrdered, [
            'onlyCategories' => ['Main']
        ]) !!}

    {!! $project->definitionListForSymbols($traitsOrdered, [
            'skipCategories' => ['NO_CATEGORY', 'Main']
        ]) !!}

    {!! $project->definitionListForSymbols($traitsOrdered, [
            'onlyCategories' => ['NO_CATEGORY']
        ]) !!}
@endif

@if(count($interfacesOrdered) > 0)
    <h2>Interfaces</h2>
    {!! $project->definitionListForSymbols($interfacesOrdered, [
            'onlyCategories' => ['Main']
        ]) !!}

    {!! $project->definitionListForSymbols($interfacesOrdered, [
            'skipCategories' => ['NO_CATEGORY', 'Main']
        ]) !!}

    {!! $project->definitionListForSymbols($interfacesOrdered, [
            'onlyCategories' => ['NO_CATEGORY']
        ]) !!}
@endif

@endsection
