<?php /* Smarty version 2.6.22, created on 2015-07-18 19:09:40
         compiled from data_collection.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_presentation_object', 'data_collection.tpl', 2, false),)), $this); ?>
<?php echo smarty_function_load_presentation_object(array('filename' => 'data_collection','assign' => 'obj'), $this);?>


<section class="row">
    <article class="grid_9">
        <form name="bb_data_collection_form" id="bb_data_collection_form" method="GET" action="<?php echo $this->_tpl_vars['obj']->mLinkToSelf; ?>
" class="">
            <h3>Beehive Data</h3>
            <fieldset>
                <label for="text">Beehive Unique Id</label>
                <input type="text" name="id" id="id" autocomplete="on" tabindex="1" />
            </fieldset>
            <fieldset>
                <label for="text">Beehive weight</label>
                <input type="text" name="weight" id="weight" autocomplete="on" tabindex="1" />
            </fieldset>
            <fieldset>
                <label for="text">Beehive internal temperature</label>
                <input type="text" name="int_temp" id="int_temp" autocomplete="on" tabindex="22" />
            </fieldset>
            <fieldset>
                <label for="text">Beehive external temperature</label>
                <input type="text" name="ext_temp" id="ext_temp" autocomplete="on" tabindex="22" />
            </fieldset>
            <fieldset>
                <label for="text">Beehive external humidity</label>
                <input type="text" name="ext_hum" id="ext_hum" autocomplete="on" tabindex="22" />
            </fieldset>
            <fieldset>
                <label for="text">Beehive luminosity</label>
                <input type="text" name="lum" id="lum" autocomplete="on" tabindex="22" />
            </fieldset>
            <fieldset>
                <label for="text">Beehive Latitude</label>
                <input type="text" name="Latitude" id="Latitude" autocomplete="on" tabindex="22" />
            </fieldset>
            <fieldset>
                <label for="text">Beehive Longtitude</label>
                <input type="text" name="Longtitude" id="Longtitude" autocomplete="on" tabindex="22" />
            </fieldset>
            <fieldset>
                <input class="green" type="submit" name="submit" id="submitbtn" tabindex="33" value="Submit" />
                <input class="white" type="reset" name="reset" id="submitbtn" tabindex="34" value="Reset" />
            </fieldset>
        </form>
    </article>
</section>



<!-- Scripts -->
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/amazium.js"></script>
