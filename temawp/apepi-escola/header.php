<?php
/**
 * Header Template
 * Merged with WordPress dynamic menus (wp_nav_menu) and exact layout parity with index.html
 */

$logo_light = apepi_get_logo_url('light');
$logo_dark  = apepi_get_logo_url('dark');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> data-theme="light">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script>
    (function() {
      var saved = localStorage.getItem('apepi_theme') || 'light';
      document.documentElement.setAttribute('data-theme', saved);
    })();
  </script>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

  <!-- Header Navbar -->
  <header class="header-navbar">
    <div class="container navbar-content">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="brand-logo">
        <img src="<?php echo esc_url($logo_light); ?>" alt="APEPI Escola" class="logo-img logo-light">
        <img src="<?php echo esc_url($logo_dark); ?>" alt="APEPI Escola" class="logo-img logo-dark">
      </a>

      <nav>
        <?php
        if (has_nav_menu('primary')) {
          wp_nav_menu(array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'nav-links',
            'menu_id'        => 'navLinks',
            'fallback_cb'    => false,
          ));
        } else {
          ?>
          <ul class="nav-links" id="navLinks">
            <li><a href="<?php echo esc_url(home_url('/quem-somos')); ?>">Quem somos</a></li>
            <li><a href="<?php echo esc_url(home_url('/#cursos')); ?>" class="active">Cursos</a></li>
            <li><a href="<?php echo esc_url(home_url('/fazenda')); ?>">Fazenda de Cannabis</a></li>
            <li><a href="<?php echo esc_url(home_url('/#contato')); ?>">Área do Aluno</a></li>
            <li><a href="<?php echo esc_url(home_url('/#contato')); ?>">Contatos</a></li>
          </ul>
          <?php
        }
        ?>
      </nav>

      <div class="nav-actions">
        <button id="themeToggleBtn" class="theme-toggle-btn" title="Alternar Modo de Cores" aria-label="Alternar Modo de Cores">
          <i class="fa-solid fa-moon"></i>
        </button>
        <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Abrir Menu">
          <i class="fa-solid fa-bars"></i>
        </button>
      </div>
    </div>
  </header>
