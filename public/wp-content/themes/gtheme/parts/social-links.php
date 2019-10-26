<?php
if( function_exists( 'get_field' ) )
{
	$social_icons = get_field( 'theme_options_social_links', 'option' );
}
?>

<ul class="social-links">
	<?php
	if ( !empty( $social_icons ) )
	{ 
		foreach ( $social_icons as $social )
		{
			if ( $social['link'] && $social['title'] )
			{
				?>
				<li>
					<a href="<?php echo esc_attr($social['link']); ?>"
						rel="external noopener nofollow"
						target="_blank"
						title="<?php echo esc_attr($social['title']); ?>">
						<span class="<?php echo esc_attr($social['icon']); ?>"></span>
					</a>
				</li>
				<?php
			}
		}
	}
	?>
</ul>