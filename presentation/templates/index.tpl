{* smarty *}
{load_presentation_object filename="index" assign="obj"}
<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Kano Model</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    {literal}    
    <script type="text/javascript">
        /mobi/i.test(navigator.userAgent) && !location.hash && setTimeout(function () {
          if (!pageYOffset) window.scrollTo(0, 1);
        }, 1000);
    </script>
    {/literal}

	<!-- CSS -->
	<link rel="stylesheet" href="{$obj->mUrl}assets/css/base.css">
	<link rel="stylesheet" href="{$obj->mUrl}assets/css/amazium.css">
	<link rel="stylesheet" href="{$obj->mUrl}assets/css/layout.css">
	<link rel="stylesheet" href="{$obj->mUrl}assets/css/form.css">

	<!-- Favicons -->
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon.png">
        

        <!-- Add jQuery library -->
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

        <!-- Add mousewheel plugin (this is optional) -->
        <script type="text/javascript" src="{$obj->mUrl}assets/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

        <!-- Add fancyBox -->
        <link rel="stylesheet" href="{$obj->mUrl}assets/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
        <script type="text/javascript" src="{$obj->mUrl}assets/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

        <!-- Optionally add helpers - button, thumbnail and/or media -->
        <link rel="stylesheet" href="{$obj->mUrl}assets/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
        <script type="text/javascript" src="{$obj->mUrl}assets/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
        <script type="text/javascript" src="{$obj->mUrl}assets/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

        <link rel="stylesheet" href="{$obj->mUrl}assets/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
        <script type="text/javascript" src="{$obj->mUrl}assets/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
        
        <script type="text/javascript" src="{$obj->mUrl}assets/js/actions.js"></script>


</head>
<body>

<section class="row">
    <article class="grid_12">
      <a href="{$obj->mUrl}"><h1>Kano Model</h1></a>
    </article>
</section>


    {include file='customer_info.tpl'} 
	
    <div style="display: none;">
    {include file="customer_login.tpl"}
    </div>

   <ul>
   <li><a href="{$obj->mLinks.toCalendar}">{if $obj->mActiveLang eq "gr"}Ημερολόγιο{else}Το ημερολόγιό μου{/if}</a></li>
   <li><a href="{$obj->mLinks.toDataEntry}">{if $obj->mActiveLang eq "gr"}Καταχώρηση δεδομένων{else}Data entry{/if}</a></li>
   <li><a href="{$obj->mLinks.toCustomerProfile}">{if $obj->mActiveLang eq "gr"}Προφίλ Χρήστη{else}My Beehive profile{/if}</a></li>
   </ul>
   {include file=$obj->mContentsCell}

</body>
</html>
