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
                    <li><a href="{{ url($nav_projects_version->url) }}">
                        {{ $nav_projects_version->title }}
                    </a></li>
                    @endif
                @endforeach
            @endforeach
        </ul>
        @endif

        @if (isset($project_slug))
            <a href="{{ url($project->url) }}">{{ Eightfold\DocumenterLaravel\Php\Project::titleFromSlug($project_slug) }}</a>

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

            @else
                <span class="button">Version:</span>

            @endif

            @if (count($project_versions) > 1)
            <ul class="collapsed">
            @foreach ($project_versions as $project)
                <li>
                    <a href="{{ url($project->url) }}">
                        {{ $project->version }}
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
                @foreach ($class->inheritance as $parent)
                    @if ($parent->isInProjectSpace)
                        @if($loop->last && !isset($symbol))
                            <span class="separated">
                                {{ $parent->name }}
                            </span>
                        @else
                            <span class="separated">
                                <a href="{{ url($parent->url) }}">{{ $parent->name }}</a>
                            </span>
                        @endif

                    @else
                        <span class="separated"><i>[{{ $parent->name }}]</i></span>

                    @endif
                @endforeach
            @else
                <span class="separated">
                    {{ $class->name }}
                </span>
            @endif
            </span>

            @if (count($class->symbolsCategorized) && isset($symbol))
            : <button class="collapsable">
                @if (isset($symbol))
                    <i class="fa fa-angle-down" aria-hidden="true"></i> {!! $symbol->microDeclaration(false, false) !!}

                @else
                    Select symbol&hellip;
                @endif
                </button>
                {!! $object->unorderedListForSymbols($symbols, [
                        'listClass' => 'collapsed',
                        'showLabel' => false,
                        'declaration' => [
                            'size' => 'mini',
                            'html' => false,
                            'link' => true,
                            'keywords' => true
                        ]
                    ]) !!}
            @endif
        </nav>
    @endif
</aside>
