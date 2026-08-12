  <!-- Site Footer -->
  <footer class="site-footer">
    <div class="container footer-content">
      <div class="footer-left">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="brand-logo">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/logo_apepi_escola.png" alt="<?php bloginfo('name'); ?>" class="footer-logo-img logo-light">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/logo_apepi_escola_dark.png" alt="<?php bloginfo('name'); ?>" class="footer-logo-img logo-dark">
        </a>
        <p class="footer-tagline">
          A principal Escola Brasileira de Cannabis Medicinal. Formação científica, prática clínica e acompanhamento com excelência.
        </p>
        <a href="https://wa.me/5521979570000" target="_blank" class="footer-whatsapp-badge">
          <i class="fa-brands fa-whatsapp"></i> Atendimento via WhatsApp
        </a>
      </div>

      <div class="footer-center">
        <h3>LINKS RÁPIDOS</h3>
        <?php
        if (has_nav_menu('footer')) {
          wp_nav_menu(array(
            'theme_location' => 'footer',
            'container'      => false,
            'menu_class'     => 'footer-links-grid',
            'fallback_cb'    => false,
          ));
        } else {
          ?>
          <ul class="footer-links-grid">
            <li><a href="<?php echo esc_url(home_url('/#cursos')); ?>"><i class="fa-solid fa-chevron-right"></i> Cursos</a></li>
            <li><a href="<?php echo esc_url(home_url('/#cursos')); ?>"><i class="fa-solid fa-chevron-right"></i> Mentorias</a></li>
            <li><a href="<?php echo esc_url(home_url('/quem-somos')); ?>"><i class="fa-solid fa-chevron-right"></i> Professores</a></li>
            <li><a href="<?php echo esc_url(home_url('/fazenda')); ?>"><i class="fa-solid fa-chevron-right"></i> Fazenda de Cannabis</a></li>
            <li><a href="<?php echo esc_url(home_url('/quem-somos')); ?>"><i class="fa-solid fa-chevron-right"></i> Pesquisa</a></li>
            <li><a href="<?php echo esc_url(home_url('/#contato')); ?>"><i class="fa-solid fa-chevron-right"></i> Área do Aluno</a></li>
          </ul>
          <?php
        }
        ?>
      </div>

      <div class="footer-right">
        <h3>CONTATO</h3>
        <div class="footer-right-list">
          <p><i class="fa-regular fa-envelope"></i> contato@apepi.com.br</p>
          <p><i class="fa-solid fa-phone"></i> (21) 97957-0000</p>
          <p><i class="fa-solid fa-location-dot"></i> Rio de Janeiro - RJ</p>
        </div>

        <div class="footer-socials">
          <a href="#" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
          <a href="#" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
          <a href="#" title="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="container">
        <span>&copy; <?php echo date('Y'); ?> APEPI Escola - Desenvolvido por <strong style="color: var(--primary-hover);">Netlagos Consulting</strong></span>
        <div class="footer-bottom-links">
          <a href="<?php echo esc_url(home_url('/')); ?>">Início</a>
          <a href="<?php echo esc_url(home_url('/quem-somos')); ?>">Quem somos</a>
          <a href="<?php echo esc_url(home_url('/fazenda')); ?>">Fazenda</a>
        </div>
      </div>
    </div>
  </footer>

  <?php wp_footer(); ?>
</body>
</html>
