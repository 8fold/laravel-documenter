@if ((isset($hasKey) && $hasKey) || !isset($hasKey))
    @foreach ($dictionary as $key => $object)
        <dt><code>
            @if($object->isDeprecated())
            <del>{!! $object->largeDeclaration() !!}</del>
            @else
                {!! $object->largeDeclaration() !!}
            @endif
        </code></dt>
        @if(strlen($object->deprecatedDescription()) > 0)
            <dd>{{ $object->deprecatedDescription() }}</dd>

        @else
            <dd>{{ $object->shortDescription() }}</dd>

        @endif
    @endforeach

@else
    @foreach ($dictionary as $object)
        <dt><code>
            @if($object->isDeprecated())
            <del>{!! $object->largeDeclaration() !!}</del>
            @else
                {!! $object->largeDeclaration() !!}
            @endif
        </code></dt>
        @if(strlen($object->deprecatedDescription()) > 0)
            <dd>{{ $object->deprecatedDescription() }}</dd>

        @else
            <dd>{{ $object->shortDescription() }}</dd>

        @endif
    @endforeach
@endif
