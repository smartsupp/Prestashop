{*
 * Smartsupp Live Chat integration module.
 * 
 * @package   Smartsupp
 * @author    Smartsupp <vladimir@smartsupp.com>
 * @link      http://www.smartsupp.com
 * @copyright 2015 Smartsupp.com
 * @license   GPL-2.0+
 *
 * Plugin Name:       Smartsupp Live Chat
 * Plugin URI:        http://www.smartsupp.com
 * Description:       Adds Smartsupp Live Chat code to PrestaShop.
 * Version:           1.0.6
 * Author:            Smartsupp
 * Author URI:        http://www.smartsupp.com
 * Text Domain:       smartsupp
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *}
 
<form enctype="multipart/form-data" method="post" class="defaultForm smartsupp" id="configuration_form">
	<fieldset id="fieldset_0">
		<legend>
			{l s='Settings' mod='smartsupp'}
		</legend>
		<label>{l s='Chat ID' mod='smartsupp'}</label>
		<div class="margin-form">
			<input type="text" value="{$smartsupp_key|escape:'htmlall':'UTF-8'}" id="SMARTSUPP_KEY" name="SMARTSUPP_KEY">&nbsp;<sup>*</sup>
			<span name="help_box" class="hint" style="display: none;">{l s='This information is available in your Smartsupp account' mod='smartsupp'}<span class="hint-pointer"></span></span>  
		</div>
		<div class="clear"></div>
		<label>{l s='Optional API' mod='smartsupp'}</label>
		<div class="margin-form">
			<textarea id="SMARTSUPP_OPTIONAL_API" name="SMARTSUPP_OPTIONAL_API">{$smartsupp_optional_api|escape:'quotes':'UTF-8'}</textarea>
			<span name="help_box" class="hint" style="display: none;">{l s='Enhance chat widget with optional API code' mod='smartsupp'}<span class="hint-pointer"></span></span>  
		</div>
                {*
		<div class="clear"></div>
		<label>{l s='Enable Variables' mod='smartsupp'}</label>
		<div class="margin-form">
			<input type="checkbox" {if $smartsupp_variables_enabled|escape:'htmlall':'UTF-8'}checked="checked"{/if} id="SMARTSUPP_VARIABLES_ENABLED" name="SMARTSUPP_VARIABLES_ENABLED">
			<span name="help_box" class="hint" style="display: none;">{l s='By enabling this option you will be able to see selected variables in your Smartsupp dashboard.' mod='smartsupp'}<span class="hint-pointer"></span></span>  
		</div>
                *}
                <div class="margin-form">
                        <input class="button" type="submit" name="submitsmartsupp" value="{l s='Save' mod='smartsupp'}" id="configuration_form_submit_btn">
		</div>                
		<div class="small"><sup>*</sup> {l s='Required field' mod='smartsupp'}</div>
        </fieldset>
        <br/>
	<fieldset id="fieldset_1">
		<legend>
			{l s='Variables' mod='smartsupp'}
		</legend>
		<label>{l s='Customer\'s ID' mod='smartsupp'}</label>
		<div class="margin-form">
			<input type="checkbox" {if $smartsupp_customer_id|escape:'htmlall':'UTF-8'}checked="checked"{/if} id="SMARTSUPP_CUSTOMER_ID" name="SMARTSUPP_CUSTOMER_ID">
			<span name="help_box" class="hint" style="display: none;">{l s='Shows customer\'s ID.' mod='smartsupp'}<span class="hint-pointer"></span></span>  
		</div>
		<div class="clear"></div>
                <label>{l s='Customer\'s Name' mod='smartsupp'}</label>
		<div class="margin-form">
			<input type="checkbox" {if $smartsupp_customer_name|escape:'htmlall':'UTF-8'}checked="checked"{/if} id="SMARTSUPP_CUSTOMER_NAME" name="SMARTSUPP_CUSTOMER_NAME">
			<span name="help_box" class="hint" style="display: none;">{l s='Shows customer\'s display name.' mod='smartsupp'}<span class="hint-pointer"></span></span>  
		</div>
		<div class="clear"></div>
		<label>{l s='Customer\'s Email' mod='smartsupp'}</label>
		<div class="margin-form">
			<input type="checkbox" {if $smartsupp_customer_email|escape:'htmlall':'UTF-8'}checked="checked"{/if} id="SMARTSUPP_CUSTOMER_EMAIL" name="SMARTSUPP_CUSTOMER_EMAIL">
			<span name="help_box" class="hint" style="display: none;">{l s='Shows customer\'s email.' mod='smartsupp'}<span class="hint-pointer"></span></span>  
		</div>
		<div class="clear"></div>
		<label>{l s='Customer\'s Phone' mod='smartsupp'}</label>
		<div class="margin-form">
			<input type="checkbox" {if $smartsupp_customer_phone|escape:'htmlall':'UTF-8'}checked="checked"{/if} id="SMARTSUPP_CUSTOMER_PHONE" name="SMARTSUPP_CUSTOMER_PHONE">
			<span name="help_box" class="hint" style="display: none;">{l s='Shows customer\'s phone.' mod='smartsupp'}<span class="hint-pointer"></span></span>  
		</div>
		<div class="clear"></div>
		<label>{l s='Customer\'s Role' mod='smartsupp'}</label>
		<div class="margin-form">
			<input type="checkbox" {if $smartsupp_customer_group|escape:'htmlall':'UTF-8'}checked="checked"{/if} id="SMARTSUPP_CUSTOMER_GROUP" name="SMARTSUPP_CUSTOMER_GROUP">
			<span name="help_box" class="hint" style="display: none;">{l s='Shows customer\'s role (group)' mod='smartsupp'}<span class="hint-pointer"></span></span>  
		</div>
		<div class="clear"></div>
		<label>{l s='Customer\'s Spendings' mod='smartsupp'}</label>
		<div class="margin-form">
			<input type="checkbox" {if $smartsupp_customer_spendings|escape:'htmlall':'UTF-8'}checked="checked"{/if} id="SMARTSUPP_CUSTOMER_SPENDINGS" name="SMARTSUPP_CUSTOMER_SPENDINGS">
			<span name="help_box" class="hint" style="display: none;">{l s='Shows customer\'s spendings' mod='smartsupp'}<span class="hint-pointer"></span></span>  
		</div>
		<div class="clear"></div>
		<label>{l s='Customer\'s Orders' mod='smartsupp'}</label>
		<div class="margin-form">
			<input type="checkbox" {if $smartsupp_customer_orders|escape:'htmlall':'UTF-8'}checked="checked"{/if} id="SMARTSUPP_CUSTOMER_ORDERS" name="SMARTSUPP_CUSTOMER_ORDERS">
			<span name="help_box" class="hint" style="display: none;">{l s='Shows customer\'s orders amount' mod='smartsupp'}<span class="hint-pointer"></span></span>  
		</div>
		<div class="clear"></div>
                <div class="margin-form">
                        <input class="button" type="submit" name="submitsmartsupp" value="{l s='Save' mod='smartsupp'}" id="configuration_form_submit_btn">
		</div>
	</fieldset>
</form>
