<?php
/**
 * RSS2 Feed predloha na zobrazenie produktov vo feed-e.
 *
 * @package WordPress
 */

header('Content-Type: application/rss+xml; charset=' . get_option('blog_charset'), true);
$more = 1;
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'; ?>

<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	<?php do_action('rss2_ns'); ?>
>

<channel>
<shop>
    <title><?php bloginfo_rss('name'); wp_title_rss(); ?></title>
    <atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
    <link><?php bloginfo_rss('url') ?></link>
    <description><?php bloginfo_rss('description') ?></description>
    <lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
    <language><?php bloginfo_rss( 'language' ); ?></language>
    <sy:updatePeriod><?php echo apply_filters( 'rss_update_period', 'hourly' ); ?></sy:updatePeriod>
    <sy:updateFrequency><?php echo apply_filters( 'rss_update_frequency', '1' ); ?></sy:updateFrequency>
    <?php do_action('rss2_head'); ?>
    <?php
    $args = array( 'post_type' => 'product', 'posts_per_page' => 999 );
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post(); global $product;
    ?>
    <shopitem>
		<ITEM_ID><?php echo $product->get_sku(); ?></ITEM_ID>
        <PRODUCTNAME><?php the_title_rss() ?></PRODUCTNAME>
<?php if (get_option('rss_use_excerpt')) : ?>
        <description><![CDATA[<?php the_excerpt_rss() ?>]]></description>
<?php else : ?>
        <description><![CDATA[<?php the_excerpt_rss() ?>]]></description>
<?php endif; ?>
		<URL><?php the_permalink_rss() ?></URL>
        <PRICE_VAT><?php echo $product->price ?></PRICE_VAT>
		<CATEGORYTEXT><?php echo get_option('product_type') ?></CATEGORYTEXT>
		<EAN><?php echo $product->get_sku(); ?></EAN>
		<DELIVERY_DATE><?php echo get_option('product_doprava_heureka') ?></DELIVERY_DATE>
	<?php rss_enclosure(); ?>
    <?php do_action('rss2_item'); ?>
    </shopitem>
    <?php endwhile; ?>
</shop>
</channel>
</rss>