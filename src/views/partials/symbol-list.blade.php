@foreach($symbols as $category => $accessLevels)
{{-- Want to hide certain access levels if not authented...gonna be difficult --}}
{{-- Need to make sure the counts for...this should be handled by the controller --}}
@if ((isset($skip) && !in_array($category, $skip)) || (isset($only_process) && in_array($category, $only_process)))
<h2>
    @if (isset($label))
    {{ $label }}
    @else
    {{ $category }}
    @endif
</h2>
    <dl>
    @foreach($symbol_order as $symbol_type)
        @foreach ($access_order as $access)
            @if(isset($symbols[$category][$symbol_type][$access]))
                @include('documenter::partials.term-and-definitions', [
                    'dictionary' => $symbols[$category][$symbol_type][$access],
                    'hasKey' => false
                ])
            @endif
        @endforeach
    @endforeach
    </dl>
@endif
@endforeach

