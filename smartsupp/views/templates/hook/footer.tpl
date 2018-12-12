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

 
{if $smartsupp_key|escape:'htmlall':'UTF-8' eq true}
<script type="text/javascript">
    {if $smartsupp_variables_enabled|escape:'htmlall':'UTF-8' eq true && $smartsupp_variables_js|escape:'quotes':'UTF-8'}
    var prSmartsuppVars = { 
        {$smartsupp_variables_js|escape:'quotes':'UTF-8'} 
    };
    {/if}   
    {literal}
    var _smartsupp = _smartsupp || {};
    {/literal}
    _smartsupp.key = '{$smartsupp_key|escape:'htmlall':'UTF-8'}';
    _smartsupp.cookieDomain = '{$smartsupp_cookie_domain|escape:'htmlall':'UTF-8'}';
    {literal}
    window.smartsupp||(function(d) {
        var o=smartsupp=function(){ o._.push(arguments)},s=d.getElementsByTagName('script')[0],c=d.createElement('script');o._=[];
        c.async=true;c.type='text/javascript';c.charset='utf-8';c.src='//www.smartsuppchat.com/loader.js';s.parentNode.insertBefore(c,s);
    })(document);
    {/literal}
    smartsupp("name", {$smartsupp_dashboard_name|escape:'quotes':'UTF-8'});
    smartsupp("email", {$smartsupp_dashboard_email|escape:'quotes':'UTF-8'});
    {if $smartsupp_variables_enabled|escape:'htmlall':'UTF-8' eq true && $smartsupp_variables_js|escape:'quotes':'UTF-8'}smartsupp('variables', prSmartsuppVars);{/if}
    {if isset($optional_api)}{$optional_api|escape:'quotes':'UTF-8'}{/if}
</script>
{/if}