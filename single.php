<?php
/**
 * Single Post Template for Blog Posts
 * Author: Netlagos Consulting
 */

get_header();
?>

<div class="container blog-main-layout" style="padding: 4rem 0;">
  <main class="blog-single-post">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article>
        <span class="section-badge"><?php the_category(', '); ?></span>
        <h1 class="font-serif section-main-title" style="margin-top: 0.5rem; margin-bottom: 1rem;"><?php the_title(); ?></h1>
        <p class="post-meta" style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 2rem;">
          Publicado em <?php echo get_the_date(); ?> por <?php the_author(); ?>
        </p>

        <?php if (has_post_thumbnail()) : ?>
          <div class="post-thumbnail" style="margin-bottom: 2rem; border-radius: var(--radius-md); overflow: hidden;">
            <?php the_post_thumbnail('large', array('style' => 'width:100%; height:auto; display:block;')); ?>
          </div>
        <?php endif; ?>

        <div class="post-body-content" style="line-height: 1.8; color: var(--text-secondary); font-size: 1.05rem;">
          <?php the_content(); ?>
        </div>
      </article>
    <?php endwhile; endif; ?>
  </main>
</div>

<?php
get_footer();
