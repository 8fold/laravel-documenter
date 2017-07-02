<h1>
@if ($object->isDeprecated())
<span class="deprecated">Deprecated</span><br>
@endif
<span class="method-type">
@if($object->name() == '__construct')
Initializer
@elseif (method_exists($object, 'isStatic') && $object->isStatic())
{{ ucfirst($objectType) }}
@elseif ($objectType == 'class')
Class
@elseif ($objectType == 'trait')
Trait
@else
Instance {{ $objectType }}
@endif
</span><br>
{!! $object->microDeclaration(false, false, false) !!}
</h1>

@if ($object->isDeprecated())
<p class="font-lead"><strong>Deprecated:</strong> {!! \GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($object->deprecatedDescription()) !!}</p>
@else
{!! \GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($object->shortDescription()) !!}
@endif
