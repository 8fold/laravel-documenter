@extends('documenter::layouts.app')
@section('content')
<h1>
@if ($interface->isDeprecated())
<span class="deprecated">Deprecated</span><br>
@endif
{!! $interface->microDeclaration(false, false) !!}
@if(strlen($interface->space()) > 0)<br>
<small class="subhead">Namespace: {{ $interface->space() }}</small>@endif
</h1>
<div class="ef-content">
@if ($interface->isDeprecated() && strlen($interface->deprecatedDescription()) > 0)
<p class="font-lead">{{ $interface->deprecatedDescription() }}</p>
@else
{!! Markdown::convertToHtml($interface->description()) !!}
@endif
</div>
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
@endsection
