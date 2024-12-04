<?php 

add_action( 'wp_enqueue_scripts', 'chicdressing_enqueue_styles' );
function chicdressing_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' ); 
}

add_filter( 'big_image_size_threshold', '__return_false' );




function generate_webp_image($image_path) {
    // Vérifie l'extension de l'image
    $image_info = pathinfo($image_path);
    $extension = strtolower($image_info['extension']);
    
    // Vérifie si le fichier est une image JPG ou PNG
    if ($extension == 'jpg' || $extension == 'jpeg') {
        $image = imagecreatefromjpeg($image_path); // Crée une image à partir d'un fichier JPEG
    } elseif ($extension == 'png') {
        $image = imagecreatefrompng($image_path); // Crée une image à partir d'un fichier PNG
    } else {
        return false; // Si ce n'est ni JPG ni PNG, retourne false
    }

    // Crée une version WebP et enregistre-la
    $webp_image_path = preg_replace('/\.(jpg|jpeg|png)$/', '.webp', $image_path);
    imagewebp($image, $webp_image_path, 80); // La qualité de 80 peut être ajustée

    // Libère la mémoire de l'image
    imagedestroy($image);

    return $webp_image_path; // Retourne le chemin de l'image WebP générée
}

// Fonction pour générer le CSS dynamique dans le thème enfant
function ashe_dynamic_css_child() {
    // Exemple d'URL d'image d'en-tête au format .webp
    $header_image = get_header_image();

    // Modifier l'URL pour utiliser le format .webp si une image est définie
    if ($header_image) {
        $background_image = preg_replace('/\.[^\.]+$/', '.webp', $header_image);
        // Image de remplacement si aucune image d'en-tête n'est définie
        $mobile_image = preg_replace('/\.[^\.]+$/', '-500x330.jpg.webp', $header_image);  // Image pour téléphone (300x200)
    } else {
        $background_image = get_template_directory_uri() . '/images/default-image.webp'; // Image de remplacement par défaut
        $mobile_image = get_template_directory_uri() . '/images/default-image-300x200.webp'; // Image de remplacement par défaut pour téléphone
    }

    // Générer le CSS dynamique pour l'en-tête
    $css = "
        .entry-header {
            height: 500px;
            background-image: url('{$background_image}');
            background-size: " . esc_html(ashe_options('header_image_bg_image_size')) . ";
        }

        /* CSS pour mobile */
        @media only screen and (max-width: 767px) {
            .entry-header {
                background-image: url('{$mobile_image}');
                background-size: cover; /* Ajuster selon le besoin */
            }
        }
    ";

    // Injecter le CSS dynamique dans le <head> de la page avec un ID unique
    echo '<style id="ashe_dynamic_css_child">' . $css . '</style>';
}
