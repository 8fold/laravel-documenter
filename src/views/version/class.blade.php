@extends('documenter::layouts.app')
@section('content')
{!! $object->objectTypeTitle !!}
{!! $object->leadInDescription !!}

@if(strlen($object->discussion) > 0)
<section class="ef-content">
    <h2>Overview</h2>
    {!! \GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($object->discussion()) !!}
</section>
@endif

{!! $object->definitionListFor($symbols, [
    'onlyCategories' => ['Initializer']
]) !!}

{!! $object->definitionListForSymbols($symbols, [
    'skipCategories' => ['NO_CATEGORY', 'Initializer', 'Utilities']
]) !!}

{!! $object->definitionListForSymbols($symbols, [
    'onlyCategories' => ['Utilities']
]) !!}

{!! $object->definitionListForSymbols($symbols, [
    'symbols' => $symbols,
    'onlyCategories' => ['NO_CATEGORY']
]) !!}

@if(!is_null($object->parent()) || count($object->traits) > 0)
<h2>Relationships</h2>
    @if(!is_null($object->parent()))
        <h3>Extends</h3>
        {!! $object->parentDefinitionList !!}
    @endif

    @if(count($object->traits) > 0)
        <h3>Has traits</h3>
        {!! $object->traitDefinitionList !!}
    @endif
@endif
@endsection
