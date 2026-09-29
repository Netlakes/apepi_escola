<?php
/**
 * Main Template File
 * Author: Netlagos Consulting
 */

get_header();
?>

<div class="container" style="padding: 4rem 1.5rem;">
  <?php
  if (have_posts()) :
    while (have_posts()) : the_post();
      echo '<h1 class="section-main-title" style="margin-bottom: 1.5rem;">' . get_the_title() . '</h1>';
      echo '<div class="page-body-content" style="line-height: 1.8;">';
      the_content();
      echo '</div>';
    endwhile;
  else :
    echo '<p>Nenhum conteúdo encontrado.</p>';
  endif;
  ?>
</div>

<?php
get_footer();
