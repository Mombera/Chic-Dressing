<?php

get_header();

if ( is_home() ) {

	// Featured Slider, Carousel
	if ( ashe_options( 'featured_slider_label' ) === true && ashe_options( 'featured_slider_location' ) !== 'front' ) {
		if ( ashe_options( 'featured_slider_source' ) === 'posts' ) {
			get_template_part( 'templates/header/featured', 'slider-custom' );
		} else {
			get_template_part( 'templates/header/featured', 'slider' );
		}
	}

	// Featured Links, Banners
	if ( ashe_options( 'featured_links_label' ) === true && ashe_options( 'featured_links_location' ) !== 'front' ) {
		get_template_part( 'templates/header/featured', 'links' );
	}

	// On ajoute les derniers produits
	?>
	<div id="chic-products"  class="boxed-wrapper clear-fix">
		<h1 class="chic-title">Dernières pièces </h1>
		<?php
		echo do_shortcode('[products orderby="date" columns="3" order="ASC"]');
		?>
		<p class="text-center"><a class="chic-bouton" href="/shop">Voir toute la collection</a></p>
	</div>
	<!-- on inclut la Google Maps de la Fashion Week -->
	<div id="chic-fashionweek-map" class="boxed-wrapper clear-fix" style="margin-top:30px">
    <h1 class="chic-title">La FashionMap - été 2022 </h1>

    <!-- Bouton pour charger la carte -->
	<div class="button-container">
    	<button class="read-more" onclick="loadMap()">Charger la carte</button>
	</div>

    <!-- Div pour l'iframe, cachée au départ -->
    <div id="map-container" style="display:none;">
        <iframe id="fashion-map" src="" width="100%" height="480" style="border:0;"></iframe>
    </div>
</div>

<script>
    function loadMap() {
        // Définir l'URL de l'iframe avec le lien de la carte
        var mapUrl = "https://www.google.com/maps/d/embed?mid=1SU-W19k76UkTXASeT7PnGAyDYCY&hl=en_US&ehbc=2E312F";

        // Affecter l'URL à l'iframe
        document.getElementById('fashion-map').src = mapUrl;

        // Afficher la div contenant l'iframe
        document.getElementById('map-container').style.display = 'block';
    }
</script>

	<?php

}

?>

<div class="main-content clear-fix<?php echo esc_attr(ashe_options( 'general_content_width' )) === 'boxed' ? ' boxed-wrapper': ''; ?>" data-layout="<?php echo esc_attr( ashe_options( 'general_home_layout' ) ); ?>" data-sidebar-sticky="<?php echo esc_attr( ashe_options( 'general_sidebar_sticky' ) ); ?>">

	<?php

	// Sidebar Left
	get_template_part( 'templates/sidebars/sidebar', 'left' );

	// Blog Feed Wrapper

	if ( strpos( ashe_options( 'general_home_layout' ), 'list' ) === 0 ) {
		get_template_part( 'templates/grid/blog', 'list' );
	} else {
		get_template_part( 'templates/grid/blog', 'grid' );
	}

	// Sidebar Right
	get_template_part( 'templates/sidebars/sidebar', 'right' );

	?>

</div>

<?php get_footer(); ?>
