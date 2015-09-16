<?php /* Smarty version 2.6.22, created on 2015-09-14 20:25:32
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_presentation_object', 'index.tpl', 2, false),)), $this); ?>
<?php echo smarty_function_load_presentation_object(array('filename' => 'index','assign' => 'obj'), $this);?>

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

<section class="row">
    <article class="grid_12">
      <a href="<?php echo $this->_tpl_vars['obj']->mUrl; ?>
"><h1>Kano Model</h1></a>
    </article>
</section>


    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'customer_info.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
	
    <div style="display: none;">
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer_login.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>

   <ul>
   <li><a href="<?php echo $this->_tpl_vars['obj']->mLinks['toCalendar']; ?>
"><?php if ($this->_tpl_vars['obj']->mActiveLang == 'gr'): ?>Ημερολόγιο<?php else: ?>Το ημερολόγιό μου<?php endif; ?></a></li>
   <li><a href="<?php echo $this->_tpl_vars['obj']->mLinks['toDataEntry']; ?>
"><?php if ($this->_tpl_vars['obj']->mActiveLang == 'gr'): ?>Καταχώρηση δεδομένων<?php else: ?>Data entry<?php endif; ?></a></li>
   <li><a href="<?php echo $this->_tpl_vars['obj']->mLinks['toCustomerProfile']; ?>
"><?php if ($this->_tpl_vars['obj']->mActiveLang == 'gr'): ?>Προφίλ Χρήστη<?php else: ?>My Beehive profile<?php endif; ?></a></li>
   </ul>
   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['obj']->mContentsCell, 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</body>
</html>