@extends('documenter::layouts.app')
@section('content')
@include('documenter::partials.method-property-title', [
    'object' => $method,
    'objectType' => 'method'
])

@include('documenter::partials.object-declaration', [
    'object' => $method,
    'objectType' => 'method'
])

@if(count($method->parameters()) > 0)
<section>
    <h2>Parameters</h2>
    <dl>
    @foreach($method->parameters() as $parameter)
        <dt class="code">{{ $parameter->name() }}:
        @if (!is_null($parameter->typeHintTODO($parameter)))
            @if (!is_null($parameter->typeHintTODO($parameter)->url))
            <span class="typehint"><a href="{{ url($parameter->typeHintTODO($parameter)->url) }}">
            {{ ucfirst($parameter->typeHintTODO($parameter)->type) }}</a></span>
            @elseif (!is_null($parameter->typeHintTODO($parameter)->type))
            <span class="typehint">{{ ucfirst($parameter->typeHintTODO($parameter)->type) }}</span>
            @endif
        @endif
        </dt>
        <dd>{!! \GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($parameter->getText()) !!}</dd>
    @endforeach
    </dl>
</section>
@endif

@if($method->hasReturn())
<section>
    <h2>Return value</h2>
    <dl>
        <dt>@if($method->hasReturn()){!! $method->returnTypes(true) !!}@endif</dt>
        <dd>@if($method->hasReturn()){!! \GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($method->returnDescription()) !!}@endif</dd>
    </dl>
</section>
@endif

@if(strlen($method->discussion()) > 0)
<section class="ef-content">
    <h2>Discussion</h2>
    {!! \GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($method->discussion()) !!}
</section>
@endif

@include('documenter::partials.object-declared-by', [
    'object' => $method,
    'objectType' => 'method'
])
@endsection
