{{--
TODO: Move project switcher to project word - project label becomes "home" for the project
TODO: Move version switcher to version word - version label becomes "home" for the version
This means there is no reason to have the "class list" link, because I can get to the projet home and the version home.

{project} : {version} : {class} : {sub-class} : {function/property}
--}}
<aside id="header-sub-nav" class="ef-grid">
    <nav class="projects">
        @if (count($projects) > 1)
            <button class="collapsable">
                <i class="fa fa-angle-down" aria-hidden="true"></i> Project
            </button>:

        @else
            <span class="button">Project:</span>

        @endif
        @if (count($projects) > 1)
        <ul class="collapsed">
            @foreach($projects as $slug => $nav_projects)
                @foreach($nav_projects as $nav_projects_version)
                    @if($loop->first)
                    <li><a href="{{ url($nav_projects_version->url()) }}">
                        {{ $nav_projects_version->title() }}
                    </a></li>
                    @endif
                @endforeach
            @endforeach
        </ul>
        @endif
        @if (isset($project_slug))
            <a href="{{ url($project->url()) }}">{{ Eightfold\Documenter\Php\Project::titleFromSlug($project_slug) }}</a>

        @else
            Select a project&hellip;

        @endif
    </nav>
    @if (isset($project_versions))
    <nav class="versions">
        @if (count($project_versions) > 1)
            <button class="collapsable">
                <i class="fa fa-angle-down" aria-hidden="true"></i> Version
            </button>:

        @elseif (count($project_versions) > 0)
            <button class="collapsable">
                <i class="fa fa-angle-down" aria-hidden="true"></i> Version
            </button>:

        @else
            <span class="button">Version:</span>

        @endif
        @if (count($project_versions) > 1)
        <ul class="collapsed">
        @foreach ($project_versions as $project)
            <li>
                <a href="{{ url($project->url()) }}">
                    {{ str_replace('-', '.', $project->version()) }}
                </a>
            </li>
        @endforeach
        </ul>
        @endif
        @if (isset($version) && strlen($version) > 0)
            <span class="button"><a href="{{ url($project->urlForVersion($version)) }}">{{ $version }}</a>&nbsp;</span>

        @else
            <span class="button">Select version&hellip;</span>

        @endif
    </nav>
    @endif
    @if (isset($class))
    <nav class="function-navigator">
        <span class="nav-label">
        @if (method_exists($class, 'inheritance'))
            @foreach ($class->inheritance() as $parent)
                @if($loop->last && !isset($method) && !isset($property))
                    <span class="separated">
                        {{ $parent->name() }}
                    </span>
                @else
                    <span class="separated">
                        <a href="{{ url($parent->url()) }}">{{ $parent->name() }}</a>
                    </span>
                @endif
            @endforeach
        @else
            <span class="separated">
                {{ $class->name() }}
            </span>
        @endif
        </span>

        @if (count($class->symbolsOrdered()) && (isset($method) || isset($property)))
            : <button class="collapsable">
                @if (isset($method))
                    <i class="fa fa-angle-down" aria-hidden="true"></i> {!! $method->microDeclaration(false, false) !!}
                @elseif (isset($property))
                    <i class="fa fa-angle-down" aria-hidden="true"></i> {!! $property->microDeclaration(false, false) !!}
                @else
                    Select function&hellip;
                @endif
            </button>
            <ul class="collapsed">
            @foreach ($class->symbolsOrdered() as $category => $accessLevels)
                @foreach ($accessLevels as $access => $methodsProperties)
                    @foreach ($methodsProperties as $key => $methodProperty)
                        @foreach ($methodProperty as $k => $mp)
                        <li><a href="{{ url($mp->url()) }}">{!! $mp->microDeclaration(false, false) !!}</a></li>
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
            </ul>
        @endif
    </nav>
    @endif
</aside>
