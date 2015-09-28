<?php /* Smarty version 2.6.22, created on 2015-09-29 01:08:20
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_presentation_object', 'index.tpl', 2, false),array('function', 'config_load', 'index.tpl', 4, false),array('modifier', 'cat', 'index.tpl', 4, false),)), $this); ?>
<?php echo smarty_function_load_presentation_object(array('filename' => 'index','assign' => 'obj'), $this);?>

<?php echo smarty_function_config_load(array('file' => ((is_array($_tmp=((is_array($_tmp="/opt/lampp/htdocs/kano/properties/messages_")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['obj']->mActiveLang) : smarty_modifier_cat($_tmp, $this->_tpl_vars['obj']->mActiveLang)))) ? $this->_run_mod_handler('cat', true, $_tmp, ".txt") : smarty_modifier_cat($_tmp, ".txt"))), $this);?>

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

    <?php echo '
        <script type="text/javascript">
            /mobi/i.test(navigator.userAgent) && !location.hash && setTimeout(function () {
                if (!pageYOffset) window.scrollTo(0, 1);
            }, 1000);
        </script>
    '; ?>


    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['obj']->mUrl; ?>
assets/css/base.css">
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['obj']->mUrl; ?>
assets/css/amazium.css">
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['obj']->mUrl; ?>
assets/css/layout.css">
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['obj']->mUrl; ?>
assets/css/form.css">

    <!-- Favicons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon.png">


    <!-- Add jQuery library -->
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['obj']->mUrl; ?>
assets/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

    <!-- Add fancyBox -->
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['obj']->mUrl; ?>
assets/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['obj']->mUrl; ?>
assets/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

    <!-- Optionally add helpers - button, thumbnail and/or media -->
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['obj']->mUrl; ?>
assets/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['obj']->mUrl; ?>
assets/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['obj']->mUrl; ?>
assets/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['obj']->mUrl; ?>
assets/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['obj']->mUrl; ?>
assets/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

    <script type="text/javascript" src="<?php echo $this->_tpl_vars['obj']->mUrl; ?>
assets/js/actions.js"></script>


</head>
<body>
  
    <?php if ($this->_tpl_vars['obj']->mActiveLang == 'gr'): ?>
    <script type="text/javascript" src="assets/js/jquery.validate.js"></script>
    <?php else: ?>
    <script type="text/javascript" src="assets/js/jquery.validate.en.js"></script>
    <?php endif; ?>

<section class="row">
    <article class="grid_12">
        <ul id="top_nav">
        <li class="last">
            <ul id="lang">
        		<li class="gr"><?php echo $this->_config[0]['vars']['gr']; ?>
</li>
        		<li class="en"><?php echo $this->_config[0]['vars']['en']; ?>
</li>
        	</ul>
            <a style="padding-left:6px; font-size: 12px;" id="change" href="<?php echo $this->_tpl_vars['obj']->mLinks['toChangeLang']; ?>
"><?php echo $this->_config[0]['vars']['change']; ?>
</a>
        </li>
        </ul>
        <a href="<?php echo $this->_tpl_vars['obj']->mUrl; ?>
"><h3>Kano Model</h3></a>
    </article>
</section>
<section class="row">
    <article class="grid_4">
      
      <input type="hidden" name="active_lang" id="active_lang" value="<?php echo $this->_tpl_vars['obj']->mActiveLang; ?>
"/>


        <ul>
            <li><a href="<?php echo $this->_tpl_vars['obj']->mLinks['toAllSurveys']; ?>
"><?php if ($this->_tpl_vars['obj']->mActiveLang == 'gr'): ?>Έρευνες ΚΑΝΟ<?php else: ?>KANO Surveys<?php endif; ?></a></li>
        </ul>
    </article>
</section>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['obj']->mContentsCell, 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<footer><?php echo $this->_config[0]['vars']['email']; ?>
: <?php echo $this->_tpl_vars['obj']->owner_data[0]['email']; ?>
, <?php echo $this->_config[0]['vars']['mobile']; ?>
: <?php echo $this->_tpl_vars['obj']->owner_data[0]['mobile_numebr']; ?>
</footer>


</body>
</html>