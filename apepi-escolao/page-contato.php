<?php
/**
 * Template Name: Contato (APEPI Escola)
 * Description: Template customizado para a página de contato com paridade visual total e customização no WP Admin.
 */

get_header();
?>

<main id="primary" class="site-main page-contato-main">
    <?php
    if (shortcode_exists('apepi_breadcrumbs')) {
        echo do_shortcode('[apepi_breadcrumbs]');
    }

    if (shortcode_exists('apepi_pagina_contato')) {
        echo do_shortcode('[apepi_pagina_contato]');
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
