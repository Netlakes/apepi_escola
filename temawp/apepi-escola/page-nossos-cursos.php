<?php
/**
 * Template Name: Nossos Cursos — Catálogo Completo
 * Description: Página de catálogo de cursos da APEPI Escola com carrossel de formações, números de impacto, depoimentos e banner de e-books.
 */

if (!defined('ABSPATH')) exit;

get_header();
?>
<main id="main-content" class="site-main">
    <?php echo do_shortcode('[apepi_pagina_nossos_cursos]'); ?>
</main>
<?php
get_footer();
