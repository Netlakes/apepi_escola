<?php
/**
 * Template Name: Elementor Full Width
 * Template Post Type: page, post, curso
 * Description: Modelo de página em largura total otimizado para o Elementor sem margens nem containers fixos.
 *
 * @package APEPI_Escola
 */

get_header();
?>

<main id="primary" class="site-main elementor-full-width-template" style="width: 100%; min-height: 50vh;">
    <?php
    while (have_posts()) :
        the_post();
        the_content();
    endwhile;
    ?>
</main>

<?php
get_footer();
