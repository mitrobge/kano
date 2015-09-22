{* smarty *}
{load_presentation_object filename="contact" assign="obj"}

<script type="text/javascript" src="assets/js/contact.js"></script>

{literal}
<script type="text/javascript">
    $(document).ready(function() {
            $('#f1').submit(function() {
                if ($("#f1").valid())
                $('#progress').show();
                });
            $('#f2').submit(function() {
                if ($("#f2").valid())
                $('#progress').show();
                });
            $('#f3').submit(function() {
                if ($("#f3").valid())
                $('#progress').show();
                });
            setTimeout(function() {
                $('#success').fadeOut(100, function(){
                    // window.location = '{/literal}{$obj->mLinkToHome}{literal}';
                    });
                }, 4000); // <-- time in milliseconds
            });
        </script>
        <style>
            #progress { 
                display: none;
            }
        </style>            
        {/literal}

        {literal}
        <script type="text/javascript">
            $(document).ready(function(){
                    $('#f1, #f2, #f3').hide();

                    $('#inspection_date_1').datepicker();
                    $('input[name="switcher"]').each(function(i, item){
                        $(item).attr('checked', false);
                        });

                    forms = ['#f1', '#f2', '#f3'];


                    $('input[name="switcher"]').click(function(){
                        var form = $(this).attr('id');
                        if($(this).is(':checked')){

                        show_fields(form);
                        }else{

                        hide_fields(form);
                        }

                        })

                    function show_fields(target){

                        $('#f1, #f2, #f3').hide();
                        $(forms[target]).show();

                    }


                    $("#f1").validate()
            })
        </script>
        {/literal}



        <div id="main">
            <ul class="grid_9" id="breadcrumps">
                <li><a href="{$obj->mLinkToHome}">{if $obj->mActiveLang eq 'gr'}Αρχική{else}Home{/if}</a></li>
                <li>{if $obj->mActiveLang eq 'gr'}Επικοινωνία{else}Contact{/if}</li>
            </ul>
            <div class="clear"></div>
            <div id="contact" class="grid_3">

                <img class="max-img" src="images/shutterstock_110195051.jpg" />
                <p>
                <strong>{if $obj->mActiveLang eq 'gr'}ΚΕΝΤΡΙΚΑ ΓΡΑΦΕΙΑ:{else}HEADQUARTERS:{/if}</strong><br>
                {if $obj->mActiveLang eq 'gr'}Λεωφ. Μεσογείων 429, 15343{else}429, Mesogeion Avenue, 15343{/if}<br>
                {if $obj->mActiveLang eq 'gr'}Αγία Παρασκευή{else}Agia Paraskevi{/if}<br>
                <strong>Τ:</strong> +30 210 5220920<br>
                <strong>F:</strong> +30 210 5203990<br>
                <strong>E:</strong> <a href=mailto:info@tuvaustriahellas.gr>info@tuvaustriahellas.gr</a>
                </p>

                <p>
                <strong>{if $obj->mActiveLang eq 'gr'}ΠΑΡΑΡΤΗΜΑ Β.ΕΛΛΑΔΑΣ:{else}NORTHERN GREECE BRANCH:{/if}</strong><br>
                {if $obj->mActiveLang eq 'gr'}Χάλκης 8 <br/>10<sup>o</sup> χμ. Εθνικής Οδού <br>Θεσσαλονίκης-Μουδανιών
                {else}8, Chalkis str. <br/>10 <sup>th</sup> km Thessalonikis – Moudanion{/if}<br>
                {if $obj->mActiveLang eq 'gr'}570 01, Πυλαία Θεσσαλονίκη{else}570 01, Pylaia Thessaloniki{/if}<br>
                <strong>{if $obj->mActiveLang eq 'gr'} Τ.Θ.:{else}P.O:{/if}</strong> 4207<br>
                <strong>Τ:</strong> +30 2310 941100 <br> 
                <strong>F:</strong> +30 2310 941105 <br>
                <strong>E:</strong> <a href="mailto:thessaloniki@tuvaustriahellas.gr" target="_top">thessaloniki@tuvaustriahellas.gr</a>
                </p>

                <p>
                <strong>{if $obj->mActiveLang eq 'gr'}ΠΑΡΑΡΤΗΜΑ ΚΡΗΤΗΣ:{else}BRANCH OF CRETE:{/if}</strong><br>
                {if $obj->mActiveLang eq 'gr'}Ανδρέα Παπανδρέου 6{else}6, Andrea Papandreou Ave.{/if}<br>71305, {if $obj->mActiveLang eq 'gr'}Ηράκλειο Κρήτης{else}Heraklion Crete{/if}<br>
                <strong>Τ:</strong> +30 2810 244150 <br> 
                <strong>F:</strong> +30 2810 244551 <br>
                <strong>E:</strong> <a href="mailto:iraklio@tuvaustriahellas.gr" target="_top">iraklio@tuvaustriahellas.gr</a>
                </p>
                <p>
                <strong>{if $obj->mActiveLang eq 'gr'}ΠΑΡΑΡΤΗΜΑ ΑΙΓΑΙΟΥ:{else}BRANCH OF AEGEAN:{/if}</strong><br>
                {if $obj->mActiveLang eq 'gr'}Θεοκρίτου 57{else}57, Theokritou str.{/if}<br>81100, {if $obj->mActiveLang eq 'gr'}Μυτιλήνη{else}Mytilini{/if}<br>
                <strong>Τ:</strong> +30 22510 40504-5 <br> 
                <strong>F:</strong> +30 22510 40502 <br>
                <strong>E:</strong> <a href="mailto:mitilini@tuvaustriahellas.gr" target="_top">mitilini@tuvaustriahellas.gr</a>
                </p>
                <div class="widget" id="premises">
                    <div class="container">
                        <ul><li><p><a href="{$obj->mLinks.toBranches}">{if $obj->mActiveLang eq 'gr'}Όλα τα Γραφεία/Θυγατρικές{else}All Premises{/if}</a></p></li></ul>
                    </div>
                </div>

            </div>

            <div class="grid_6" id="contact">

                <h1>{if $obj->mActiveLang eq 'gr'}Επικοινωνία{else}Contact{/if}</h1>


                <fieldset class="row" id="application_switcher">
                    <div class="grid_6">
                        <input type="radio" name="switcher" style="vertical-align: -2px;" id="0"/>{if $obj->mActiveLang eq 'gr'}Προσφορά{else}Ask for an offer{/if}<br>
                        <input type="radio" name="switcher" style="vertical-align: -2px;" id="1"/>{if $obj->mActiveLang eq 'gr'}Ενημέρωση{else}Ask for information{/if}<br>  
                        <input type="radio" name="switcher" style="vertical-align: -2px;" id="2"/>{if $obj->mActiveLang eq 'gr'}Παράπονα{else}Complaints{/if}
                    </div>
                </fieldset>
                
                <div class="info_box" id="progress">
                {if $obj->mActiveLang eq 'gr'}
                Παρακαλώ περιμένετε...
                {else}
                Please wait...
                {/if}
                </div>
                
                {if $obj->mShowSuccessMessage}
                <div class="success_box" id="success">
                {if $obj->mActiveLang eq 'gr'}
                Ευχαριστούμε που επικοινωνήσατε μαζί μας!<br>
                Σύντομα ένας συνεργάτης μας θα επικοινωνήσει μαζί σας.
                </div>
                {else}
                Thank you for your message!<br>
                We will contact you soon.
                </div> 
                {/if}
                {/if}
                    
                
                {if $obj->mShowErrorMessage}
                <div class="error_box">
                {if $obj->mActiveLang eq 'gr'}
                Παρουσιάστηκε σφάλμα κατά την αποστολή του μηνύματός σας!<br>
                Παρακαλούμε δοκιμάστε ξανά αργότερα.
                {else}
                An error occured while sending your message!<br>             
                Please try again later.
                {/if}
                {/if}


                <form name="f1" id="f1" action="{$obj->mLinkToSelf}" method="post">
                    <fieldset  class="row">
                        <legend class="grid_6">{if $obj->mActiveLang eq 'gr'}Προσφορά{else}Ask for an offer{/if}</legend>


                        <div class="grid_6">
                            <label for="company_name_1">{if $obj->mActiveLang eq 'gr'}Όνομα Εταιρείας:{else}Company Name:{/if}</label><input type="text" name="company_name_1" id="company_name_1"/>
                            <label for="company_responsible_1">{if $obj->mActiveLang eq 'gr'}Όνομα Υπεύθυνου:*{else}Name of responsible:*{/if}</label><input type="text" name="company_responsible_1" id="company_responsible_1"/>
                            <label for="standard_1">{if $obj->mActiveLang eq 'gr'}Υπηρεσία:*{else}Service:*{/if}</label>           

                            <select style="width:100%;" name="standard_1">
                                <option value="">{if $obj->mActiveLang eq 'gr'}Παρακαλώ επιλέξτε...{else}Please select...{/if}</option>
                                {section name=i loop=$obj->mCategories}
                                {if !$obj->mCategories[i].is_edu}

                                <option value="" disabled></option>
                                <option value="" style="font-weight:bold; color:#ED1C24;" disabled>{$obj->mCategories[i].name}</option>
                                {section name=j loop=$obj->mCategories[i].subcategories}

                                {if !$obj->mCategories[i].subcategories[j].is_service}

                                <option value="" style="font-style:italic; color:black;" disabled>{$obj->mCategories[i].subcategories[j].name}</option>

                                {section name=z loop=$obj->mCategories[i].subcategories[j].services}
                                <option title="{$obj->mCategories[i].subcategories[j].services[z].name}" value="{$obj->mCategories[i].subcategories[j].services[z].name}">&nbsp;{$obj->mCategories[i].subcategories[j].services[z].name}</option>
                                {/section}

                                {else}
                                <option title="{$obj->mCategories[i].subcategories[j].name}" value="{$obj->mCategories[i].subcategories[j].name}">&nbsp;{$obj->mCategories[i].subcategories[j].name}</option>
                                {/if}

                                {/section}
                                {/if}


                                {/section}
                                <option value="Άλλη υπηρεσία">{if $obj->mActiveLang eq 'gr'}Άλλη υπηρεσία{else}Other service{/if}</option>
                            </select>


                            <label for="company_phone_1">{if $obj->mActiveLang eq 'gr'}Τηλέφωνο:*{else}Phone:*{/if}</label><input type="text" name="company_phone_1" id="company_phone_1"/>
                            <label for="company_address_1">{if $obj->mActiveLang eq 'gr'}Πόλη:{else}City:{/if}</label><input type="text" name="company_address_1" id="company_address_1"/>
                           {* <label for="priority_1">{if $obj->mActiveLang eq 'gr'}Προτεραιότητα:{else}Priority:{/if}</label><input type="text" name="priority_1" id="priority_1"/>*}
                            <label for="company_email_1">E-mail:</label><input type="text" name="company_email_1" id="company_email_1"/>
                            <label for="message_1">{if $obj->mActiveLang eq 'gr'}Σχόλια:{else}Comments:{/if}</label>
                            <textarea style="width:73%;" name="message_1" id="message_1" cols="70" rows="5"></textarea>
                            <br>
                            <em>{if $obj->mActiveLang eq 'gr'}*Υποχρεωτικό πεδίο{else}*Required field{/if}</em>
                        </div>
                    </fieldset>
                    <input class="btn" type="submit" name="contact_f1_submit" id="contact_f1_submit" value={if $obj->mActiveLang eq 'gr'}"Αποστολή"{else}"Submit"{/if}/>
                    <input class="btn" type="reset" value={if $obj->mActiveLang eq 'gr'}"Καθαρισμός"{else}"Reset"{/if}/>
                </form>

                <form name="f2" id="f2" action="{$obj->mLinkToSelf}" method="post">
                    <fieldset  class="row">
                        <legend class="grid_6">{if $obj->mActiveLang eq 'gr'}Ενημέρωση{else}Ask for information{/if}</legend>
                        <div class="grid_6">
                            <label>{if $obj->mActiveLang eq 'gr'}Θα ήθελα να ενημερωθώ για τις ακόλουθες υπηρεσίες*{else}I would like to get informed for the following services:*{/if}</label>

                            <input name="field_2[]" type="checkbox" id="0" value="0"/>{if $obj->mActiveLang eq 'gr'}Πιστοποίησης Συστημάτων Διαχείρισης & Προϊόντων{else}Management Systems & Products Certification{/if}<br>
                            <input name="field_2[]" type="checkbox" id="1" value="1"/>{if $obj->mActiveLang eq 'gr'}Ανελκυστήρων και Ανυψωτικών Μηχανημάτων{else}Lifts and Lifting Equipment{/if}<br>
                            <input name="field_2[]" type="checkbox" id="2" value="2"/>{if $obj->mActiveLang eq 'gr'}Βιομηχανικών Ελέγχων{else}Industrial Inspections{/if}<br>
                            <input name="field_2[]" type="checkbox" id="3" value="3"/>{if $obj->mActiveLang eq 'gr'}Πιστοποίησης προσώπων{else}People Certification{/if}<br>
                            <input name="field_2[]" type="checkbox" id="4" value="4"/>{if $obj->mActiveLang eq 'gr'}Εκπαίδευσης{else}Education{/if}<br><br>
                            <label for="company_name_2">{if $obj->mActiveLang eq 'gr'}Όνομα εταιρείας:{else}Company Name:{/if}</label><input type="text" name="company_name_2" id="company_name_2"/>
                            <label for="company_responsible_2">{if $obj->mActiveLang eq 'gr'}Όνομα υπευθύνου:*{else}Name of responsible:*{/if}</label><input type="text" name="company_responsible_2" id="company_responsible_2"/>
                            <label for="company_email_2">E-mail:</label><input type="text" name="company_email_2" id="company_email_2"/>
                            <label for="company_phone_2">{if $obj->mActiveLang eq 'gr'}Τηλέφωνο:*{else}Phone:*{/if}</label><input type="text" name="company_phone_2" id="company_phone_2"/>
                            <label for="message_2">{if $obj->mActiveLang eq 'gr'}Σχόλια:{else}Comments:{/if}</label>
                            <textarea style="width:73%;" name="message_2" id="message_2" cols="70" rows="5"></textarea>
                            <br>
                            <em>{if $obj->mActiveLang eq 'gr'}*Υποχρεωτικό πεδίο{else}*Required field{/if}</em>
                        </div>
                    </fieldset>
                    <input class="btn" type="submit" name="contact_f2_submit" id="contact_f2_submit" value={if $obj->mActiveLang eq 'gr'}"Αποστολή"{else}"Submit"{/if}/>
                    <input class="btn" type="reset" value={if $obj->mActiveLang eq 'gr'}"Καθαρισμός"{else}"Reset"{/if}/>
                </form>
                <form name="f3" id="f3" action="{$obj->mLinkToSelf}" method="post">
                    <fieldset class="row">
                        <legend class="grid_6">{if $obj->mActiveLang eq 'gr'}Παράπονα{else}Complaints{/if}</legend>
                        <div class="grid_6">
                            <label for="company_name_3">{if $obj->mActiveLang eq 'gr'}Όνομα εταιρείας:{else}Company name:{/if}</label><input type="text" name="company_name_3" id="company_name_3"/>
                            <label for="company_responsible_3">{if $obj->mActiveLang eq 'gr'}Όνομα υπευθύνου:*{else}Name of responsible:*{/if}</label><input type="text" name="company_responsible_3" id="company_responsible_3"/>
                            <label for="company_email_3">E-mail:</label><input type="text" name="company_email_3" id="company_email_3"/>
                            <label for="company_phone_3">{if $obj->mActiveLang eq 'gr'}Τηλέφωνο:*{else}Phone:*{/if}</label><input type="text" name="company_phone_3" id="company_phone_3"/>
                            <label for="message_3">{if $obj->mActiveLang eq 'gr'}Σχόλια:{else}Comments:{/if}</label>
                            <textarea style="width:73%;" name="message_3" id="message_3" cols="70" rows="5"></textarea>
                            <br>
                            <em>{if $obj->mActiveLang eq 'gr'}*Υποχρεωτικό πεδίο{else}*Required field{/if}</em>
                            <br>
                            <br>
                        </div>

                    </fieldset>
                    {if $obj->mActiveLang eq 'gr'}
                    <a href="docs/diaxeirisi-paraponwn.pdf" target="_blank"><img src="assets/css/img/pdf-icon.jpeg" alt="Διαχείριση παραπόνων" height="30" width="30"></a>    <a href="docs/diaxeirisi-paraponwn.pdf" target="_blank">Διαχείριση Παραπόνων και Προσφυγών</a>
                    {else}
                    <a href="docs/Complaints-and-Appeals-Management.pdf" target="_blank"><img src="assets/css/img/pdf-icon.jpeg" alt="Complaints and Appeals" height="30" width="30"></a>    <a href="docs/Complaints-and-Appeals-Management.pdf" target="_blank">Complaints and Appelas Management</a>
                    {/if}
                    <br/>
                    <br/>
                    <input class="btn" type="submit" name="contact_f3_submit" id="contact_f3_submit" value={if $obj->mActiveLang eq 'gr'}"Αποστολή"{else}"Submit"{/if}/>
                    <input class="btn" type="reset" value={if $obj->mActiveLang eq 'gr'}"Καθαρισμός"{else}"Reset"{/if}/>

                </form>







        </div>
    </div>
