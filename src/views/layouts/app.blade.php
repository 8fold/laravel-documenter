@include('documenter::partials.head')
@include('documenter::partials.header-nav')
@include('documenter::partials.header-sub-nav')
<article class="ef-grid">
@yield('content')
</article>
@include('documenter::partials.foot')
