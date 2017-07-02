@extends('documenter::layouts.app')
@section('content')
@include('documenter::partials.method-property-title', [
    'object' => $object,
    'objectType' => 'trait'
])
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
        'private',
        'protected',
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
        'private',
        'protected',
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
        'private',
        'protected',
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
        'private',
        'protected',
        'static_public',
        'static_protected',
        'static_private'
    ]
])

@if(count($traits) > 0)
<h2>Relationships</h2>
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
