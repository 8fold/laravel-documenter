@extends('documenter::layouts.app')
@section('content')
{!! $symbol->objectTypeTitle !!}
{!! $symbol->leadInDescription !!}

<section>
    <h2>Declaration</h2>
    <pre><code class="code">{!! $object->largeDeclaration(true, false) !!}</code></pre>
</section>

@yield('method')

<h2>Defined in</h2>
{!! $symbol->parentDefinitionList !!}

@endsection

