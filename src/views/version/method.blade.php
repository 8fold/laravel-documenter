@extends('documenter::version.property')
@section('method')

@if(count($symbol->parameters) > 0)
<section>
    <h2>Parameters</h2>
    {!! $symbol->definitionListForParameters !!}
</section>
@endif

@if($returnTag = $symbol->returnType)
<section>
    <h2>Return type</h2>
    <dl>
        <dt>{!! $returnTag->displayString(true) !!}</dt>
        <dd>{!! \GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($returnTag->shortDescription ."\n\n". $returnTag->discussion) !!}</dd>
    </dl>
</section>
@endif

@endsection
