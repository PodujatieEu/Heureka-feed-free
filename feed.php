<?php
/* 
Plugin Name: XML FEED heureka (PODUJATIE.EU)
Plugin URI: http://www.podujatie.eu/
Version: 2.00
Author: Podujatie.eu, Ing. Igor Kona
License: SW sa nesmie ďalej predávať, ani akokoľvek šíriť bez vedomia a dohody s autorom. SW licencia je platná na všetky weby v rámci jednej domény jedného kupujúceho. Autor nenesie zodpovednosť pokiaľ SW akokoľvek poškodí dáta, alebo spôsobí škodu. Kúpou a platbou súhlasíte s týmto licenčným dojednaním. Autor si ďalej vyhradzuje právo úpravy tohto licenčného dojednania. Platba je jednorazová a sú v nej zahrnuté prípadné aktualizácie a pomoc pri štandardnej inštalácii. 
Description: Generuje xml feed pre heureka od woocommerce produktov. Vytvoril Podujatie.eu. !! Nastavenia -> XML Feed Heureka !!
*/
/*  Copyright 2013  Podujatie.eu  (email : office@podujatie.eu)

SW sa nesmie ďalej predávať, ani akokoľvek šíriť bez vedomia a dohody s autorom. SW licencia je platná na všetky weby v rámci jednej domény jedného kupujúceho. Autor nenesie zodpovednosť pokiaľ SW akokoľvek poškodí dáta, alebo spôsobí škodu. Kúpou a platbou súhlasíte s týmto licenčným dojednaním. Autor si ďalej vyhradzuje právo úpravy tohto licenčného dojednania. Platba je jednorazová a sú v nej zahrnuté prípadné aktualizácie a pomoc pri štandardnej inštalácii. Zasahovanie do kódu pluginu, jeho časti či akákoľvek úprava je zakázaná. V opačnom prípade autor nenesia žiadnu zodpovednosť a taktiež povinnosť na akejkoľvek náprave.

Ďalšie šírenie tohto pluginu je ZAKÁZANÉ! Zákon č. 618/2003 Z.z. o autorskom práve a právach súvisiacich s autorským právom (autorský zákon) a Zákon č. 300/2005 Z.z. Trestný zákon, §283 Porušovanie autorského práva.

Ing. Igor Kona; IČO: 43729444; DIČ: 1078646503IČ; DPH: SK1078646503; platobné údaje na stránke Podujatie.eu.
*/

if (!isset($wpdb)) $wpdb = $GLOBALS['wpdb'];

//Define the product feed php page
function podujatie3_feed_rss3() {
 $rss_template = dirname(__FILE__) . '/product-feed.php';
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
}

//add the rewrite rule
function moje_pridanie_produkt_heureka( ) {
 global $wp_rewrite;
 add_action('generate_rewrite_rules', 'moje_prepisanie_produktov_pravidlo3');
 $wp_rewrite->flush_rules();
}


$podujatie3_ver = '2.00';

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
		add_options_page('XML Feed heureka', 'XML Feed heureka', 8, __FILE__, 'podujatie3_options_page');
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

		echo podujatie3_DEFAULTS_LOADED;
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

		echo podujatie3_CONFIG_UPDATED;
	    echo '</strong></p></div>';
	} ?>

	<div class="wrap">

	<h2>Woocommerce xml feed pre web heureka od Podujatie.eu - v. <?php echo $podujatie3_ver; ?> - Free verzia</h2>

	<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
	<input type="hidden" name="info_update" id="info_update" value="true" />
<table width=100% border=0>
<tr><td width=50%  valign="top">
<center><a href="http://www.podujatie.eu/"><img src="<?php bloginfo_rss('wpurl') ?>/wp-content/plugins/heureka-feed/web-logo3.jpg" width="300" height="100" border="0"></a></center>
<p><font face="Georgia, Arial, Garamond" size="3">Získajte najnovšiu verziu tohto produktu na tejto stránke 
<a target="_blank" href="http://www.podujatie.eu">Podujatie.eu</a></font></p>

<font face="Georgia, Arial, Garamond">Potrebujete pomoc s týmto pluginom? Potrebujete jeho úpravu? Prosím kontaktujte nás na <a href=mailto:office@podujatie.eu>office@podujatie.eu</a>.

	<legend>Ahoj, Podujatie.eu sa snaží upravovať pluginy pre použitie na slovenskom webe.<br />
	Tento plugin je Free verzia - zadarmo s obmädzenými možnosťami. Odporúčame ti však objednanie si PRO verzie...<br />
	Plugin je vyvíjaný v spolupráci so spoločnosťou Ing. Igor Kóňa, kde prebehne aj tvoja platba, ak sa rozhodneš aktivovať si Premium verziu. Ďakujeme</legend>

<br />
<p> Ak chceš pomoc, vrámi Free verzie tohto programu, ti pomôžeme prostredníctvom dotazníka pomoci alebo na fóre. </font><font face="Times New Roman, Arial, Garamond" color="darkred"><b>
Ďalšie šírenie tohto pluginu je ZAKÁZANÉ! Zákon č. 618/2003 Z.z. o autorskom práve a právach súvisiacich s autorským právom (autorský zákon) a Zákon č. 300/2005 Z.z. Trestný zákon, §283 Porušovanie autorského práva.
</b></p></font>
</td><td widht=50%  valign="top">
<img src="<?php bloginfo_rss('wpurl') ?>/wp-content/plugins/heureka-feed/heureka-free-small.jpg" align="right" width="105" height="160">
<p><font face="Georgia, Arial, Garamond" size="3">Ďakujeme, že využívaš verziu FREE.<br>
<img src="<?php bloginfo_rss('wpurl') ?>/wp-content/plugins/heureka-feed/heureka-premium-small.jpg" align="left" width="105" height="160">Výhody, ktoré získaš, ak si aktivuješ premium verziu:<br>
<ol>
<li>vo feed sa ti zobrazí až 999 produktov
<li>vo feede sa zobrazuje link na obrázok produktu
<li>nastavenie si výrobcu/dodávateľa/značku produktov
<li>nastavenie si dodacích podmienok a všetko ohľadne toho
<li>môžeš si určiť maximálnu cenu prekliku na Heuréke
<li>a mnohé ďalšie možnosti ...
</ol>
</font>
<br><br>
Nezabudni sa stať naším fanúšikom na </font><font face="Georgia, Arial, Garamond" size="3" color="3B5998"><b>
<a href="http://www.facebook.com/PodujatieEu">Facebook-u Podujatie.eu</a></font></b></p>
</td></tr></table>

	<fieldset class="options">

	<table width="100%" border="0" cellspacing="0" cellpadding="6">

   	<tr valign="top">

	<th width="45%" valign="top" align="right" scope="row">Titulok xml feed-u</th><td valign="top">
	<input name="feed_title" type="text" size="35" value="<?php echo bloginfo_rss('name'); wp_title_rss(); ?>"/><br />
	Prednastavené je<strong><?php echo bloginfo_rss('name'); wp_title_rss(); ?></strong>
	</td></tr>

	<tr><th width="45%" valign="top" align="right" scope="row">Popis feed-u</th><td valign="top">
	<input name="feed_description" type="text" size="45" value="<?php bloginfo_rss('description') ?>"/><br />
	Prednastavené je<strong><?php bloginfo_rss('description') ?></strong>
	</td></tr>

	<tr><th width="45%" valign="top" align="right" scope="row">Stav produktu</th><td valign="top">
	<input name="product_condition" type="radio" value="new" <?php if (get_option('product_condition') == "new") echo "checked='checked'"; ?> />&nbsp;&nbsp; new
	<input name="product_condition" type="radio" value="used" <?php if (get_option('product_condition') == "used") echo "checked='checked'"; ?> />&nbsp;&nbsp; used
	<input name="product_condition" type="radio" value="refurbished" <?php if (get_option('product_condition') == "refurbished") echo "checked='checked'"; ?>/>&nbsp;&nbsp;	refurbished<br />
	Prednastavené je<strong>nové</strong>. Môžeš ale nastaviť na <strong>používané</strong> alebo <strong>repasované</strong>.<br /><br />
		</td></tr>

	<tr><th width="45%" valign="top" align="right" scope="row">Na sklade - možnosti</th><td valign="top">
	<input name="product_na_sklade" type="radio" value="na sklade" <?php if (get_option('product_na_sklade') == "na sklade") echo "checked='checked'"; ?> />&nbsp;&nbsp; na sklade
	<input name="product_na_sklade" type="radio" value="available for order" <?php if (get_option('product_na_sklade') == "available for order") echo "checked='checked'"; ?> />&nbsp;&nbsp; možné na objednávku<br />
		Prednastavené je<strong>na sklade</strong>. Môžeš tiež nastaviť na <strong>možné na objednávku</strong>.<br /><br />
		 </td></tr>

	<tr><th width="45%" valign="top" align="right" scope="row">Mimo skladu - možnosti</th><td valign="top">
	<input name="product_out_stock" type="radio" value="mimo skladu" <?php if (get_option('product_out_stock') == "mimo skladu") echo "checked='checked'"; ?> />&nbsp;&nbsp; mimo skladu
	<input name="product_out_stock" type="radio" value="preorder" <?php if (get_option('product_out_stock') == "preorder") echo "checked='checked'"; ?> />&nbsp;&nbsp; predobjednávka<br />
		Prednastavené je<strong>mimo skladu</strong>. Môžeš tiež nastaviť na <strong>predobjednávka</strong>.<br /><br />
	</td></tr>

	<tr></td><th width="45%" valign="top" align="right" scope="row">DPH</th><td valign="top">
	<input name="product_dph" type="text" size="25" value="<?php echo get_option('product_dph') ?>"/><br />
	</td></tr>

<tr><th width="45%" valign="top" align="right" scope="row">Typ produktu</th><td valign="top">
	<input name="product_type" type="text" size="75" value="<?php echo get_option('product_type') ?>"/><br />
	Prednastavené je<strong>Software &amp;gt; Wordpress &amp;gt; Plugin</strong><br />
	Atribúty produktu môžeš nastaviť aj podľa taxanómie Google merchant. Prosím zadaj pre vyhladávanie a plugin ti pomôže. Nie je to však potrebné zadávať znova (už raz si to zadal/a)<br />
	<br />Vždy použi  <code>&amp;amp;</code>  <code>&amp;gt;</code>  nie & alebo >
	</td></tr>

	<br /><br /><br /><br />

	</table>
	</fieldset>

	<div class="submit">
		<input type="submit" name="set_defaults" value="Nastaviť na prednastavené &raquo;" />
		<input type="submit" name="info_update" value="Uložiť nastavenia &raquo;" />
	</div>

	</form>

	<h2> Tvoj celkový xml feed môžeš vzhliadnuť tu <a target="_blank" href="<?php bloginfo_rss('wpurl') ?>/feed/heureka/"><?php bloginfo_rss('wpurl') ?>/feed/heureka/</a></h2>
	 <strong>Nevidíš svoj xml feed?</strong>

<br />
	<li>Nemáš povolené permant links - prosím povoliť</li>
	<li>Nemáš nahodené žiadne produkty</li> <br />

	<h2>Náhľad (tu je náhľad posledného 1 produktu, je to len orientačné, takto to bude vyzerať)</h2><br />

<table width="100%" border="0" cellspacing="0" cellpadding="6">
<tr>
<th>ID produktu</th>
<th>Názov</th>
<th>Popis</th>
<th>URL link</th>
<th>Cena s DPH</th>
<th>Kategória</th>
<th>EAN</th>
</tr>
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

	</div><?php
}
add_action('admin_menu', 'podujatie3_xml_feed2');