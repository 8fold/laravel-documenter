@extends('documenter::layouts.app')
@section('content')
@include('documenter::partials.method-property-title', [
    'object' => $object,
    'objectType' => 'class'
])

@if(strlen($object->discussion()) > 0)
<section class="ef-content">
    <h2>Discussion</h2>
    {!! \GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($object->discussion()) !!}
</section>
@endif

@include('documenter::partials.symbol-list', [
    'symbols' => $symbols,
    'symbol_order' => [
        'properties',
        'methods'
    ],
    'only_process' => ['Initializer'],
    'label' => 'Initializer',
    'access_order' => [
        'public',
        'protected',
        'private',
        'static_public',
        'static_protected',
        'static_private'
    ]
])

@include('documenter::partials.symbol-list', [
    'methods' => $symbols,
    'skip' => ['NO_CATEGORY', 'Initializer', 'Helpers'],
    'symbol_order' => [
        'properties',
        'methods'
    ],
    'access_order' => [
        'public',
        'protected',
        'private',
        'static_public',
        'static_protected',
        'static_private'
    ]
])

@include('documenter::partials.symbol-list', [
    'methods' => $symbols,
    'only_process' => ['Helpers'],
    'label' => 'Helpers',
    'symbol_order' => [
        'properties',
        'methods'
    ],
    'access_order' => [
        'public',
        'protected',
        'private',
        'static_public',
        'static_protected',
        'static_private'
    ]
])

@include('documenter::partials.symbol-list', [
    'methods' => $symbols,
    'only_process' => ['NO_CATEGORY'],
    'label' => 'Miscellaneous',
    'symbol_order' => [
        'properties',
        'methods'
    ],
    'access_order' => [
        'public',
        'protected',
        'private',
        'static_public',
        'static_protected',
        'static_private'
    ]
])

@if(!is_null($object->parent()) || count($traits) > 0)
<h2>Relationships</h2>
    @if(!is_null($object->parent()))
        <h3>Inherits from</h3>
        @if($object->parent()->isInProjectSpace())
            <dl>
                <dt>{!! $object->parent()->smallDeclaration() !!}</dt>
                <dd>{!! $object->parent()->shortDescription() !!}</dd>
            </dl>
        @else
            <dl>
                <dt>{{ $object->parent()->space() }}\{{ $object->parent()->name() }}</dt>
                <dd>Note: The parent class is not owned by this project.</dd>
            </dl>
        @endif
    @endif

    @if(count($traits) > 0)
        <h3>Has traits</h3>
        <dl>
        @foreach($traits as $trait)
            <dt>{!! $trait->mediumDeclaration() !!}</dt>
            <dd>{!! $trait->shortDescription() !!}</dd>
        @endforeach
        </dl>
    @endif
@endif
@endsection
