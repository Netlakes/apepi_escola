<?php
/**
 * Template Name: Nossos Cursos (APEPI Escola)
 * Description: Template customizado para a página de apresentação do catálogo de cursos da APEPI Escola.
 */

get_header();
?>

<main id="primary" class="site-main page-nossos-cursos-main">
    <?php
    if (shortcode_exists('apepi_breadcrumbs')) {
        echo do_shortcode('[apepi_breadcrumbs]');
    }

    if (shortcode_exists('apepi_pagina_nossos_cursos')) {
        echo do_shortcode('[apepi_pagina_nossos_cursos]');
    } else {
        while (have_posts()) :
            the_post();
            the_content();
        endwhile;
    }
    ?>
</main>

<?php
get_footer();
