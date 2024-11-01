<?php

/**
	* Plugin Name: TCG Card Links
	* Plugin URI: http://www.indrajeet.pixub.com/
	* Description:  The goal of this Plug-in is to provide an instantaneous way for you to turn all Magic: the Gathering card names within your blog posts into card information links with Low-Mid-Hi pricing! from over 30 of the internets cheapest vendors! Click the "MTG Card Shortcode" button to genrate shortcode for links.  
	* Version: 1.0
	* Author: Indrajeet Pal
	* Author URI: http://www.indrajeet.pixub.com/
	* License: GPL2
*/

require_once( 'constants.inc.php' );
if ( ! defined( 'ABSPATH' ) )
	die( "Can't load this file directly" );

	add_action( 'init', 'mtgCardsRef_load_javascript' );
	add_action( 'admin_menu', 'mtgCardsRef_settings_menu' );
	add_action( 'admin_init', 'mtgCardsRef_add_before_jquery_and_options' );
	function mtgCardsRef_load_javascript() {
		wp_enqueue_script( mtgCardsRef_PLUGIN_NAME . '_cluetip', WP_PLUGIN_URL . '/tcg-card-links/js/jquery.cluetip.min.js', array('jquery') );
		wp_enqueue_script( 'mtgCardsRef', WP_PLUGIN_URL . '/tcg-card-links/js/mtgCardsRef.js', array('jquery') );
		wp_enqueue_style( 'mtgCardsRef',WP_PLUGIN_URL . '/tcg-card-links/css/jquery.cluetip.css' );
	}
	
function mtgCardsRef_settings_menu() {
		add_options_page('Options for the Magic the Gathering card links plugin', 'TCG Card Links', 'install_plugins', 'mtgCardsRef_settings', 'mtgCardsRef_display_options');
	}
add_option( mtgCardsRef_PLUGIN_NAME . '_partner_code', 'WORDPRESS', null, 'no' );
	
function mtgCardsRef_add_before_jquery_and_options() {
	register_setting( 'mtgCardsRef_options', mtgCardsRef_PLUGIN_NAME . '_partner_code' );
	}

	
	function mtgCardsRef_display_options() {
		$partner_code = get_option( mtgCardsRef_PLUGIN_NAME . '_partner_code' );
		$partner_code_name = mtgCardsRef_PLUGIN_NAME . '_partner_code';
		$save_changes_text = __( 'Save Changes' );

		echo <<<OPTION_END
<div class="wrap">
	<h2>Magic the Gathering card links options</h2>
	<p>Enter a partner key for your Blog other than "WORDPRESS". The name must contain between 6 and 10 capital letters. This setting is optional.</p>
	<form method="post" action="options.php">
OPTION_END;
		
		settings_fields( 'mtgCardsRef_options' );

		echo <<<OPTION_END
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Partner Key</th>
				<td><input type="text" name="$partner_code_name" value="$partner_code" /></td>
			</tr>
		</table>
		<p class="submit"><input type="submit" class="button-primary" value="$save_changes_text" /></p>
	</form>
</div>
OPTION_END;
	}	

function bartag_func1( $atts ){
		extract( shortcode_atts( array(
		'cardname' => 'something',
		'setname' => 'something else',
		'cardtype' => 'magic',
		'linktext' => '',
		), $atts ) );
				$cardname = stripslashes( $cardname );
				$setname = stripslashes( $setname );

		$partner_code = get_option( mtgCardsRef_PLUGIN_NAME . '_partner_code' );
	if($cardtype=='magic' || $cardtype==''){
		$magiclink='http://partner.tcgplayer.com/x3/phl.asmx/p?pk='.$partner_code.'&p='.urlencode($cardname).'&s='.urlencode($setname);
		}
		$xml=@simplexml_load_file($magiclink);
		if($linktext==''){
			$linktext=$cardname;
		}
	if ($xml===false) {
	$html = "<span style='color:#ff0000; font-weight:bold'>Card Details Incorrect.</span>";
	} else {
    $id= $xml->product[0]->id;
		$hiprice= $xml->product[0]->hiprice;
		$lowprice= $xml->product[0]->lowprice;
		$avgprice= $xml->product[0]->avgprice;
		$foilavgprice= $xml->product[0]->foilavgprice;
		$link= $xml->product[0]->link;

	$html = '<a class="mtgcardref_rollover" href="'.$link.'" rel="'.WP_PLUGIN_URL . '/tcg-card-links/api.php?c='.$cardname.'&s='.$setname.'&pk='.$partner_code.'">';
	$html .= $linktext.'</a>';
}
	return $html;
	}
	add_shortcode('mtg', 'bartag_func1');

class TCGCards
{
	function __construct() {
		add_action( 'admin_init', array( $this, 'action_admin_init' ) );
	}
	
	function action_admin_init() {
		// only hook up these filters if we're in the admin panel, and the current user has permission
		// to edit posts and pages
		if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
			add_filter( 'mce_buttons', array( $this, 'filter_mce_button' ) );
			add_filter( 'mce_external_plugins', array( $this, 'filter_mce_plugin' ) );
		}
	}
	
	function filter_mce_button( $buttons ) {
		// add a separation before our button, here our button's id is "mygallery_button"
		array_push( $buttons, '|', 'mygallery_button' );
		return $buttons;
	}
	
	function filter_mce_plugin( $plugins ) {
		// this plugin file will work the magic of our button
		$plugins['mygallery'] = plugin_dir_url( __FILE__ ) . 'tcgcardlinks_plugin.js';
		return $plugins;
	}
	

}

$mygallery = new TCGCards();

/*

*/
