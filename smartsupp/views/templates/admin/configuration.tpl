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

<div class="panel">
	<div class="row" id="smartsupp_top">
		<div class="col-lg-6">
			<img src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/smartsupp_logo.png" alt="Smartsupp" />
		</div>
		<div class="col-lg-6 text-right">
			<span>{l s='Not a Smartsupp user yet?' mod='smartsupp'}</span>
                        <a class="btn btn-default btn-lg" href="https://www.smartsupp.com/?utm_source=Prestashop&utm_medium=integration&utm_campaign=link" target='_blank' rel="external">{l s='Create free account' mod='smartsupp'}</a>
		</div>
	</div>
</div>