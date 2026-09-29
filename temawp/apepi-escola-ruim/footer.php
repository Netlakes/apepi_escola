<?php
/**
 * Footer Template
 * Merged with WordPress dynamic menus (wp_nav_menu) and APEPI Escola Options
 */

$logo_light = apepi_get_logo_url('light');
$logo_dark  = apepi_get_logo_url('dark');

$wa_num   = apepi_get_option('apepi_whatsapp_number', '5521979570000');
$wa_text  = apepi_get_option('apepi_whatsapp_text', 'Atendimento via WhatsApp');
$email    = apepi_get_option('apepi_contact_email', 'contato@apepi.com.br');
$phone    = apepi_get_option('apepi_contact_phone', '(21) 97957-0000');
$address  = apepi_get_option('apepi_contact_address', 'Rio de Janeiro - RJ');

$insta    = apepi_get_option('apepi_social_instagram', '#');
$linkedin = apepi_get_option('apepi_social_linkedin', '#');
$youtube  = apepi_get_option('apepi_social_youtube', '#');
$fb       = apepi_get_option('apepi_social_facebook', '#');
?>
  <!-- Footer -->
  <footer class="site-footer">
    <div class="container footer-content">
      <div class="footer-left">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="brand-logo">
          <img src="<?php echo esc_url($logo_light); ?>" alt="APEPI Escola" class="footer-logo-img logo-light">
          <img src="<?php echo esc_url($logo_dark); ?>" alt="APEPI Escola" class="footer-logo-img logo-dark">
        </a>
        
        <p class="footer-tagline">
          A principal Escola Brasileira de Cannabis Medicinal. Formação científica, prática clínica e acompanhamento com excelência.
        </p>
        <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $wa_num)); ?>" target="_blank" class="footer-whatsapp-badge">
          <i class="fa-brands fa-whatsapp"></i> <?php echo esc_html($wa_text); ?>
        </a>
      </div>

      <div class="footer-center">
        <h3>Links Rápidos</h3>
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
            <li><a href="<?php echo esc_url(home_url('/#cursos')); ?>"><i class="fa-solid fa-chevron-right" style="font-size: 0.65rem;"></i> Cursos</a></li>
            <li><a href="<?php echo esc_url(home_url('/#cursos')); ?>"><i class="fa-solid fa-chevron-right" style="font-size: 0.65rem;"></i> Mentorias</a></li>
            <li><a href="<?php echo esc_url(home_url('/quem-somos')); ?>"><i class="fa-solid fa-chevron-right" style="font-size: 0.65rem;"></i> Professores</a></li>
            <li><a href="<?php echo esc_url(home_url('/fazenda')); ?>"><i class="fa-solid fa-chevron-right" style="font-size: 0.65rem;"></i> Fazenda de Cannabis</a></li>
            <li><a href="<?php echo esc_url(home_url('/quem-somos')); ?>"><i class="fa-solid fa-chevron-right" style="font-size: 0.65rem;"></i> Pesquisa</a></li>
            <li><a href="<?php echo esc_url(home_url('/')); ?>"><i class="fa-solid fa-chevron-right" style="font-size: 0.65rem;"></i> Conteúdo</a></li>
            <li><a href="<?php echo esc_url(home_url('/#contato')); ?>"><i class="fa-solid fa-chevron-right" style="font-size: 0.65rem;"></i> Área do Aluno</a></li>
            <li><a href="<?php echo esc_url(home_url('/#contato')); ?>"><i class="fa-solid fa-chevron-right" style="font-size: 0.65rem;"></i> Contatos</a></li>
          </ul>
          <?php
        }
        ?>
      </div>

      <div class="footer-right">
        <h3>Contato</h3>
        <div class="footer-right-list">
          <div class="footer-contact-item">
            <span class="contact-icon-pill"><i class="fa-regular fa-envelope"></i></span>
            <span><?php echo esc_html($email); ?></span>
          </div>
          <div class="footer-contact-item">
            <span class="contact-icon-pill"><i class="fa-solid fa-phone"></i></span>
            <span><?php echo esc_html($phone); ?></span>
          </div>
          <div class="footer-contact-item">
            <span class="contact-icon-pill"><i class="fa-solid fa-location-dot"></i></span>
            <span><?php echo esc_html($address); ?></span>
          </div>
        </div>
        
        <div class="footer-socials">
          <?php if (!empty($insta)) : ?><a href="<?php echo esc_url($insta); ?>" target="_blank" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a><?php endif; ?>
          <?php if (!empty($linkedin)) : ?><a href="<?php echo esc_url($linkedin); ?>" target="_blank" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a><?php endif; ?>
          <?php if (!empty($youtube)) : ?><a href="<?php echo esc_url($youtube); ?>" target="_blank" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a><?php endif; ?>
          <?php if (!empty($fb)) : ?><a href="<?php echo esc_url($fb); ?>" target="_blank" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a><?php endif; ?>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="container">
        <p>&copy; <?php echo date('Y'); ?> APEPI Escola. Todos os direitos reservados.</p>
        <div class="footer-bottom-links">
          <a href="#">Termos de Uso</a>
          <a href="#">Política de Privacidade</a>
          <a href="#">Acessibilidade</a>
        </div>
      </div>
    </div>
  </footer>

  <?php wp_footer(); ?>
</body>
</html>
