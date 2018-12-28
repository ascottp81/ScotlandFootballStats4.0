<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link href="/css/style.css" type="text/css" rel="stylesheet" media="all" />
    <link href="/css/cms.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="/js/jquery/jquery-ui.css" type="text/css" media="all" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/js/DataTables/datatables.min.css"/>

    <script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script type="text/javascript" src="/js/jquery/jquery-ui-1.11.2.js"></script>
    <script type="text/javascript" src="/js/DataTables/datatables.min.js"></script>
    <script type="text/javascript" src="/js/cms.js"></script>

    @yield('head')

    <title>ScotlandFootballStats CMS</title>
</head>

<body>
<div id="container">
    <div id="header">
        <a class="header" href="/"><span class="flagTitle"></span>ScotlandFootballStats CMS</a>
        @if (Auth::check())
            <nav>
                <ul>
                    <li><a href="/admin">Dashboard</a></li>
                    <li><a href="/admin/matches">Match Details</a></li>
                    <li><a href="/admin/competitions">Competitions</a></li>
                    <li><a href="/admin/players">Players</a></li>
                    <li><a href="/admin/rankings">FIFA Rankings</a></li>
                    <li><a href="/admin/news">News</a></li>
                    <li><a href="/admin/videos">Videos</a></li>
                </ul>
            </nav>
        @endif
    </div>
    <div id="body">

        @yield('content')

        <div style="clear:both;height:0;"></div>
    </div>
    <div id="footer">
        <div class="bottomFooter"></div>
    </div>
</div>
</body>
</html>

