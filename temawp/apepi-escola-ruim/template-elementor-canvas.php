<?php
/**
 * Template Name: Elementor Canvas
 * Template Post Type: page, post, curso
 * Description: Modelo em tela totalmente em branco sem cabeçalho e rodapé, controlado 100% pelo Elementor.
 *
 * @package APEPI_Escola
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('elementor-template-canvas'); ?>>
    <?php wp_body_open(); ?>

    <main id="primary" class="site-main elementor-canvas-content">
        <?php
        while (have_posts()) :
            the_post();
            the_content();
        endwhile;
        ?>
    </main>

    <?php wp_footer(); ?>
</body>
</html>
