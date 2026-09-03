<?php
/**
 * Template Name: Quem Somos (Página Institucional)
 * Author: Netlagos Consulting
 */

get_header();

$hero_img = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : get_template_directory_uri() . '/assets/hero_doctor_medical_desk.png';
$wa_num   = apepi_get_option('apepi_whatsapp_number', '5521979570000');
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<!-- Quem Somos Hero (Estilo Idêntico ao Hero da Home) -->
<section class="hero-home hero-banner-degrade">
  <div class="hero-bg-wrapper">
    <img src="<?php echo esc_url($hero_img); ?>" alt="<?php the_title_attribute(); ?>" class="hero-bg-img">
    <div class="hero-gradient-overlay"></div>
  </div>

  <div class="container hero-grid">
    <div class="hero-text">
      <span class="hero-pre-title">CONHEÇA A APEPI ESCOLA</span>
      <h1 class="font-serif hero-title"><?php the_title(); ?></h1>
      <p class="hero-desc">
        Pioneirismo, ciência e acolhimento na primeira Escola Brasileira de Cannabis Medicinal.
      </p>

      <div class="hero-features-strip">
        <div class="h-feature-item">
          <div class="h-feature-icon"><i class="fa-solid fa-heart-pulse"></i></div>
          <div class="h-feature-text">
            <strong>Desde 2014</strong>
            <span>transformando vidas</span>
          </div>
        </div>

        <div class="h-feature-item">
          <div class="h-feature-icon"><i class="fa-solid fa-seedling"></i></div>
          <div class="h-feature-text">
            <strong>Fazenda Própria</strong>
            <span>pesquisa & cultivo</span>
          </div>
        </div>

        <div class="h-feature-item">
          <div class="h-feature-icon"><i class="fa-solid fa-graduation-cap"></i></div>
          <div class="h-feature-text">
            <strong>Capacitação</strong>
            <span>baseada em evidências</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Floating Glass Card Right -->
    <div class="hero-floating-card-wrapper">
      <div class="hero-floating-card">
        <div class="founders-quote-box" style="padding: 1rem; border-left: 3px solid var(--secondary); margin-bottom: 1.5rem; font-style: italic; color: #ffffff;">
          <p>"Transformamos a busca pelo tratamento da nossa filha em uma missão de vida para milhares de famílias no Brasil."</p>
          <small style="display:block; margin-top: 0.5rem; color: var(--secondary); font-weight: 700; font-style: normal;">— Margarete Brito e Marcos Langenbach (Fundadores)</small>
        </div>

        <a href="<?php echo esc_url(home_url('/#cursos')); ?>" class="btn btn-primary btn-block btn-hero-cta" style="margin-bottom: 1rem;">CONHEÇA NOSSOS CURSOS &rarr;</a>

        <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $wa_num)); ?>" target="_blank" class="hero-card-whatsapp">
          <i class="fa-brands fa-whatsapp"></i> Falar com a APEPI via WhatsApp
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Conteúdo da Página Quem Somos Completa -->
<section class="quem-somos-content-section" style="padding: 4rem 0; background: var(--bg-primary);">
  <div class="container">
    <?php echo do_shortcode('[apepi_pagina_quem_somos]'); ?>
  </div>
</section>

<!-- Trajetória e Linha do Tempo -->
<section class="evolution-timeline-section" style="padding: 4rem 0; background: var(--bg-surface);">
  <div class="container">
    <div class="evolution-header text-center" style="margin-bottom: 3rem;">
      <div class="section-badge">NOSSA TRAJETÓRIA</div>
      <h2 class="font-serif section-main-title">A Evolução da APEPI no Brasil</h2>
      <p class="evolution-subheader" style="color: var(--text-muted);">Um caminho construído com ciência, amor e perseverança</p>
    </div>

    <div class="horizontal-evolution-timeline">
      <div class="evolution-step">
        <div class="step-icon-circle"><i class="fa-solid fa-heart-pulse"></i></div>
        <div>
          <h3>2014</h3>
          <p>Surgimento da iniciativa a partir da busca do tratamento para a pequena Sofia.</p>
        </div>
      </div>

      <div class="timeline-arrow"><i class="fa-solid fa-chevron-right"></i></div>

      <div class="evolution-step">
        <div class="step-icon-circle"><i class="fa-solid fa-scale-balanced"></i></div>
        <div>
          <h3>2016</h3>
          <p>Fundação oficial da Associação APEPI e primeiras vitórias judiciais.</p>
        </div>
      </div>

      <div class="timeline-arrow"><i class="fa-solid fa-chevron-right"></i></div>

      <div class="evolution-step">
        <div class="step-icon-circle"><i class="fa-solid fa-seedling"></i></div>
        <div>
          <h3>2020</h3>
          <p>Concessão do HABEAS CORPUS para cultivo na Fazenda Sofia Langenbach.</p>
        </div>
      </div>

      <div class="timeline-arrow"><i class="fa-solid fa-chevron-right"></i></div>

      <div class="evolution-step">
        <div class="step-icon-circle"><i class="fa-solid fa-graduation-cap"></i></div>
        <div>
          <h3>2023</h3>
          <p>Lançamento oficial da APEPI ESCOLA para formação profissional.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Pilares Section -->
<section class="pilares-section" style="padding: 4rem 0;">
  <div class="container">
    <div class="text-center" style="margin-bottom: 3rem;">
      <div class="section-badge">NOSSO COMPROMISSO</div>
      <h2 class="font-serif section-main-title">Os 4 Pilares da APEPI Escola</h2>
    </div>

    <div class="pilares-grid">
      <div class="pilar-card">
        <div class="pilar-img-holder">
          <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=600&q=80" alt="Ciência Sem Dogmas">
          <div class="pilar-badge-icon"><i class="fa-solid fa-microscope"></i></div>
        </div>
        <div class="pilar-content">
          <h3>Ciência Sem Dogmas</h3>
          <p>Investigação acadêmica constante e rigor na transmissão de evidências clínicas atualizadas.</p>
        </div>
      </div>

      <div class="pilar-card">
        <div class="pilar-img-holder">
          <img src="https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?auto=format&fit=crop&w=600&q=80" alt="Prática no Campo">
          <div class="pilar-badge-icon"><i class="fa-solid fa-leaf"></i></div>
        </div>
        <div class="pilar-content">
          <h3>Prática no Campo</h3>
          <p>Conhecimento prático direto no maior complexo de cultivo medicinal legal do país.</p>
        </div>
      </div>

      <div class="pilar-card">
        <div class="pilar-img-holder">
          <img src="https://images.unsplash.com/photo-1603909223429-69bb7101f420?auto=format&fit=crop&w=600&q=80" alt="Formação Humanizada">
          <div class="pilar-badge-icon"><i class="fa-solid fa-people-group"></i></div>
        </div>
        <div class="pilar-content">
          <h3>Formação Humanizada</h3>
          <p>Foco na escuta empática e no acolhimento de pacientes e suas famílias.</p>
        </div>
      </div>

      <div class="pilar-card">
        <div class="pilar-img-holder">
          <img src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?auto=format&fit=crop&w=600&q=80" alt="Democratização da Saúde">
          <div class="pilar-badge-icon"><i class="fa-solid fa-hand-holding-heart"></i></div>
        </div>
        <div class="pilar-content">
          <h3>Democratização da Saúde</h3>
          <p>Ações e projetos com finalidade social para ampliar o acesso a tratamentos de ponta.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php endwhile; endif; ?>

<?php
get_footer();
