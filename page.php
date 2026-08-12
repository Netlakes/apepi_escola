<?php
/**
 * Generic Page Template
 * Author: Netlagos Consulting
 */

get_header();
?>

<div class="container" style="padding: 5rem 0;">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article>
      <h1 class="font-serif section-main-title" style="margin-bottom: 2rem;"><?php the_title(); ?></h1>
      <div class="page-body-content" style="line-height: 1.8; color: var(--text-secondary); font-size: 1.05rem;">
        <?php the_content(); ?>
      </div>
    </article>
  <?php endwhile; endif; ?>
</div>

<?php
get_footer();
