<?php /* Smarty version 2.6.22, created on 2015-09-16 21:25:19
         compiled from admin_menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_presentation_object', 'admin_menu.tpl', 2, false),)), $this); ?>
<?php echo smarty_function_load_presentation_object(array('filename' => 'admin_menu','assign' => 'obj'), $this);?>

<div id="topmenu">
    <ul>
    <?php if ($this->_tpl_vars['obj']->mLinkToCategoriesAdmin): ?><li><a href="<?php echo $this->_tpl_vars['obj']->mLinkToCategoriesAdmin; ?>
">My Surveys</a></li><?php endif; ?>
    <?php if ($this->_tpl_vars['obj']->mLinkToFilesAdmin): ?><li><a href="<?php echo $this->_tpl_vars['obj']->mLinkToFilesAdmin; ?>
">Διαχείριση αρχείων</a></li><?php endif; ?>
    <?php if ($this->_tpl_vars['obj']->mLinkToAdministratorsAdmin): ?><li><a href="<?php echo $this->_tpl_vars['obj']->mLinkToAdministratorsAdmin; ?>
">Διαχειριστές</a></li><?php endif; ?>
    <?php if ($this->_tpl_vars['obj']->mLinkToMyAccount): ?><li><a href="<?php echo $this->_tpl_vars['obj']->mLinkToMyAccount; ?>
">Ο λογαριασμός μου</a></li><?php endif; ?>
    <li><a href="<?php echo $this->_tpl_vars['obj']->mLinkToLogout; ?>
">Αποσύνδεση</a></li>
    </ul>
</div>