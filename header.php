<!DOCTYPE html>
<html <?php language_attributes(); ?> data-theme="dark">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

  <!-- Header Navbar -->
  <header class="header-navbar">
    <div class="container navbar-content">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="brand-logo">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/logo_apepi_escola.png" alt="<?php bloginfo('name'); ?>" class="logo-img logo-light">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/logo_apepi_escola_dark.png" alt="<?php bloginfo('name'); ?>" class="logo-img logo-dark">
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
          // Fallback static menu if WordPress Menu is not configured yet in Admin
          ?>
          <ul class="nav-links" id="navLinks">
            <li><a href="<?php echo esc_url(home_url('/quem-somos')); ?>">Quem somos</a></li>
            <li><a href="<?php echo esc_url(home_url('/#cursos')); ?>">Cursos</a></li>
            <li><a href="<?php echo esc_url(home_url('/fazenda')); ?>">Fazenda de Cannabis</a></li>
            <li><a href="<?php echo esc_url(home_url('/#contato')); ?>">Área do Aluno</a></li>
            <li><a href="<?php echo esc_url(home_url('/#contato')); ?>">Contatos</a></li>
          </ul>
          <?php
        }
        ?>
      </nav>

      <div class="nav-actions">
        <a href="<?php echo esc_url(home_url('/#cursos')); ?>" class="btn btn-primary btn-sm">Ver Cursos</a>
        <button id="themeToggleBtn" class="theme-toggle-btn" title="Alternar Modo de Cores" aria-label="Alternar Modo de Cores">
          <i class="fa-solid fa-moon"></i>
        </button>
        <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Abrir Menu Mobile">
          <i class="fa-solid fa-bars"></i>
        </button>
      </div>
    </div>
  </header>
