<?php
/**
 * Template Name: Fazenda de Cannabis (Página Detalhada)
 * Author: Netlagos Consulting
 */

get_header();

$hero_img = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : 'https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?auto=format&fit=crop&w=1200&q=80';
$wa_num   = apepi_get_option('apepi_whatsapp_number', '5521979570000');
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

  <div class="fazenda-template-container" style="padding: 2rem 0; background: var(--bg-primary);">
    <div class="container">
      <?php 
      $raw_content = get_the_content();
      if (!empty(trim($raw_content))) {
          the_content();
      } else {
          echo do_shortcode('[apepi_pagina_fazenda]');
      }
      ?>
    </div>
  </div>

<?php endwhile; endif; ?>

<?php
get_footer();
