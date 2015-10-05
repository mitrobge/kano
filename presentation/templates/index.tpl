{* smarty *}
{load_presentation_object filename="index" assign="obj"}
{config_load file="../../properties/messages_"|cat:$obj->mActiveLang|cat:".txt"}
{*{config_load file="/opt/lampp/htdocs/kano/properties/messages_"|cat:$obj->mActiveLang|cat:".txt"}*}
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
  
    {if $obj->mActiveLang eq "gr"}
    <script type="text/javascript" src="assets/js/jquery.validate.js"></script>
    {else}
    <script type="text/javascript" src="assets/js/jquery.validate.en.js"></script>
    {/if}

<section class="row">
    <article class="grid_12">
        <ul id="top_nav">
        <li class="last">
            <ul id="lang">
        		<li class="gr">{#gr#}</li>
        		<li class="en">{#en#}</li>
        	</ul>
            <a style="font-size: 12px;" id="change" href="{$obj->mLinks.toChangeLang}">{#change#}</a>
        </li>
        </ul>
        <a href="{$obj->mUrl}"><img src="{$obj->mUrl}/img/customer-survey.jpg" width="80px" height="80px"></a>
    </article>
</section>
<section class="row">
    <article class="grid_4">
      
      <input type="hidden" name="active_lang" id="active_lang" value="{$obj->mActiveLang}"/>


        <ul>
            <li><a href="{$obj->mLinks.toAllSurveys}">{#kano_surveys#}</a></li>
            <li><a href="{$obj->mLinks.toAllSurveys}?css=true">{#css_surveys#}</a></li>
        </ul>
    </article>
</section>
{include file=$obj->mContentsCell}

<footer>{#email#}: <a href="mailto:{$obj->owner_data[0].email}">{$obj->owner_data[0].email}</a>, {#mobile#}: <a href="tel:{$obj->owner_data[0].mobile_number}">{$obj->owner_data[0].mobile_number}</a></footer>


</body>
</html>
