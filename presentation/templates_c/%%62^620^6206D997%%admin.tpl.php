<?php /* Smarty version 2.6.22, created on 2015-09-14 22:22:03
         compiled from admin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_presentation_object', 'admin.tpl', 1, false),)), $this); ?>
<?php echo smarty_function_load_presentation_object(array('filename' => 'admin','assign' => 'obj'), $this);?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <title>KANO MODEL Administration</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="assets/template1/css/theme3.css" />
    <link rel="stylesheet" type="text/css" href="assets/template1/css/style.css" />
    
    <script src="scripts/ckeditor/ckeditor.js" type="text/javascript"></script> 
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    
    <script type="text/javascript" src="assets/js/jquery.tablednd_0_5.js"></script>
    <script src="assets/js/core.js" type="text/javascript"></script>    

      </head>
  <body>
    <div id="container">
    <div id="header">
        <h2>Kano Model: Σελίδες Διαχείρισης </h2>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['obj']->mMenuCell, 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
        <div id="wrapper">
        <div id="content">
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['obj']->mContentsCell, 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </div>
    </div>
</body>
</html>