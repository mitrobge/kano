<?php /* Smarty version 2.6.22, created on 2015-09-14 19:48:34
         compiled from main_categories.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_presentation_object', 'main_categories.tpl', 2, false),array('modifier', 'count', 'main_categories.tpl', 32, false),)), $this); ?>
<?php echo smarty_function_load_presentation_object(array('filename' => 'main_categories','assign' => 'obj'), $this);?>

<?php echo '
<script type="text/javascript" charset="utf-8"> 
$(document).ready(function(){
   $(\'.slider\').bxSlider({
   slideWidth: 700,
   adaptiveHeight: true,
   adaptiveHeightSpeed: 500,
   auto: true,
   mode: \'fade\',
   minSlides: 1,
   maxSlides: 1,
   startSlide: 0,
   slideMargin: 0,
   infiniteLoop: true,
   slideMargin: 0,
   autoControls: false,
   pager: false,
   easing: null,
   controls: true
});
        });
</script>
'; ?>

<!-- Main content Section -->



<div id="main">

        <?php if (( count($this->_tpl_vars['obj']->mBanners) ) == 1): ?>
        <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['obj']->mBanners) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
            <div id="banner" class="grid_9">
                <a href="<?php echo $this->_tpl_vars['obj']->mAnnouncementLink[$this->_sections['i']['index']]; ?>
"><img class="max-img" src="images/<?php echo $this->_tpl_vars['obj']->mBanners[$this->_sections['i']['index']]['banner_image']; ?>
" alt="images/<?php echo $this->_tpl_vars['obj']->mBanners[$this->_sections['i']['index']]['banner_image']; ?>
"/></a>
                <div id="moto">
                    <div class="text">
                            <a href="<?php echo $this->_tpl_vars['obj']->mAnnouncementLink[$this->_sections['i']['index']]; ?>
"><?php echo $this->_tpl_vars['obj']->mBanners[$this->_sections['i']['index']]['banner_title']; ?>
</a>
                            <?php echo $this->_tpl_vars['obj']->mBanners[$this->_sections['i']['index']]['banner_text']; ?>

                    </div>
                </div>
            </div> 
        <?php endfor; endif; ?>
        <?php else: ?>
        <div class="slider">
        <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['obj']->mBanners) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
            <div id="banner" class="grid_9">
                <a href="<?php echo $this->_tpl_vars['obj']->mAnnouncementLink[$this->_sections['i']['index']]; ?>
"><img class="max-img" src="images/<?php echo $this->_tpl_vars['obj']->mBanners[$this->_sections['i']['index']]['banner_image']; ?>
" alt="images/<?php echo $this->_tpl_vars['obj']->mBanners[$this->_sections['i']['index']]['banner_image']; ?>
"/></a>
                <div id="moto">
                    <div class="text">
                            <a href="<?php echo $this->_tpl_vars['obj']->mAnnouncementLink[$this->_sections['i']['index']]; ?>
"><?php echo $this->_tpl_vars['obj']->mBanners[$this->_sections['i']['index']]['banner_title']; ?>
</a>
                            <?php echo $this->_tpl_vars['obj']->mBanners[$this->_sections['i']['index']]['banner_text']; ?>

                    </div>
                </div>
            </div> 
        <?php endfor; endif; ?>
	</div> 
         </br>       
        <?php endif; ?>
        
	
    <div class="clear"></div>
    <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['obj']->mCategories) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
    <?php if ($this->_tpl_vars['obj']->mCategories[$this->_sections['i']['index']]['is_edu'] == 0): ?>
	
        <?php if ($this->_tpl_vars['obj']->mCategories[$this->_sections['i']['index']]['category_id'] == 4): ?>
        <div class="block last">
        <?php else: ?>
        <div class="block">
        <?php endif; ?>
	
        	<div class="grid_3">
		  <a href="<?php echo $this->_tpl_vars['obj']->mCategories[$this->_sections['i']['index']]['link_to_category']; ?>
"><img class="max-img" alt="<?php echo $this->_tpl_vars['obj']->mCategories[$this->_sections['i']['index']]['name']; ?>
" src="images/<?php echo $this->_tpl_vars['obj']->mCategories[$this->_sections['i']['index']]['image']; ?>
" /></a>
		  <div class="text">
		  	<h4><a href="<?php echo $this->_tpl_vars['obj']->mCategories[$this->_sections['i']['index']]['link_to_category']; ?>
"><?php echo $this->_tpl_vars['obj']->mCategories[$this->_sections['i']['index']]['name']; ?>
</a></h4>
		  	<p><?php echo $this->_tpl_vars['obj']->mCategories[$this->_sections['i']['index']]['description']; ?>
</p>
		  </div>
		</div>
	</div>
        <?php endif; ?>
    <?php endfor; endif; ?>

</div>