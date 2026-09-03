<?php
/**
 * Generic & Intelligent Page Template (Elementor + Gutenberg Parity)
 * Author: Netlagos Consulting
 */

get_header();

$is_elementor = false;
if (class_exists('\Elementor\Plugin')) {
    $is_elementor = \Elementor\Plugin::$instance->db->is_built_with_elementor(get_the_ID());
}
?>

<?php if ($is_elementor) : ?>
  <!-- Elementor Built Page: Full Width Rendering -->
  <main id="primary" class="site-main elementor-content-wrapper" style="width: 100%; overflow-x: hidden;">
    <?php
    while (have_posts()) :
        the_post();
        the_content();
    endwhile;
    ?>
  </main>
<?php else : ?>
  <!-- Standard WordPress / Gutenberg / Shortcode Page -->
  <main id="primary" class="site-main default-page-wrapper" style="width: 100%; overflow-x: hidden;">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <?php 
      $raw_content = get_the_content();
      if (
          has_shortcode($raw_content, 'apepi_pagina_fazenda') || 
          has_shortcode($raw_content, 'apepi_pagina_quem_somos') || 
          has_shortcode($raw_content, 'apepi_depoimentos') ||
          strpos($raw_content, 'hero-banner-degrade') !== false ||
          strpos($raw_content, 'faz-hero-banner') !== false ||
          strpos($raw_content, 'qs-exact-hero') !== false
      ) {
          the_content();
      } else {
          ?>
          <div class="container" style="padding: 4rem 1.5rem;">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
              <header class="entry-header" style="margin-bottom: 2.5rem; text-align: center;">
                <h1 class="section-main-title" style="font-size: 2.8rem; color: var(--text-primary);"><?php the_title(); ?></h1>
              </header>
              
              <div class="page-body-content entry-content" style="line-height: 1.8; color: var(--text-secondary); font-size: 1.05rem;">
                <?php the_content(); ?>
              </div>
            </article>
          </div>
          <?php
      }
      ?>
    <?php endwhile; endif; ?>
  </main>
<?php endif; ?>

<?php
get_footer();
