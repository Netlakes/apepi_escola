<?php
/**
 * Template Name: Quem Somos (Página Institucional)
 * Description: Template oficial de largura total da Página Quem Somos
 * Author: Netlagos Consulting
 */

get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

  <main id="primary" class="site-main quem-somos-page-main" style="width: 100%; overflow-x: hidden;">
    <?php 
    $raw_content = get_the_content();
    if (!empty(trim($raw_content))) {
        the_content();
    } else {
        echo do_shortcode('[apepi_pagina_quem_somos]');
    }
    ?>
  </main>

<?php endwhile; endif; ?>

<?php
get_footer();
