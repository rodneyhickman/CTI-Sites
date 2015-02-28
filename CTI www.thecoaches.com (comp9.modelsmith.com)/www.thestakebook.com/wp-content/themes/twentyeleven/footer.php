<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">

			<?php
				/* A sidebar in the footer? Yep. You can can customize
				 * your footer with three columns of widgets.
				 */
				if ( ! is_404() )
					get_sidebar( 'footer' );
			?>

			<div id="site-generator">
				<?php do_action( 'twentyeleven_credits' ); ?>
				<!-- <a href="<?php echo esc_url( __( 'http://wordpress.org/', 'twentyeleven' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'twentyeleven' ); ?>"><?php printf( __( 'Proudly powered by %s', 'twentyeleven' ), 'WordPress' ); ?></a>-->
			</div>

<div style="padding:0 0 10px 10px; font-size:11px">&copy; <?php echo Date('Y')?> by The Coaches Training Institute and Co-Active Press. All rights reserved.
<img style="width:150px;float:left;margin-right:10px;margin-top:10px;" src="http://www.thestakebook.com/wp-content/uploads/2013/07/coactive-press-vertsmall1.jpg" />
<div style="float:left;width:250px;margin-top:10px;">Co-Active Press<br />
4000 Civic Center Drive, Suite 500<br />
San Rafael, CA 94903
</div>
<div style="float:left;width:250px;margin-top:10px;">
Phone: 415-451-6000<br />
Toll Free: 1-800-691-6008<br />
Email: <a href="mailto:CoactivePress@coactive.com">CoactivePress@coactive.com</a>
</div>
<div style="clear:both;"></div>
</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>