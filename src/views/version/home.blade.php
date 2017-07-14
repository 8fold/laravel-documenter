@extends('documenter::layouts.app')
@section('content')
<h1>{{ $project->title() }}</h1>

@if(count($classesOrdered) > 0)
    <h2>Classes</h2>
    {!! $version->definitionListForSymbols($classesOrdered, [
            'onlyCategories' => ['Main']
        ]) !!}

    {!! $version->definitionListForSymbols($classesOrdered, [
            'skipCategories' => ['NO_CATEGORY', 'Main']
        ]) !!}

    {!! $version->definitionListForSymbols($classesOrdered, [
            'onlyCategories' => ['NO_CATEGORY']
        ]) !!}

@endif

@if(count($traitsOrdered) > 0)
    <h2>Traits</h2>
    {!! $version->definitionListForSymbols($traitsOrdered, [
            'onlyCategories' => ['Main']
        ]) !!}

    {!! $version->definitionListForSymbols($traitsOrdered, [
            'skipCategories' => ['NO_CATEGORY', 'Main']
        ]) !!}

    {!! $version->definitionListForSymbols($traitsOrdered, [
            'onlyCategories' => ['NO_CATEGORY']
        ]) !!}
@endif

@if(count($interfacesOrdered) > 0)
    <h2>Interfaces</h2>
    {!! $version->definitionListForSymbols($interfacesOrdered, [
            'onlyCategories' => ['Main']
        ]) !!}

    {!! $version->definitionListForSymbols($interfacesOrdered, [
            'skipCategories' => ['NO_CATEGORY', 'Main']
        ]) !!}

    {!! $version->definitionListForSymbols($interfacesOrdered, [
            'onlyCategories' => ['NO_CATEGORY']
        ]) !!}
@endif

@endsection
