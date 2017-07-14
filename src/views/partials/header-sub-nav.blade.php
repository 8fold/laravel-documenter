{{--
TODO: Move project switcher to project word - project label becomes "home" for the project
TODO: Move version switcher to version word - version label becomes "home" for the version
This means there is no reason to have the "class list" link, because I can get to the projet home and the version home.

{project} : {version} : {class} : {sub-class} : {function/property}
--}}
<aside id="header-sub-nav" class="ef-grid">
    @if (!isset($project) || is_null($project))
        {!! $documenter->projectsNavigator() !!}

    @else
        {!! $documenter->projectsNavigator($project) !!}
        @if (isset($version) && !is_null($version))
            {!! $project->versionsNavigator($version) !!}

        @endif

    @endif

    @if (isset($object))
        <nav class="elements-navigator">
            {{-- parentBreadcrumbs --}}
            @if (isset($symbol))
                {!! $object->parentBreadcrumbs !!}
                {!! $object->symbolNavigator($symbol) !!}

            @else
                {!! $object->parentBreadcrumbs(false) !!}

            @endif
        </nav>
    @endif
</aside>
