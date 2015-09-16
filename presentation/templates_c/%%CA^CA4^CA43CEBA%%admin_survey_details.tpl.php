<?php /* Smarty version 2.6.22, created on 2015-09-16 20:41:37
         compiled from admin_survey_details.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_presentation_object', 'admin_survey_details.tpl', 2, false),)), $this); ?>
<?php echo smarty_function_load_presentation_object(array('filename' => 'admin_survey_details','assign' => 'obj'), $this);?>


<?php echo '
<!-- jquery.datePicker.js --> 

 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
 
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="http://jquery-ui.googlecode.com/svn-history/r3874/branches/labs/datepicker2/ui/i18n/jquery.ui.datepicker-el.js"></script>
<script type="text/javascript" src="assets/js/jquery.validate.js"></script>
<script type="text/javascript" src="assets/js/admin_actions.js"></script>
<script>
    $(function() {
         $( "#datepicker1" ).datepicker({ 
             minDate: 0,
             maxDate: "+365D",
             onSelect: function(selected) {
                 $("#datepicker2").datepicker("option","minDate", selected)
             },
             dateFormat: \'dd-mm-yy\' 
             });
         });
    $(function() {
        $( "#datepicker2" ).datepicker({ 
             minDate: 0,
             maxDate: "+365D",
             onSelect: function(selected) {
                 $("#datepicker1").datepicker("option","maxDate", selected)
             },
             dateFormat: \'dd-mm-yy\' 
             });
        });
    $(function() {
         $( "#datepicker3" ).datepicker({ 
             minDate: 0,
             maxDate: "+365D",
             onSelect: function(selected) {
                 $("#datepicker3").datepicker("option","minDate", selected)
             },
             dateFormat: \'dd-mm-yy\' 
             });
         });
    $(function() {
        $( "#datepicker4" ).datepicker({ 
             minDate: 0,
             maxDate: "+365D",
             onSelect: function(selected) {
                 $("#datepicker4").datepicker("option","maxDate", selected)
             },
             dateFormat: \'dd-mm-yy\' 
             });
        });
</script> 

'; ?>

<?php echo '
<!-- required plugins --> 
<script type="text/javascript" src="scripts/date.js"></script> 
<script type="text/javascript" src="scripts/jquery.dateFormat-1.0.js"></script> 

        <script language="javascript" type="text/javascript">
            /*
               @param1 - sourceid - This is the id of the multiple select box whose item has to be moved.
               @param2 - destinationid - This is the id of the multiple select box to where the iterms should be moved.
             */

        //this will move selected items from source list to destination list     
function move_list_items(sourceid, destinationid)
{
    $("#"+sourceid+"  option:selected").appendTo("#"+destinationid);
}

//this will move all selected items from source list to destination list
function move_list_items_all(sourceid, destinationid)
{
    $("#"+sourceid+" option").appendTo("#"+destinationid);
}

$(document).ready(function(){

        $.urlParam = function(name) {
        var results = new RegExp(\'[\\\\?&]\' + name + \'=([^&#]*)\').exec(window.location.href);
        if (!results) { return 0; }
        return results[1] || 0;
        }

        $("select#category_list").change(function(){
            $.getJSON("json/get_category_products.php",{category_id: $(this).val()}, function(j){
                var options = \'\';
                for (var i = 0; i < j.length; i++) {
                options += \'<option value="\' + j[i].optionValue + \'">\' + j[i].optionDisplay + \'</option>\';
                }
                $("#tmp_spares_list").html(options);
                //$(\'#spares_list option:first\').attr(\'selected\', \'selected\');
                })
            })

        $("input[name=\\"submit_add_spare_item\\"]").click(function(){
            $("#spares_list option").attr("selected", "selected");
            })

        $("select#category_list_group").change(function(){
                $.getJSON("json/get_service_news.php",{product_id: $.urlParam(\'ProductId\'), announcement_category_id: $(this).val()}, function(j){
                    var options = \'\';
                    for (var i = 0; i < j.length; i++) {
                    options += \'<option value="\' + j[i].optionValue + \'">\' + j[i].optionDisplay + \'</option>\';
                    }
                    $("#tmp_groupset_list").html(options);
                    //$(\'#groupset_list option:first\').attr(\'selected\', \'selected\');
                    })
                })

        $("input[name=\\"submit_add_group_item\\"]").click(function(){
                $("#groupset_list option").attr("selected", "selected");
                })

        $("select#category_list_related").change(function(){
                $.getJSON("json/get_service_news.php",{product_id: $.urlParam(\'ProductId\'), announcement_category_id: $(this).val(), }, function(j){
                    var options = \'\';
                    for (var i = 0; i < j.length; i++) {
                    options += \'<option value="\' + j[i].optionValue + \'">\' + j[i].optionDisplay + \'</option>\';
                    }
                    $("#tmp_related_list").html(options);
                    //$(\'#related_list option:first\').attr(\'selected\', \'selected\');
                    })
                })

        $("input[name=\\"submit_add_related_item\\"]").click(function(){
                $("#related_list option").attr("selected", "selected");
                })

        $("#newsearch").click(function(){
                var category = $(\'#category_list_related\').val();
                if (category.length == 0) {
                alert(\'Παρακαλώ επιλέξτε κατηγορία\');
                return;
                }
                $.getJSON("json/get_random_candidate_related_products.php",{category_id: category, product_id: $.urlParam(\'ProductId\')}, function(j){
                    var options = \'\';
                    for (var i = 0; i < j.length; i++) {
                    if (j[i].optionValue != $.urlParam(\'ProductId\'))
                    options += \'<option value="\' + j[i].optionValue + \'">\' + j[i].optionDisplay + \'</option>\';
                    }
                    $("#tmp_related_list").html(options);
                    //$(\'#related_list option:first\').attr(\'selected\', \'selected\');
                    })
                })

        /*
           $("select[name*=availability_status_id]").change(function(){
           var idx = $(this).attr(\'id\').substring($(this).attr(\'id\').lastIndexOf(\'_\') + 1, $(this).attr(\'id\').length);
           var selected = $(this).find(":selected");
           if ($(selected).attr(\'label\') == "0") {
           $("#availability_schedule_" + idx).hide();
           } else if ($(selected).attr(\'label\') == "1") {
           $("#availability_schedule_" + idx).show();
           } else {
           alert(\'Ops: Wrong label number\');
           }
           })
         */

        /*$("#moveright").click(function() {
          $("#tmp_spares_list  option:selected").clone().appendTo("#spares_list");
          })

          $("#moverightall").click(function() {
          $("#tmp_spares_list  option").clone().appendTo("#spares_list");
          })

          $("#moveleft").click(function() {
          $("#spares_list  option:selected").remove();
          })

          $("#moveleftall").click(function() {
          $("#spares_list  option").remove();
          })*/
})
</script>
'; ?>





<form id="form" enctype="multipart/form-data" method="post"
    action="<?php echo $this->_tpl_vars['obj']->mLinkToProductDetailsAdmin; ?>
">
    <?php if (isset ( $_GET['CategoryId'] )): ?>
    <h3>
        <a href="<?php echo $this->_tpl_vars['obj']->mLinkToProductsAdmin; ?>
">Πίσω στις υπηρεσίες</a>
        <br>
        <br>
    </h3>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['obj']->mErrorMessage): ?><p style="color:red"><?php echo $this->_tpl_vars['obj']->mErrorMessage; ?>
</p><?php endif; ?>

    


    <fieldset id="info">
        <br />
        <legend>Πληροφορίες Υπηρεσίας</legend>

        <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['obj']->mProduct['name']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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

        <label style="width:120px;"><?php if ($this->_sections['i']['first']): ?>Όνομα :<?php endif; ?></label>
        <input type="text" name="product_name_<?php echo $this->_tpl_vars['obj']->mProduct['language'][$this->_sections['i']['index']]['language_id']; ?>
"
        value="<?php echo $this->_tpl_vars['obj']->mProduct['name'][$this->_sections['i']['index']]; ?>
" size="60" />
        <?php if (count ( $this->_tpl_vars['obj']->mProduct['name'] ) > 1): ?> 
        <img src="images/<?php echo $this->_tpl_vars['obj']->mProduct['language'][$this->_sections['i']['index']]['language_flag']; ?>
" alt="<?php echo $this->_tpl_vars['obj']->mProduct['language'][$this->_sections['i']['index']]['language_name']; ?>
" width="15" height="15" border="0" />
        <?php endif; ?>
        </br>
        <?php endfor; endif; ?>

        <br />

        <label style="width:120px;">Περιγραφή: </label>
        <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['obj']->mProduct['language']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
        <br />
        <br />
        <?php if (count ( $this->_tpl_vars['obj']->mProduct['description'] ) > 1): ?> 
        <img src="images/<?php echo $this->_tpl_vars['obj']->mProduct['language'][$this->_sections['i']['index']]['language_flag']; ?>
" alt="<?php echo $this->_tpl_vars['obj']->mProduct['language'][$this->_sections['i']['index']]['language_name']; ?>
" width="15" height="15" border="0" />
        <?php endif; ?>
        <?php echo '<textarea class="ckeditor" name="product_description_'; ?><?php echo $this->_tpl_vars['obj']->mProduct['language'][$this->_sections['i']['index']]['language_id']; ?><?php echo '" rows="3" cols="50">'; ?><?php echo $this->_tpl_vars['obj']->mProduct['description'][$this->_sections['i']['index']]; ?><?php echo '</textarea>'; ?>

        <?php endfor; endif; ?>
        <br />
        <br />


    </fieldset>

    <br/>
    <br/>







        <input id="button1" type="submit" name="submit_update_product_info" value="Ενημέρωση" /> 
        <input id="button2" type="Reset" value="Επαναφορά" />
        <input id="button1" type="submit" name="submit_remove_from_catalog" value="Αφαίρεση υπηρεσίας" />

        <br />
        <br />

    </form>

