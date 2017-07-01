@extends('documenter::layouts.app')
@section('content')
@include('documenter::partials.method-property-title', [
    'object' => $property,
    'objectType' => 'property'
])

@include('documenter::partials.object-declaration', [
    'object' => $property,
    'objectType' => 'property'
])
{{--
@if(count($method->parameters()) > 0)
<section>
    <h2>Parameters</h2>
    <dl>
    @foreach($method->parameters() as $parameter)
        <dt class="code">{{ $parameter->name() }}:
        @if (!is_null($parameter->typeHint()->url))
        <span class="typehint"><a href="{{ url($parameter->typeHint()->url) }}">
        {{ ucfirst($parameter->typehint()->name) }}</a></span>
        @else
        <span class="typehint">{{ ucfirst($parameter->typehint()->name) }}</span>
        @endif
        </dt>
        <dd>{!! Markdown::convertToHtml($parameter->description()) !!}</dd>
    @endforeach
    </dl>
</section>
@endif

@if($method->hasReturn())
<section>
    <h2>Return value</h2>
    <dl>
        <dt>@if($method->hasReturn()){!! $method->returnTypes(true) !!}@endif</dt>
        <dd>@if($method->hasReturn()){!! Markdown::convertToHtml($method->returnDescription()) !!}@endif</dd>
    </dl>
</section>
@endif
 --}}
@include('documenter::partials.object-declared-by', [
    'object' => $property,
    'objectType' => 'property'
])
@endsection

{{-- @extends('_layouts.app')
@section('content')
<h1>
@if ($property->isDeprecated())
<span class="deprecated">Deprecated</span><br>
@endif
<span class="method-type">
@if ($property->isStatic())
Class property
@else
Instance property
@endif
</span><br>
{!! $property->microDeclaration(false, false) !!}
</h1>
@if ($property->isDeprecated())
<p class="font-lead">{{ $property->deprecatedDescription() }}</p>
@else
{!! Markdown::convertToHtml($property->description()) !!}
@endif
<section>
    <h2>Declaration</h2>
    <pre><code class="code">{!! $property->largeDeclaration(true, false) !!}</code></pre>
</section>
<section>
<h2>Declared by</h2>
<p><a href="{{ url($property->declaredBy()->url()) }}">
    {{ $property->declaredBy()->space() }}@if(strlen($property->declaredBy()->space()) > 0)\@endif{{ $property->declaredBy()->name() }}</a></p>
</section>
@endsection
 --}}
