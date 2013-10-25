<?php error_reporting(0); ?><?php
/* 
Plugin Name: Heureka XML feed FREE
Plugin URI: http://www.podujatie.eu/
Version: 3.01
Description: Generuje xml feed pre heureka od woocommerce produktov. Vytvoril Andrej Kóňa v spolupráci s Podujatie.eu. 
Author: Podujatie.eu, Ing. Igor Kona
Author URI: http://andrej.kona-slovakia.eu
License: GNU General Public License version 3.0
License: SW sa nesmie ďalej predávať, ani akokoľvek šíriť bez vedomia a dohody s autorom. SW licencia je platná na všetky weby v rámci jednej domény jedného kupujúceho. Autor nenesie zodpovednosť pokiaľ SW akokoľvek poškodí dáta, alebo spôsobí škodu. Kúpou a platbou súhlasíte s týmto licenčným dojednaním. Autor si ďalej vyhradzuje právo úpravy tohto licenčného dojednania. Platba je jednorazová a sú v nej zahrnuté prípadné aktualizácie a pomoc pri štandardnej inštalácii. 
*/
/*  Copyright 2013  Podujatie.eu  (email : office@podujatie.eu)

SW sa nesmie ďalej predávať, ani akokoľvek šíriť bez vedomia a dohody s autorom. SW licencia je platná na všetky weby v rámci jednej domény jedného kupujúceho. Autor nenesie zodpovednosť pokiaľ SW akokoľvek poškodí dáta, alebo spôsobí škodu. Kúpou a platbou súhlasíte s týmto licenčným dojednaním. Autor si ďalej vyhradzuje právo úpravy tohto licenčného dojednania. Platba je jednorazová a sú v nej zahrnuté prípadné aktualizácie a pomoc pri štandardnej inštalácii. Zasahovanie do kódu pluginu, jeho časti či akákoľvek úprava je zakázaná. V opačnom prípade autor nenesia žiadnu zodpovednosť a taktiež povinnosť na akejkoľvek náprave.

Ďalšie šírenie tohto pluginu je ZAKÁZANÉ!! Zákon č. 618/2003 Z.z. o autorskom práve a právach súvisiacich s autorským právom (autorský zákon) a Zákon č. 300/2005 Z.z. Trestný zákon, §283 Porušovanie autorského práva.

Ing. Igor Kona; IČO: 43729444; DIČ: 1078646503IČ; DPH: SK1078646503; platobné údaje na stránke Podujatie.eu.
*/

if (!isset($wpdb)) $wpdb = $GLOBALS['wpdb'];

//Načítanie update
require plugin_dir_path( __FILE__ ) . 'update-notifier-heureka-feed-free.php';

//Define the product feed php page
function podujatie3_feed_rss3() {
 $rss_template = dirname(__FILE__) . "/".heureka.'/product-feed-heureka.php';
 load_template ( $rss_template );
}

//Add the product feed RSS
add_action('do_feed_heureka', 'podujatie3_feed_rss3', 10, 1);

//Update the Rerewrite rules
add_action('init', 'moje_pridanie_produkt_heureka');

//function to add the rewrite rules
function moje_prepisanie_produktov_pravidlo3( $wp_rewrite ) {
 $new_rules = array(
 'feed/(.+)' => 'index.php?feed='.$wp_rewrite->preg_index(1)
 );
 $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
  if ( !defined('ABSPATH') ) {
    /** Load WordPress Bootstrap */
    require_once('../../../wp-load.php');
}
}

//Plugin settings link
$plugin_file = 'heureka-feed/feed.php';
add_filter( "plugin_action_links_{$plugin_file}", 'csplitpro_plugin_action_links', 10, 2 );
 
//modify the link by unshifting the array
function csplitpro_plugin_action_links( $links, $file ) {
	$settings_link = '<a href="' . admin_url( 'admin.php?page=heureka-feed/feed.php' ) . '">' . __( 'Nastavenia', 'podujatie_heureka' ) . '</a>';
	array_unshift( $links, $settings_link );
 
	return $links;
}

//add the rewrite rule
function moje_pridanie_produkt_heureka( ) {
 global $wp_rewrite;
 add_action('generate_rewrite_rules', 'moje_prepisanie_produktov_pravidlo3');
 $wp_rewrite->flush_rules();
 //Načítanie jazyka
load_plugin_textdomain( 'podujatie_heureka', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

$podujatie3_ver = '3.00';

/* 
 * NEMENIT - inak moze nastat poskodenie systemu
 */
add_option('products_in_feed', 50);
add_option('feed_title', '');
add_option('product_condition', 'nové');
add_option('product_dph', 'DPH');
add_option('product_na_sklade', 'na sklade');
add_option('product_out_stock', 'mimo skladu');
add_option('product_type', 'Software &gt; Wordpress &gt; Plugin');

add_option('podujatie3_what_to_show', 'both');
add_option('podujatie3_which_first', 'posts');
add_option('podujatie3_post_sort_order', 'title');
add_option('podujatie3_page_sort_order', 'title');
add_option('podujatie3_comments_on_posts', FALSE);
add_option('podujatie3_comments_on_pages', FALSE);
add_option('podujatie3_show_zero_comments', FALSE);
add_option('podujatie3_hide_future', FALSE);
add_option('podujatie3_new_window', FALSE);
add_option('podujatie3_show_post_date', FALSE);
add_option('podujatie3_show_page_date', FALSE);
add_option('podujatie3_date_format', 'F jS, Y');
add_option('podujatie3_hide_protected', TRUE);

add_option('podujatie3_excluded_pages', '');
add_option('podujatie3_page_nav', '1');
add_option('podujatie3_page_nav_where', 'top');
add_option('podujatie3_xml_path', '');

add_option('podujatie3_xml_where', 'last');

/*
 * Nastavenie na stránke pluginu v nastaveniach systemu
 */
function podujatie3_xml_feed2() {
	if (function_exists('add_options_page')) {
		add_options_page('XML Feed heureka', 'XML Feed heureka', 'manage_options', __FILE__, 'podujatie3_options_page');
	}
}

/* 
 * Vygenerovanie nastaveni
 */
function podujatie3_options_page() {

	global $podujatie3_ver;

	if (isset($_POST['set_defaults'])) {
		echo '<div id="message" class="updated fade"><p><strong>';

		update_option('products_in_feed', 50);
		update_option('feed_title', '');
		update_option('product_condition', 'new');
		update_option('podujatie3_what_to_show', 'both');
		update_option('podujatie3_which_first', 'posts');	
		update_option('podujatie3_post_sort_order', 'title');
		update_option('podujatie3_page_sort_order', 'title');
		update_option('podujatie3_comments_on_posts', FALSE);
		update_option('podujatie3_comments_on_pages', FALSE);
		update_option('podujatie3_show_zero_comments', FALSE);
		update_option('podujatie3_hide_future', FALSE);
		update_option('podujatie3_new_window', FALSE);
		update_option('podujatie3_show_post_date', FALSE);
		update_option('podujatie3_show_page_date', FALSE);
		update_option('podujatie3_date_format', 'F jS, Y');
		update_option('podujatie3_hide_protected', TRUE);
		update_option('podujatie3_excluded_pages', '');
		update_option('podujatie3_page_nav', '1');
		update_option('podujatie3_page_nav_where', 'top');
		update_option('podujatie3_xml_path', '');
		update_option('product_type', 'Software &amp;gt; Wordpress &amp;gt; Plugin');
			update_option('product_dph', 'DPH');
			update_option('product_na_sklade', 'na sklade');
			update_option('product_out_stock', 'mimo skladu');
		update_option('podujatie3_xml_where', 'last');

		echo Nastavenia_upravene;
		echo '</strong></p></div>';	

	} else if (isset($_POST['info_update'])) {

		echo '<div id="message" class="updated fade"><p><strong>';

		update_option('podujatie_language3', (string) $_POST["podujatie_language3"]);
		update_option('products_in_feed', (int) $_POST["products_in_feed"]);
		update_option('feed_title', (string) $_POST["feed_title"]);
		update_option('podujatie3_what_to_show', (string) $_POST["podujatie3_what_to_show"]);
		update_option('podujatie3_which_first', (string) $_POST["podujatie3_which_first"]);
		update_option('podujatie3_post_sort_order', (string) $_POST["podujatie3_post_sort_order"]);	
		update_option('podujatie3_page_sort_order', (string) $_POST["podujatie3_page_sort_order"]);	
		update_option('podujatie3_comments_on_posts', (bool) $_POST["podujatie3_comments_on_posts"]);
		update_option('podujatie3_comments_on_pages', (bool) $_POST["podujatie3_comments_on_pages"]);
		update_option('podujatie3_show_zero_comments', (bool) $_POST["podujatie3_show_zero_comments"]);	
		update_option('podujatie3_hide_future', (bool) $_POST["podujatie3_hide_future"]);
		update_option('podujatie3_new_window', (bool) $_POST["podujatie3_new_window"]);	
		update_option('podujatie3_show_post_date', (bool) $_POST["podujatie3_show_post_date"]);
		update_option('podujatie3_show_page_date', (bool) $_POST["podujatie3_show_page_date"]);
		update_option('podujatie3_date_format', (string) $_POST["podujatie3_date_format"]);
		update_option('podujatie3_hide_protected', (bool) $_POST["podujatie3_hide_protected"]);
		update_option('product_condition', (string) $_POST["product_condition"]);
		update_option('podujatie3_excluded_pages', (string) $_POST["podujatie3_excluded_pages"]);
		update_option('podujatie3_page_nav', (string) $_POST["podujatie3_page_nav"]);
		update_option('podujatie3_page_nav_where', (string) $_POST["podujatie3_page_nav_where"]);
		update_option('podujatie3_xml_path', (string) $_POST["podujatie3_xml_path"]);
		update_option('product_type', (string) $_POST["product_type"]);
		update_option('product_dph', (string) $_POST["product_dph"]);
		update_option('product_na_sklade', (string) $_POST["product_na_sklade"]);
		update_option('product_out_stock', (string) $_POST["product_out_stock"]);
		update_option('podujatie3_xml_where', (string) $_POST["podujatie3_xml_where"]);	

		echo Nastavenia_upravene;
	    echo '</strong></p></div>';

	} ?><div id="main">
	<div class="wrap"><div class="icon32" id="icon-tools"><br /> </div>
	<h2><?php _e("Woocommerce xml feed pre web heureka od Podujatie.eu - v.", 'podujatie_heureka_free'); ?><?php echo $podujatie3_ver; ?>- <?php _e("Free verzia", 'podujatie_heureka_free'); ?></h2>
	<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
	<input type="hidden" name="info_update" id="info_update" value="true" />
<table width=100% border=0>
<tr><td width=50%  valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="6" class="widefat">
<thead>
   	<tr valign="top">
	<th width="100%" valign="top" align="right" scope="row"><?php _e("Podujatie.eu", 'podujatie_heureka_free'); ?></th>
	</tr>
</thead>
<tr valign="top">
	<th width="100%" valign="top" align="right" scope="row">
<a href="http://www.podujatie.eu/"><img src="<?php bloginfo_rss('wpurl') ?>/wp-content/plugins/heureka-feed/pic/logo-fb.jpg" width="100" height="100" border="0" align="left"></a>
<p><font face="Georgia, Arial, Garamond" size="3"><?php _e("Získajte najnovšiu verziu tohto produktu na tejto stránke ", 'podujatie_heureka_free'); ?>
<a target="_blank" href="http://www.podujatie.eu"><?php _e("Podujatie.eu", 'podujatie_heureka_free'); ?></a></font></p>

<font face="Georgia, Arial, Garamond"><?php _e("Potrebujete pomoc s týmto pluginom? Potrebujete jeho úpravu? Prosím kontaktujte nás na ", 'podujatie_heureka_free'); ?><a href=mailto:office@podujatie.eu>office@podujatie.eu</a>.

	<legend><?php _e("Ahoj, Podujatie.eu sa snaží upravovať pluginy pre použitie na slovenskom webe.<br />
	Tento plugin je Free verzia - zadarmo s obmädzenými možnosťami. Odporúčame ti však objednanie si PRO verzie...<br />
	Plugin je vyvíjaný v spolupráci so spoločnosťou Ing. Igor Kóňa, kde prebehne aj tvoja platba, ak sa rozhodneš aktivovať si Premium verziu. Ďakujeme", 'podujatie_heureka_free'); ?></legend>

<br />
<p> <?php _e("Ak chceš pomoc, vrámci Free verzie tohto programu, ti pomôžeme prostredníctvom dotazníka pomoci alebo na fóre. ", 'podujatie_heureka_free'); ?></font><br><font face="Times New Roman, Arial, Garamond" color="darkred"><b>
<?php _e("Ďalšie šírenie tohto pluginu je ZAKÁZANÉ! Zákon č. 618/2003 Z.z. o autorskom práve a právach súvisiacich s autorským právom (autorský zákon) a Zákon č. 300/2005 Z.z. Trestný zákon, §283 Porušovanie autorského práva.", 'podujatie_heureka_free'); ?>
</b><br><br>
<a href="http://www.facebook.com/PodujatieEu"><img src="<?php bloginfo_rss('wpurl') ?>/wp-content/plugins/heureka-feed/pic/facebook-icon.jpg" align="" width="80" height="80" title="<?php _e("Nezabudni sa stať naším fanúšikom na Facebook-u", 'podujatie_heureka_free'); ?>"></a>
<a href="https://twitter.com/Podujatieeu"><img src="<?php bloginfo_rss('wpurl') ?>/wp-content/plugins/heureka-feed/pic/Twitter_alt_2.jpg" align="" width="80" height="80" title="<?php _e("Nezabudni sa stať naším odberateľom na Twitter-i", 'podujatie_heureka_free'); ?>"></a>
<a href="http://www.linkedin.com/company/podujatie.eu"><img src="<?php bloginfo_rss('wpurl') ?>/wp-content/plugins/heureka-feed/pic/linkedin-icon.jpg" align="" width="80" height="80" title="<?php _e("Nezabudni sa stať naším súpencom na Linked In", 'podujatie_heureka_free'); ?>"></a>
<a href="https://github.com/PodujatieEu"><img src="<?php bloginfo_rss('wpurl') ?>/wp-content/plugins/heureka-feed/pic/github-icon.jpg" align="" width="80" height="80" title="<?php _e("Pre kóderov", 'podujatie_heureka_free'); ?>"></a>
<a href="http://www.podujatie.eu/feed/"><img src="<?php bloginfo_rss('wpurl') ?>/wp-content/plugins/heureka-feed/pic/rss-icon.jpg" align="" width="80" height="80" title="<?php _e("Nezabudni odoberať náš RSS kanál", 'podujatie_heureka_free'); ?>"></a>
</p></font></th></tr></table>
</th><th widht=50%  valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="6" class="widefat">
<thead>
   	<tr valign="top">
	<th width="100%" valign="top" align="right" scope="row"><?php _e(".PRO", 'podujatie_heureka_free'); ?>
	</th></tr>
</thead>
<tr valign="top">
	<th width="100%" valign="top" align="right" scope="row">
<img src="<?php bloginfo_rss('wpurl') ?>/wp-content/plugins/heureka-feed/pic/heureka-free-xml.jpg" align="right" width="161" height="161">
<p><font face="Georgia, Arial, Garamond" size="3"><?php _e("Ďakujeme, že využívaš verziu FREE.", 'podujatie_heureka_free'); ?><br><br>
<img src="<?php bloginfo_rss('wpurl') ?>/wp-content/plugins/heureka-feed/pic/heureka-pro-xml.jpg" align="left" width="81" height="81"><b><?php _e("Výhody, ktoré získaš, ak si aktivuješ premium verziu:", 'podujatie_heureka_free'); ?></b><br>
<ol>
<li><?php _e("vo feede sa ti zobrazí až 99999 produktov", 'podujatie_heureka_free'); ?>
<li><?php _e("vo feede sa zobrazuje link na obrázok produktu", 'podujatie_heureka_free'); ?>
<li><?php _e("nastavenie si výrobcu/dodávateľa/značku produktov", 'podujatie_heureka_free'); ?>
<li><?php _e("nastavenie si dodacích podmienok a všetko ohľadne toho", 'podujatie_heureka_free'); ?>
<li><?php _e("môžeš si určiť maximálnu cenu prekliku na Heuréke", 'podujatie_heureka_free'); ?>
<li><?php _e("mapovanie woocommerce kategórií s Heureka", 'podujatie_heureka_free'); ?>
<li><?php _e("kolónky Ean a Výrobca u produktoch", 'podujatie_heureka_free'); ?>
<li><?php _e("Skrátenú verziu merania konverzií od Heureka", 'podujatie_heureka_free'); ?>
<li><?php _e("Kolónky výrobcu/dodávateľa/značku produktov pri woocommerce produktoch", 'podujatie_heureka_free'); ?>
<li><?php _e("Ean kód pre produkty", 'podujatie_heureka_free'); ?>
<li><?php _e("a mnohé ďalšie možnosti ...", 'podujatie_heureka_free'); ?>
</ol>
</font>
</p>
</th></tr></table>
</th></tr></table>

<div id="icon-options-general" class="icon32"></div><h2><?php _e("Voliteľné nastavenia", 'podujatie_heureka_free'); ?></h2>
	<fieldset class="options">

<table width="100%" border="0" cellspacing="0" cellpadding="6" class="widefat">
<thead>
   	<tr valign="top">
	<th width="45%" valign="top" align="right" scope="row"><?php _e("Čo nastavuješ", 'podujatie_heureka_free'); ?></th><th valign="top">
	<?php _e("Ako nastavíš možnosti", 'podujatie_heureka_free'); ?>
	</th></tr>
</thead>
<tfoot>
   	<tr valign="top">
	<th width="45%" valign="top" align="right" scope="row"><?php _e("Čo nastavuješ", 'podujatie_heureka_free'); ?></th><th valign="top">
	<?php _e("Ako nastavíš možnosti", 'podujatie_heureka_free'); ?>
	</th></tr>
</tfoot>
   	<tr valign="top">

	<th width="45%" valign="top" align="right" scope="row"><?php _e("Titulok xml feed-u", 'podujatie_heureka_free'); ?></th><td valign="top">
	<input name="feed_title" type="text" size="35" value="<?php echo bloginfo_rss('name'); wp_title_rss(); ?>"/><br />
	<?php _e("Prednastavené je", 'podujatie_heureka_free'); ?><strong><?php echo bloginfo_rss('name'); wp_title_rss(); ?></strong>
	</td></tr>

	<tr><th width="45%" valign="top" align="right" scope="row"><?php _e("Popis feed-u", 'podujatie_heureka_free'); ?></th><td valign="top">
	<input name="feed_description" type="text" size="45" value="<?php bloginfo_rss('description') ?>"/><br />
	<?php _e("Prednastavené je", 'podujatie_heureka_free'); ?> <strong><?php bloginfo_rss('description') ?></strong>
	</td></tr>

	<tr><th width="45%" valign="top" align="right" scope="row"><?php _e("Stav produktu", 'podujatie_heureka_free'); ?></th><td valign="top">
	<input name="product_condition" type="radio" value="new" <?php if (get_option('product_condition') == "new") echo "checked='checked'"; ?> />&nbsp;&nbsp;  <?php _e("nové", 'podujatie_heureka_free'); ?>
	<input name="product_condition" type="radio" value="used" <?php if (get_option('product_condition') == "used") echo "checked='checked'"; ?> />&nbsp;&nbsp;  <?php _e("použité", 'podujatie_heureka_free'); ?>
	<input name="product_condition" type="radio" value="refurbished" <?php if (get_option('product_condition') == "refurbished") echo "checked='checked'"; ?>/>&nbsp;&nbsp;	 <?php _e("repasované", 'podujatie_heureka_free'); ?><br />
	<?php _e("Prednastavené je", 'podujatie_heureka_free'); ?><strong><?php _e("nové", 'podujatie_heureka_free'); ?></strong>. <?php _e("Môžeš ale nastaviť na ", 'podujatie_heureka_free'); ?><strong><?php _e("používané", 'podujatie_heureka_free'); ?></strong> <?php _e("alebo", 'podujatie_heureka_free'); ?> <strong><?php _e("repasované", 'podujatie_heureka_free'); ?></strong>.<br /><br />
		</td></tr>

	<tr><th width="45%" valign="top" align="right" scope="row"><?php _e("Na sklade - možnosti", 'podujatie_heureka_free'); ?></th><td valign="top">
	<input name="product_na_sklade" type="radio" value="na sklade" <?php if (get_option('product_na_sklade') == "na sklade") echo "checked='checked'"; ?> />&nbsp;&nbsp; <?php _e("na sklade", 'podujatie_heureka_free'); ?>
	<input name="product_na_sklade" type="radio" value="available for order" <?php if (get_option('product_na_sklade') == "available for order") echo "checked='checked'"; ?> />&nbsp;&nbsp; <?php _e("možné na objednávku", 'podujatie_heureka_free'); ?><br />
		<?php _e("Prednastavené je", 'podujatie_heureka_free'); ?> <strong><?php _e("na sklade", 'podujatie_heureka_free'); ?></strong>. <?php _e("Môžeš tiež nastaviť na", 'podujatie_heureka_free'); ?> <strong><?php _e("možné na objednávku", 'podujatie_heureka_free'); ?></strong>.<br /><br />
		 </td></tr>

	<tr><th width="45%" valign="top" align="right" scope="row"><?php _e("Mimo skladu - možnosti", 'podujatie_heureka_free'); ?></th><td valign="top">
	<input name="product_out_stock" type="radio" value="mimo skladu" <?php if (get_option('product_out_stock') == "mimo skladu") echo "checked='checked'"; ?> />&nbsp;&nbsp; <?php _e("mimo skladu", 'podujatie_heureka_free'); ?>
	<input name="product_out_stock" type="radio" value="preorder" <?php if (get_option('product_out_stock') == "preorder") echo "checked='checked'"; ?> />&nbsp;&nbsp; <?php _e("predobjednávka", 'podujatie_heureka_free'); ?><br />
		<?php _e("Prednastavené je", 'podujatie_heureka_free'); ?> <strong><?php _e("mimo skladu", 'podujatie_heureka_free'); ?></strong>. <?php _e("Môžeš tiež nastaviť na", 'podujatie_heureka_free'); ?> <strong><?php _e("predobjednávka", 'podujatie_heureka_free'); ?></strong>.<br /><br />
	</td></tr>

	<tr></td><th width="45%" valign="top" align="right" scope="row"><?php _e("DPH", 'podujatie_heureka_free'); ?></th><td valign="top">
	<input name="product_dph" type="text" size="25" value="<?php echo get_option('product_dph') ?>"/><br />
	</td></tr>

<tr><th width="45%" valign="top" align="right" scope="row"><?php _e("Typ produktu", 'podujatie_heureka_free'); ?></th><td valign="top">
	    <select name="product_type" id="product_type" style="width: 300px;">
		<?php
		require plugin_dir_path( __FILE__ ) . 'heureka_taxanomy.php';
			$selected = $_POST["product_type"];
			$p = '';
			$r = '';
 
			foreach ( _s_sample_select_options() as $moznost ) {
				$label = $moznost['label'];
				if ( $selected == $moznost['label'] ) // Make default first in list
					$p = "\n\t<option style=\"padding-right: 10px;\" selected='selected' value='" . esc_attr( $moznost['label'] ) . "'>$label</option>";
				else
					$r .= "\n\t<option style=\"padding-right: 10px;\" value='" . esc_attr( $moznost['label'] ) . "'>$label</option>";
			}
			echo $p . $r;
		?></select>
		<br /><?php _e("Výber možností", 'podujatie_heureka_free'); ?>
	</td></tr>

	<br /><br /><br />

	</table>
	</fieldset>

	<div class="submit">
		<input type="submit" name="set_defaults" class="button-secondary" value="<?php _e("Nastaviť na prednastavené", 'podujatie_heureka_free'); ?> &raquo;" />
		<input type="submit" name="info_update" class="button-primary" value="<?php _e("Uložiť nastavenia", 'podujatie_heureka_free'); ?> &raquo;" />
	</div>

	</form>
<hr>
<div id="icon-link-manager" class="icon32"></div>	<h2> <?php _e("Tvoj celkový xml feed môžeš vzhliadnuť tu", 'podujatie_heureka_free'); ?> <a target="_blank" href="<?php bloginfo_rss('wpurl') ?>/feed/heureka/"><?php bloginfo_rss('wpurl') ?>/feed/heureka/</a></h2>
	 <strong><?php _e("Nevidíš svoj xml feed?", 'podujatie_heureka_free'); ?></strong>

<br />
	<li><?php _e("Nemáš povolené permant links - prosím povoliť", 'podujatie_heureka_free'); ?></li>
	<li><?php _e("Nemáš nahodené žiadne produkty", 'podujatie_heureka_free'); ?></li> <br />

	<div id="icon-edit-pages" class="icon32"></div><h2><?php _e("Náhľad (tu je náhľad posledného 1 produktu, je to len orientačné, takto to bude vyzerať)", 'podujatie_heureka_free'); ?></h2><br />

<table width="100%" border="0" cellspacing="0" cellpadding="6" class="widefat">
<thead><tr>
<th><?php _e("ID produktu", 'podujatie_heureka_free'); ?></th>
<th><?php _e("Názov", 'podujatie_heureka_free'); ?></th>
<th><?php _e("Popis", 'podujatie_heureka_free'); ?></th>
<th><?php _e("URL link", 'podujatie_heureka_free'); ?></th>
<th><?php _e("Cena s DPH", 'podujatie_heureka_free'); ?></th>
<th><?php _e("Kategória", 'podujatie_heureka_free'); ?></th>
<th><?php _e("EAN", 'podujatie_heureka_free'); ?></th>
</tr>
</thead>
<tfoot><tr>
<th><?php _e("ID produktu", 'podujatie_heureka_free'); ?></th>
<th><?php _e("Názov", 'podujatie_heureka_free'); ?></th>
<th><?php _e("Popis", 'podujatie_heureka_free'); ?></th>
<th><?php _e("URL link", 'podujatie_heureka_free'); ?></th>
<th><?php _e("Cena s DPH", 'podujatie_heureka_free'); ?></th>
<th><?php _e("Kategória", 'podujatie_heureka_free'); ?></th>
<th><?php _e("EAN", 'podujatie_heureka_free'); ?></th>
</tr>
</tfoot>
<?php
    $args = array( 'post_type' => 'product', 'posts_per_page' => 1 );
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post(); global $product;
?>
	<product>
	<tr>
		<td><ITEM_ID><?php echo $product->get_sku(); ?></ITEM_ID></td>
        <td><PRODUCTNAME><?php the_title_rss() ?></PRODUCTNAME></td>
<td><?php if (get_option('rss_use_excerpt')) : ?>
        <description><![CDATA[<?php the_excerpt_rss() ?>]]></description>
<?php else : ?>
        <description><![CDATA[<?php the_excerpt_rss() ?>]]></description>
<?php endif; ?></td>
		<td><URL><?php the_permalink_rss() ?></URL></td>
		<td><PRICE_VAT><?php echo $product->price ?></PRICE_VAT></td>
		<td><CATEGORYTEXT><?php echo get_option('product_type') ?></CATEGORYTEXT></td>
		<td><EAN><?php echo $product->get_sku(); ?></EAN></td>
<?php rss_enclosure(); ?>
<?php do_action('rss2_item'); ?>
    </tr></product>
<?php endwhile; ?>
</table>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-39354652-1']);
  _gaq.push(['_setDomainName', 'podujatie.eu']);
  _gaq.push(['_setAllowLinker', true]);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</div></div><?php
}
add_action('admin_menu', 'podujatie3_xml_feed2');