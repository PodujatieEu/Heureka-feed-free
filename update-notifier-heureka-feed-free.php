<?php
/**************************************************************
 *                                                            *
 *		UPDATE od Podujatie.eu a Ing. Igor Kóňa			      *
 *                                                            *
 **************************************************************/
 
/*
	Replace HEUREKA_FEED_FREE_A and heureka_feed_free by your plugin prefix to prevent conflicts between plugins using this script.
*/

// Constants for the plugin name, folder and remote XML url
define( 'HEUREKA_FEED_FREE_PLUGIN_NAME', 'XML FEED heureka' ); // The plugin name
define( 'HEUREKA_FEED_FREE_PLUGIN_SHORT_NAME', 'POEU-HF' ); // The plugin short name, only if needed to make the menu item fit. Remove this if not needed
define( 'HEUREKA_FEED_FREE_PLUGIN_FOLDER_NAME', 'heureka-feed' ); // The plugin folder name
define( 'HEUREKA_FEED_FREE_PLUGIN_FILE_NAME', 'feed.php' ); // The plugin file name
define( 'HEUREKA_FEED_FREE_PLUGIN_XML_FILE', 'http://podujatie.eu/UPDATES/heureka-feed/heureka-feed-free.xml' ); // The remote notifier XML file containing the latest version of the plugin and changelog
define( 'HEUREKA_FEED_FREE_A_PLUGIN_NOTIFIER_CACHE_INTERVAL', 30 ); // The time interval for the remote XML cache in the database (21600 seconds = 6 hours)
define( 'HEUREKA_FEED_FREE_A_PLUGIN_NOTIFIER_CODECANYON_USERNAME', 'produkt/heureka-xml-feed-free/' ); // Your Codecanyon username


// Adds an update notification to the WordPress Dashboard menu
function heureka_feed_free_update_plugin_notifier_menu() {  
	if (function_exists('simplexml_load_string')) { // Stop if simplexml_load_string funtion isn't available
	    $xml_heureka_feed_free 			= heureka_feed_free_get_latest_plugin_version(HEUREKA_FEED_FREE_A_PLUGIN_NOTIFIER_CACHE_INTERVAL); // Get the latest remote XML file on our server
		$plugin_data_heureka_feed_free 	= get_plugin_data(WP_PLUGIN_DIR . '/' . HEUREKA_FEED_FREE_PLUGIN_FOLDER_NAME . '/' . HEUREKA_FEED_FREE_PLUGIN_FILE_NAME); // Read plugin current version from the style.css

		if( (string)$xml_heureka_feed_free->latest > (string)$plugin_data_heureka_feed_free['Version']) { // Compare current plugin version with the remote XML version
			if(defined('HEUREKA_FEED_FREE_PLUGIN_SHORT_NAME')) {
				$menu_name = HEUREKA_FEED_FREE_PLUGIN_SHORT_NAME;
			} else {
				$menu_name = HEUREKA_FEED_FREE_PLUGIN_NAME;
			}
			add_dashboard_page( HEUREKA_FEED_FREE_PLUGIN_NAME . ' Plugin Updates', $menu_name . ' <span class="update-plugins count-1"><span class="update-count">Vynovenie</span></span>', 'administrator', 'heureka_feed_free-plugin-update-notifier', 'heureka_feed_free_update_notifier');
		}
	}	
}
add_action('admin_menu', 'heureka_feed_free_update_plugin_notifier_menu');  



// Adds an update notification to the WordPress 3.1+ Admin Bar
function heureka_feed_free_update_notifier_bar_menu() {
	if (function_exists('simplexml_load_string')) { // Stop if simplexml_load_string funtion isn't available
		global $wp_admin_bar, $wpdb;

		if ( !is_super_admin() || !is_admin_bar_showing() || !is_admin() ) // Don't display notification in admin bar if it's disabled or the current user isn't an administrator
		return;

		$xml_heureka_feed_free 		= heureka_feed_free_get_latest_plugin_version(HEUREKA_FEED_FREE_A_PLUGIN_NOTIFIER_CACHE_INTERVAL); // Get the latest remote XML file on our server
		$plugin_data_heureka_feed_free 	= get_plugin_data(WP_PLUGIN_DIR . '/' . HEUREKA_FEED_FREE_PLUGIN_FOLDER_NAME . '/' .HEUREKA_FEED_FREE_PLUGIN_FILE_NAME); // Read plugin current version from the main plugin file

		if( (string)$xml_heureka_feed_free->latest > (string)$plugin_data_heureka_feed_free['Version']) { // Compare current plugin version with the remote XML version
			$wp_admin_bar->add_menu( array( 'id' => 'plugin_update_notifier', 'title' => '<span>' . HEUREKA_FEED_FREE_PLUGIN_NAME . ' <span id="ab-updates">Vynovenie</span></span>', 'href' => get_admin_url() . 'index.php?page=heureka_feed_free-plugin-update-notifier' ) );
		}
	}
}
add_action( 'admin_bar_menu', 'heureka_feed_free_update_notifier_bar_menu', 1000 );



// The notifier page
function heureka_feed_free_update_notifier() { 
	$xml_heureka_feed_free 			= heureka_feed_free_get_latest_plugin_version(HEUREKA_FEED_FREE_A_PLUGIN_NOTIFIER_CACHE_INTERVAL); // Get the latest remote XML file on our server
	$plugin_data_heureka_feed_free 	= get_plugin_data(WP_PLUGIN_DIR . '/' . HEUREKA_FEED_FREE_PLUGIN_FOLDER_NAME . '/' .HEUREKA_FEED_FREE_PLUGIN_FILE_NAME); // Read plugin current version from the main plugin file ?>

	<style>
		.update-nag { display: none; }
		#instructions {max-width: 670px;}
		h3.title {margin: 30px 0 0 0; padding: 30px 0 0 0; border-top: 1px solid #ddd;}
	</style>

	<div class="wrap">

		<div id="icon-tools" class="icon32"></div>
		<h2><?php echo HEUREKA_FEED_FREE_PLUGIN_NAME ?> Nová verzia</h2>
	    <div id="message" class="updated below-h2"><p><strong>K dispozícii je nová verzia pluginu <?php echo HEUREKA_FEED_FREE_PLUGIN_NAME; ?> na stiahnutie</strong> Nainštalovanú máte verziu <?php echo $plugin_data_heureka_feed_free['Version']; ?> . Vynovte na verziu <?php echo $xml_heureka_feed_free->latest; ?>.</p></div>
		
		<div id="instructions">
		    <h3>Stiahnite si update a inštrukcie</h3>
		    <p><strong>Prosím berte na vedomie:</strong> spravte <strong>zálohu</strong> pluginu a Wordpress inštalácie, no najmä <strong>/wp-content/plugins/<?php echo HEUREKA_FEED_FREE_PLUGIN_FOLDER_NAME; ?>/</strong> pred každou novou inštaláciou.</p>
		    <p><img src="<?php bloginfo_rss('wpurl') ?>/wp-content/plugins/heureka-feed/pic/heureka-free-xml.jpg" align="left" width="161" height="161">Pre získanie novej verzie sa prosím prihláste na <a href="http://www.podujatie.eu/<?php echo HEUREKA_FEED_FREE_A_PLUGIN_NOTIFIER_CODECANYON_USERNAME; ?>">Podujatie.eu</a>, a v menu choďte na <strong>Môj účet</strong> a pod zakúpeným pluginom (podľa objednávky) si znova stiahnite tento plugin.</p>
		    <p>Znovustiahnutý súbor v počítači rozbaľte a prostredníctvom FTP klienta nahrajte nahrajte do súboru <strong>/wp-content/plugins/<?php echo HEUREKA_FEED_FREE_PLUGIN_FOLDER_NAME; ?>/</strong> ktorý nájdete vo svojom Wordpress. Prosím dbajte na to, aby ste prepísali všetky súbory. Odporúčame však staré súbory vymazať a nahrať novostiahnuté.</p>
		    <p>Ak ste nerobili manuálne zmeny vnútri súboru pluginu, nemusíte sa obávať nahrať nové súbory. Nastavenia a zmeny spravené prostredníctvom Woocommerce a Wordpress sa automaticky ukladajú do databázy, s ktorou update nič nerobí. V opačnom prípade je potrebné postupovať inak.</p>
		</div>
	    
	    <h3 class="title">Verzie a vývoj pluginu</h3>
	    <?php echo $xml_heureka_feed_free->changelog; ?>

	</div>
    
<?php }



// Get the remote XML file contents and return its data (Version and Changelog)
// Uses the cached version if available and inside the time interval defined
function heureka_feed_free_get_latest_plugin_version($interval) {
	$notifier_file_url = HEUREKA_FEED_FREE_PLUGIN_XML_FILE;	
	$db_cache_field = 'heureka-feed-free-notifier-cache';
	$db_cache_field_last_updated = 'heureka-feed-free-notifier-cache-last-updated';
	$last = get_option( $db_cache_field_last_updated );
	$now = time();
	// check the cache
	if ( !$last || (( $now - $last ) > $interval) ) {
		// cache doesn't exist, or is old, so refresh it
		if( function_exists('curl_init') ) { // if cURL is available, use it...
			$ch = curl_init($notifier_file_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			$cache = curl_exec($ch);
			curl_close($ch);
		} else {
			$cache = file_get_contents($notifier_file_url); // ...if not, use the common file_get_contents()
		}

		if ($cache) {			
			// we got good results	
			update_option( $db_cache_field, $cache );
			update_option( $db_cache_field_last_updated, time() );
		} 
		// read from the cache file
		$notifier_data = get_option( $db_cache_field );
	}
	else {
		// cache file is fresh enough, so read from it
		$notifier_data = get_option( $db_cache_field );
	}

	// Let's see if the $xml_heureka_feed_free data was returned as we expected it to.
	// If it didn't, use the default 1.0 as the latest version so that we don't have problems when the remote server hosting the XML file is down
	if( strpos((string)$notifier_data, '<notifier>') === false ) {
		$notifier_data = '<?xml version="1.0" encoding="UTF-8"?><notifier><latest>1.0</latest><changelog></changelog></notifier>';
	}

	// Load the remote XML data into a variable and return it
	$xml_heureka_feed_free = simplexml_load_string($notifier_data); 

	return $xml_heureka_feed_free;
}

?>