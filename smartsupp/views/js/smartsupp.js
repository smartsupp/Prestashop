/**
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
 * Description:       Smartsupp live chat module for Prestashop 1.5 and 1.4.7
 * Version:           1.0.4
 * Author:            Smartsupp
 * Author URI:        http://www.smartsupp.com
 * Text Domain:       smartsupp
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

$(document).ready(function() {
    
    var cntrl = null;
    var text = null;
    var format = 'target="_blank" style="color: #0000EE"';

    cntrl = $( "#SMARTSUPP_KEY" ).next();
    if (cntrl.html() === '*') {
        cntrl = $( "#SMARTSUPP_KEY" ).next().next();
    }
    text = cntrl.html();
    cntrl.html(text.replace('$', '<a href="https://dashboard.smartsupp.com/?target=widget:embed&utm_source=Prestashop1.5&utm_medium=integration&utm_campaign=link"' + format + '>').replace('$', '</a>'));

    cntrl = $( "#SMARTSUPP_OPTIONAL_API" ).next();
    text = cntrl.html();
    cntrl.html(text.replace('$', '<a href="https://developers.smartsupp.com/?utm_source=Prestashop1.5&utm_medium=integration&utm_campaign=link"' + format + '>').replace('$', '</a>'));

});