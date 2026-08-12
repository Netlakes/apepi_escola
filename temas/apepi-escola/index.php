<?php
/**
 * Main Index / Blog Archive Fallback Template
 * Author: Netlagos Consulting
 */

get_header();
?>

<div class="container" style="padding: 5rem 0;">
  <h1 class="font-serif section-main-title" style="margin-bottom: 2rem;">Blog & Artigos Científicos</h1>

  <div class="blog-grid-posts" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article class="formation-card">
        <?php if (has_post_thumbnail()) : ?>
          <div class="card-img-holder">
            <?php the_post_thumbnail('medium'); ?>
          </div>
        <?php endif; ?>
        <div class="card-content">
          <h3><a href="<?php the_permalink(); ?>" style="color: var(--primary); text-decoration: none;"><?php the_title(); ?></a></h3>
          <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
          <a href="<?php the_permalink(); ?>" class="saiba-mais-btn">LER ARTIGO <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </article>
    <?php endwhile; else : ?>
      <p>Nenhum artigo encontrado.</p>
    <?php endif; ?>
  </div>
</div>

<?php
get_footer();
