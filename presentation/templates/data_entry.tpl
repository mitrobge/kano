{* smarty *}
{load_presentation_object filename="data_entry" assign="obj"}

<section class="row">
    <article class="grid_9">
        <form name="bb_health_status_form" id="bb_health_status_form" method="GET" action="{$obj->mLinkToSelf}" class="">
            <h3>Beehive Health Status Monitoring</h3>
            <fieldset>
                <label for="text">Beehive Unique Id:</label>
                <input type="text" name="id" id="id" autocomplete="on" tabindex="1" />
            </fieldset>
            <fieldset>
                <label for="text">uC Battery level:</label>
                <input type="text" name="uc_battery" id="uc_battery" autocomplete="on" tabindex="1" />
            </fieldset>
            <fieldset>
                <label for="text">GSM Battery level:</label>
                <input type="text" name="gsm_battery" id="gsm_battery" autocomplete="on" tabindex="1" />
            </fieldset>
            <fieldset>
                <label for="text">Receiver Signal Strength Indication (RSSI):</label>
                <input type="text" name="rssi" id="rssi" autocomplete="on" tabindex="1" />
            </fieldset>
            <fieldset>
                <input class="green" type="submit" name="health_status_submit" id="health_status_submit" tabindex="33" value="Submit" />
                <input class="white" type="reset" name="reset" id="submitbtn" tabindex="34" value="Reset" />
            </fieldset>
        </form>
    </article>
</section>

<section class="row">
    <article class="grid_9">
        <form name="bb_data_collection_form" id="bb_data_collection_form" method="GET" action="{$obj->mLinkToSelf}" class="">
            <h3>Beehive Data</h3>
            <fieldset>
                <label for="text">Beehive Unique Id:</label>
                <input type="text" name="id" id="id" autocomplete="on" tabindex="1" />
            </fieldset>
            <fieldset>
                <label for="text">Beehive weight:</label>
                <input type="text" name="weight" id="weight" autocomplete="on" tabindex="1" />
            </fieldset>
            <fieldset>
                <label for="text">Beehive internal temperature:</label>
                <input type="text" name="int_temp" id="int_temp" autocomplete="on" tabindex="22" />
            </fieldset>
            <fieldset>
                <label for="text">Beehive external temperature:</label>
                <input type="text" name="ext_temp" id="ext_temp" autocomplete="on" tabindex="22" />
            </fieldset>
            <fieldset>
                <label for="text">Beehive external humidity:</label>
                <input type="text" name="ext_hum" id="ext_hum" autocomplete="on" tabindex="22" />
            </fieldset>
            <fieldset>
                <label for="text">Beehive luminosity:</label>
                <input type="text" name="lum" id="lum" autocomplete="on" tabindex="22" />
            </fieldset>
            <fieldset>
                <label for="text">Beehive Latitude:</label>
                <input type="text" name="Latitude" id="Latitude" autocomplete="on" tabindex="22" />
            </fieldset>
            <fieldset>
                <label for="text">Beehive Longtitude:</label>
                <input type="text" name="Longtitude" id="Longtitude" autocomplete="on" tabindex="22" />
            </fieldset>
            <fieldset>
                <input class="green" type="submit" name="data_submit" id="data_submit" tabindex="33" value="Submit" />
                <input class="white" type="reset" name="reset" id="submitbtn" tabindex="34" value="Reset" />
            </fieldset>
        </form>
    </article>
</section>



<!-- Scripts -->
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/amazium.js"></script>

