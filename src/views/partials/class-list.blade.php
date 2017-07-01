@foreach($classes as $category => $types)
{{-- Want to hide certain access levels if not authented...gonna be difficult --}}
{{-- Need to make sure the counts for...this should be handled by the controller --}}
@if ((isset($skip) && !in_array($category, $skip)) || (isset($only_process) && in_array($category, $only_process)))
<h3>
    @if (isset($label))
    {{ $label }}
    @elseif ($category == 'NO_CATEGORY')
    Miscellaneous
    @else
    {{ $category }}
    @endif
</h3>
    <dl>
    @foreach ($typeOrder as $type)
        @if (isset($types[$type]))
            @include('documenter::partials.term-and-definitions', [
                'dictionary' => $types[$type]
            ])
       @endif
    @endforeach
    </dl>
@endif
@endforeach

