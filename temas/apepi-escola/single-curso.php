<?php
/**
 * Template Name: Detalhe do Curso (Single Curso CPT)
 * Author: Netlagos Consulting
 */

get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<!-- Course Hero Section -->
<section class="course-hero-section">
  <div class="container course-hero-grid">
    <div class="course-hero-left">
      <span class="course-badge-sub">FORMAÇÃO PROFISSIONAL ESPECIALIZADA</span>
      <h1 class="font-serif course-title"><?php the_title(); ?></h1>
      <p class="family-tagline">Capacitação clínica, científica e prática com a excelência APEPI Escola.</p>
      
      <div class="course-intro-desc">
        <?php the_excerpt(); ?>
      </div>

      <div class="course-hero-badges">
        <div class="course-hero-badge"><i class="fa-solid fa-clock"></i> 60 Horas Aula</div>
        <div class="course-hero-badge"><i class="fa-solid fa-laptop-medical"></i> 100% Online + Aulas ao Vivo</div>
        <div class="course-hero-badge"><i class="fa-solid fa-certificate"></i> Certificado Reconhecido</div>
      </div>
    </div>

    <!-- Sticky Card Sidebar -->
    <div class="course-hero-right">
      <div class="course-sticky-card">
        <div class="sticky-card-body">
          <div class="sticky-info-item">
            <div class="sticky-icon"><i class="fa-solid fa-calendar-days"></i></div>
            <div class="sticky-text">
              <span class="label">INÍCIO DAS AULAS</span>
              <strong>Inscrições Abertas</strong>
            </div>
          </div>

          <div class="sticky-info-item">
            <div class="sticky-icon"><i class="fa-solid fa-user-graduate"></i></div>
            <div class="sticky-text">
              <span class="label">PÚBLICO-ALVO</span>
              <strong>Médicos e Profissionais da Saúde</strong>
            </div>
          </div>

          <div class="sticky-info-item">
            <div class="sticky-icon"><i class="fa-solid fa-shield-halved"></i></div>
            <div class="sticky-text">
              <span class="label">GARANTIA</span>
              <strong>7 dias de garantia incondicional</strong>
            </div>
          </div>

          <a href="https://wa.me/5521979570000" target="_blank" class="btn btn-primary btn-block">
            INSCREVER-SE AGORA &rarr;
          </a>

          <a href="https://wa.me/5521979570000" target="_blank" class="whatsapp-consultor">
            <i class="fa-brands fa-whatsapp"></i> Falar com um Consultor de Matrícula
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Main Course Content -->
<section class="course-info-section">
  <div class="container">
    <div class="course-info-grid">
      <div class="course-main-content">
        <h2 class="sub-section-title">Sobre a Formação</h2>
        <div class="course-full-text">
          <?php the_content(); ?>
        </div>

        <!-- Accordion Conteúdo Programático -->
        <div class="programmatic-content-area">
          <h2 class="sub-section-title">Conteúdo Programático</h2>
          
          <div class="accordion-container">
            <div class="accordion-item active">
              <button class="accordion-trigger">
                <div class="acc-title-group">
                  <div class="acc-icon"><i class="fa-solid fa-brain"></i></div>
                  <div class="acc-text-info">
                    <strong>Módulo 1: Sistema Endocanabinoide e Fisiologia</strong>
                    <small>10 Horas • Receptores CB1, CB2 e Ligantes Endógenos</small>
                  </div>
                </div>
                <i class="fa-solid fa-chevron-down acc-chevron"></i>
              </button>
              <div class="accordion-panel" style="max-height: 200px;">
                <p>Estudo aprofundado da homeostase corporal, receptores celulares, tom endocanabinoide e mecanismo de ação dos fitocanabinoides (THC, CBD, CBG, CBN).</p>
              </div>
            </div>

            <div class="accordion-item">
              <button class="accordion-trigger">
                <div class="acc-title-group">
                  <div class="acc-icon"><i class="fa-solid fa-prescription-bottle-medical"></i></div>
                  <div class="acc-text-info">
                    <strong>Módulo 2: Farmacologia e Posologia Clínica</strong>
                    <small>15 Horas • Titulação, Interações e Farmacocinética</small>
                  </div>
                </div>
                <i class="fa-solid fa-chevron-down acc-chevron"></i>
              </button>
              <div class="accordion-panel">
                <p>Cálculo de doses, estratégias de titulação individualizada, janelas terapêuticas, proporções THC:CBD e prevenção de interações com fármacos convencionais.</p>
              </div>
            </div>

            <div class="accordion-item">
              <button class="accordion-trigger">
                <div class="acc-title-group">
                  <div class="acc-icon"><i class="fa-solid fa-notes-medical"></i></div>
                  <div class="acc-text-info">
                    <strong>Módulo 3: Prática Clínica e Casos Reais</strong>
                    <small>20 Horas • Discussão de Pacientes RCF e Acompanhamento</small>
                  </div>
                </div>
                <i class="fa-solid fa-chevron-down acc-chevron"></i>
              </button>
              <div class="accordion-panel">
                <p>Análise detalhada de condutas clínicas aplicadas à dor crônica, ansiedade, epilepsia refratária, autismo, Parkinson e cuidados paliativos.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php endwhile; endif; ?>

<?php
get_footer();
