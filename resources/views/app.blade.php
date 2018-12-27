<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="description" content="{{ $metadescription }}" />
<meta name="keywords" content="Football, Soccer, Scottish Football, Scottish International Football, Scotland, SFA, Tartan Army, FIFA Rankings, 
    SFA Hall Of Fame, Scottish Football Stats, Scottish Football Statistics, Scottish National Football, World Cup, 
    FIFA World Cup, UEFA European Championships, European Championships, Home Championships, British Championships, Rous Cup, Kirin Cup, 
    History Of Scotland Football Team, Hampden Park, Scottish Football Association" />
<link href="/css/style.css" type="text/css" rel="stylesheet" media="all" />
<link rel="stylesheet" href="/js/jquery/jquery-ui.css" type="text/css" media="all" />
<link rel="stylesheet" href="/js/jquery/li-scroller.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/js/jquery/jquery.jscrollpane.css" type="text/css" media="all" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">



<!--<script type="text/javascript" src="/js/jquery/jquery-1.5.1.min.js"></script>-->
<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="/js/jquery/jquery-ui-1.11.2.js"></script>
<script type="text/javascript" src="/js/jquery/jquery.li-scroller.1.0.js"></script>

<script type="text/javascript" src="/js/jquery/jquery.mousewheel.js"></script>
<script type="text/javascript" src="/js/jquery/jquery.jscrollpane.min.js"></script>

<script type="text/javascript" src="/js/flowplayer/flowplayer-3.2.4.min.js"></script>

@yield('head')

<script type="text/javascript" src="/js/scripts.js"></script>
    
<title>ScotlandFootballStats | {{ $metatitle }}</title>
</head>

<body>
<!--<script type="text/javascript">

    var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
    document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));

</script>
<script type="text/javascript">

    try {
        var pageTracker = _gat._getTracker("UA-9512932-1");
        pageTracker._trackPageview();
    } 
    catch(err) {}
    
</script>-->   
    <div id="container">
		<div id="header">
        	<a class="header" href="/"><span class="flagTitle"></span>ScotlandFootballStats</a>
        	<nav>
            	<ul>
                	<li><a href="/" {!! $home !!}>Home</a></li>
                	<li><a href="/opponents" {!! $opponents !!}>Opponents</a></li>
                    <li><a href="/players" {!! $players !!}>Players</a></li>
                    <li><a href="/competitions" {!! $competitions !!}>Competitions</a></li>
                    <li><a href="/managers" {!! $managers !!}>Managers</a></li>
                    <li><a href="/history" {!! $history !!}>History</a></li>
                    <li><a href="/fifa-rankings" {!! $rankings !!}>FIFA Rankings</a></li>
                    <li><a href="/strips" {!! $strips !!}>Strips</a></li>
                    <!--<li><a href="/videos/" {!! $videos !!}>Videos</a></li>-->
                </ul>
            </nav>
        </div>
 		<div id="body"> 
        
        	@yield('content')
        
       		<div style="clear:both;height:0;"></div>
        </div>
       	<div id="footer">
            <div class="bottomFooter"><a href="/sitemap">Sitemap</a> | <a href="/links">Links</a></div>
        </div>
    </div>

@yield('footer')

</body>
</html>        
        