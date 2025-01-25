<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed">
	<div id="header">
		<div id="masthead">
			<div id="branding" role="banner">
				<a href="/"><img src="wp-content/themes/twentyten/images/pic-title.jpg"></a>
			</div>
            <div class="header-board">
             <p class="desc1"><b>新事業創業促進法について</b><br>
             お気軽にご相談ください。</p>
             <p class="phone"><img src="wp-content/themes/twentyten/images/icon-tel.gif"> 03-5621-7321</p>
             <p class="desc2">9:00～20:00 <span>無料相談、即日対応します！</span><br>
             地下鉄　東西線・大江戸線 <span>門前仲町駅　歩1分</span></p>
             <a href="#"><img src="wp-content/themes/twentyten/images/btn-header-board.gif" alt="アクセス方法・地図はこちら" title=""></a>
            </div>
            <!-- #branding -->

			<div id="access" role="navigation">
            	<ul>
                 	<li><a href="#">トップページ</a></li>
                 	<li><a href="#">事務所概要</a></li>
                 	<li><a href="#" style="font-size:11px;">当事務所のポリシー</a></li>
                 	<li><a href="#">会社設立</a></li>
                 	<li><a href="#">相続・遺言</a></li>
                 	<li><a href="#">青年後見</a></li>
                 	<li><a href="#" class="last-child">料金表</a></li>
                </ul>
			</div><!-- #access -->
		</div><!-- #masthead -->
	</div><!-- #header -->

	<div id="main">
