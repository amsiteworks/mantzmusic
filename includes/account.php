<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $page_title; ?></title>
	<link rel="stylesheet" href="./includes/mantzmusicstyles.css" type="text/css">
    <link rel="stylesheet" href="./includes/nav.css">
    <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="./includes/modernizr.js"></script>
</head>
<body class="no-js">
    <noscript>
        <!--[if IE]>
            <link rel="stylesheet" href="css/ie.css">
        <![endif]-->
    </noscript>
    <div id="container">
        <div id="header">
            <img src="./includes/mantzmusicheader1v2.jpg" width="1000" height="288" alt="Mantz Music Logo"/>
        </div><!--End header div-->
        <nav id="topNav">
            <ul>
                <li><a href="./index.php" title="Home">Home</a></li>
                <li><a href="./production.php" title="Production">Production</a>
                    <ul>
                        <li><a href="./onlocation.php" title="On-Location Recording">On-Location Recording</a></li>
                        <li><a href="./studiorecording.php" title="Studio Recording">Studio Recording</a></li>
                        <li class="last"><a href="./onlineservices.php" title="Mixing/Mastering">Mixing/Mastering</a></li>
                    </ul>
                </li>
                <li><a href="./onlineservices.php" title="Online Services">Online Services</a>
                    <ul>
                        <li><a href="./mixing.php" title="Mixing">Mixing</a></li>
                        <li class="last"><a href="./mastering.php" title="Mastering">Mastering</a></li>
                    </ul>
                </li>
                <li><a href="./projects.php" title="Projects">Projects</a></li>
                <li><a href="#" title="Account">Account</a>
                	<ul>
                    	<li><a href="#" title="Login">Login</a></li>
                        <li class="last"><a href="./registration.php" title="Registration">Registration</a></li>
                   	</ul>
               	</li>
                <li><a href="#" title="Contact">Contact</a></li>
            </ul>
        </nav>
		<script>
            (function($){
                //cache nav
                var nav = $("#topNav");
                //add indicators and hovers to submenu parents
                nav.find("li").each(function() {
                    if($(this).find("ul").length > 0) {
                        $("<span>").text("^").appendTo($(this).children(":first"));
                        //show subnav on hover
                        $(this).mouseenter(function() {
                            $(this).find("ul").stop(true, true).slideDown();
                        });
                        //hide subnav on exit
                        $(this).mouseleave(function() {
                            $(this).find("ul").stop(true, true).slideUp();
                        });
                    }
                });
            })(jQuery);
        </script>
        <div id="content"><!--End nav div-->
</body>
</html>
