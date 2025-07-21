<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="crsf-token" content="{{ csrf_token() }}"/>
<meta name="author" content="Erion"/>
<meta name="google" content="notranslate" data-rh="true">
<meta name="description" content="{{ config('app.name','Erion') }} - Just Get Something!" data-rh="true"/>
<meta name="application-device" content="pc,mobile" data-rh="true"/>
<meta name="canonical" content="{{ url()->current() }}" data-rh="true"/>
<meta name="keywords" content="Erion,erion,links, link, cv, portfolio, aggregation, platform, social, media, profile, bio, tree" data-rh="true"/>
<meta name="mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-title" content="Erion"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
<link rel="shortcut icon" href="https://goerion.com/icon.svg" type="image/x-icon"/>
<link rel="apple-touch-icon" href="https://goerion.com/icon.svg"/>
<link rel="manifest" href="/manifest.json"/>
<meta name="theme-color" content="#000000"/>
<meta content="Erion" property="og:site_name"/>
<meta property="og:type" content="{{ url()->current() }}" data-rh="true"/>
@if(request()->routeIs('profile.show'))
    @php
    $user = request()->route('username');
    @endphp
    <title>{{ $user->name }} ({{ '@'.$user->username }}) / Erion</title>
    <meta property="og:type" content="profile" data-rh="true"/>
    <meta property="profile:username" content="{{ $user->username }}" data-rh="true"/>
    <meta property="og:title" content="{{ $user->name }} ({{ '@'.$user->username }}) / Erion" data-rh="true"/>
    <meta property="og:description" content="{{ $user->bio ?: 'All Your Socials.'  }}" data-rh="true"/>
    <meta property="og:image" content="{{ $user->avatar_url }}" data-rh="true"/>
@elseif(request()->routeIs('questions.show'))
    @php
    $question = request()->route('$question');

    $toMeta = fn(string $string) => strip_tags(str_replace('</br>','. ',str_replace('</br></br>','</br>',$string)));

    $content = $toMeta($question->content);
    $answer = $question->answer ? $toMeta($question->answer) : null;
    $isSharedUpdate = $question->isSharedUpdate();
    $ogTitle = ($isSharedUpdate ? $question->to->name.' On Erion' :
    $question->to->name. ': "'.$answer.'" / Erion');
    $ogDescription = ($isSharedUpdate ? $answer : ($question->anonymously ? 'Question' : 'Question from '.$question->from->name).': "'.$content.'"');
    @endphp

    <meta property="og:description" content="{{ $ogDescription }}" data-rh="true"/>
    <meta property="og:type" content="profile" data-rh="true"/>
    <meta property="profile:username" content="{{ $question->to->username }}" data-rh="true"/>
    <meta property="og:image" content="{{ $question->to->avatar_url }}" data-rh="true"/>

    @if ($answer)
        <title>{{ $question->to->name }}: "{!! Str::limit($answer, 50, preserveWords: true) !!}" / Erion</title>
        <meta property="og:title" content='{{ $ogTitle }}' data-rh="true"/>
    @else
        <title>{{ config('app.name', 'Erion') }} - All Your Socials.</title>
        <meta property="og:title" content="{{ config('app.name', 'Erion') }} - All Your Socials." data-rh="true"/>
    @endif

@else
    <title>{{ config('app.name', 'Erion') }} - All Your Socials.</title>
    <meta property="og:type" content="website" data-rh="true"/>
    <meta property="og:title" content="{{ config('app.name', 'Erion') }} - All Your Socials." data-rh="true"/>
    <meta property="og:description" content="{{ config('app.name', 'Erion') }} - All Your Socials." data-rh="true"/>
    <meta property="og:image" content="https://goerion.com/img/logo-mid.png" data-rh="true"/>
@endif
<link rel="preload" href="{{ asset('fonts/Mona-Sans.woff2') }}" as="font" type="font/woff2" crossorigin/>
<style>
    @font-face
    {
        font-family: 'Mona Sans';
        src:
            url('{{ asset('fonts/Mona-Sans.woff2') }}') format('woff2 supports variations'),
            url('{{ asset('fonts/Mona-Sans.woff2') }}') format('woff2-variations');
        font-weight: 200 900;
        font-stretch: 75% 125%;
    }
</style>

<script>
    function isDarkTheme() {
        return localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
    }
    function updateTheme() {
        if (isDarkTheme()) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    }
    updateTheme();
</script>

@livewireStyles
@vite(['resources/css/app.css', 'resources/js/app.js'])

@if (app()->environment('production'))
    <script
        src="https://cdn.usefathom.com/script.js"
        data-site="FPVCPLWU"
        defer
    ></script>
@endif

@yield('head')
