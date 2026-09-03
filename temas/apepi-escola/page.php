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
  <!-- Standard WordPress / Gutenberg Page -->
  <main id="primary" class="site-main default-page-wrapper">
    <div class="container" style="padding: 4rem 1.5rem;">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <header class="entry-header" style="margin-bottom: 2.5rem; text-align: center;">
            <h1 class="font-serif section-main-title" style="font-size: 2.8rem; color: var(--text-primary);"><?php the_title(); ?></h1>
          </header>
          
          <div class="page-body-content entry-content" style="line-height: 1.8; color: var(--text-secondary); font-size: 1.05rem;">
            <?php the_content(); ?>
          </div>
        </article>
      <?php endwhile; endif; ?>
    </div>
  </main>
<?php endif; ?>

<?php
get_footer();
