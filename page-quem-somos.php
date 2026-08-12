<?php
/**
 * Template Name: Quem Somos (Página Institucional)
 * Author: Netlagos Consulting
 */

get_header();
?>

<!-- Quem Somos Hero -->
<section class="quem-somos-hero">
  <div class="container qs-hero-grid">
    <div class="qs-hero-left">
      <span class="qs-badge">CONHEÇA A APEPI ESCOLA</span>
      <h1 class="font-serif section-main-title">Pioneirismo, Ciência e Humanização.</h1>
      <p class="qs-subtitle">A principal Escola Brasileira de Cannabis Medicinal.</p>
      <p class="qs-desc">
        Nascida da coragem e do pioneirismo da APEPI (Associação de Apoio à Pesquisa e à Pacientes de Cannabis Medicinal), a APEPI Escola consolida anos de aprendizado, militância e acolhimento em uma plataforma educacional de excelência.
      </p>
      <div class="hero-actions">
        <a href="<?php echo esc_url(home_url('/#cursos')); ?>" class="btn btn-primary">CONHEÇA NOSSOS CURSOS &rarr;</a>
        <a href="<?php echo esc_url(home_url('/fazenda')); ?>" class="btn btn-ghost">CONHEÇA A FAZENDA &rarr;</a>
      </div>
    </div>

    <div class="founders-container-relative">
      <div class="founders-img-container">
        <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=800&q=80" alt="Margarete Brito e Marcos Langenbach - Fundadores da APEPI" class="founders-img">
      </div>
      <div class="founders-speech-card">
        <p>"Transformamos a busca pelo tratamento da nossa filha em uma missão de vida para milhares de famílias no Brasil."</p>
      </div>
    </div>
  </div>
</section>

<!-- Lineage / Timeline Section -->
<section class="evolution-timeline-section">
  <div class="container">
    <div class="evolution-header text-center">
      <div class="section-badge">NOSSA TRAJETÓRIA</div>
      <h2 class="font-serif">A Evolução da APEPI no Brasil</h2>
      <p class="evolution-subheader">Um caminho construído com ciência, amor e perseverança</p>
    </div>

    <div class="horizontal-evolution-timeline">
      <!-- Step 1 -->
      <div class="evolution-step">
        <div class="step-icon-circle"><i class="fa-solid fa-heart-pulse"></i></div>
        <div>
          <h3>2014</h3>
          <p>Surgimento da iniciativa a partir da busca do tratamento para a pequena Sofia.</p>
        </div>
      </div>

      <div class="timeline-arrow"><i class="fa-solid fa-chevron-right"></i></div>

      <!-- Step 2 -->
      <div class="evolution-step">
        <div class="step-icon-circle"><i class="fa-solid fa-scale-balanced"></i></div>
        <div>
          <h3>2016</h3>
          <p>Fundação oficial da Associação APEPI e primeiras vitórias judiciais.</p>
        </div>
      </div>

      <div class="timeline-arrow"><i class="fa-solid fa-chevron-right"></i></div>

      <!-- Step 3 -->
      <div class="evolution-step">
        <div class="step-icon-circle"><i class="fa-solid fa-seedling"></i></div>
        <div>
          <h3>2020</h3>
          <p>Concessão do HABEAS CORPUS para cultivo na Fazenda Sofia Langenbach.</p>
        </div>
      </div>

      <div class="timeline-arrow"><i class="fa-solid fa-chevron-right"></i></div>

      <!-- Step 4 -->
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
<section class="pilares-section">
  <div class="container">
    <div class="text-center">
      <div class="section-badge">NOSSO COMPROMISSO</div>
      <h2 class="font-serif section-main-title">Os 4 Pilares da APEPI Escola</h2>
    </div>

    <div class="pilares-grid">
      <!-- Pilar 1 -->
      <div class="pilar-card">
        <div class="pilar-img-holder">
          <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=600&q=80" alt="Parte da história">
          <div class="pilar-badge-icon"><i class="fa-solid fa-microscope"></i></div>
        </div>
        <div class="pilar-content">
          <h3>Ciência Sem Dogmas</h3>
          <p>Investigação acadêmica constante e rigor na transmissão de evidências clínicas atualizadas.</p>
        </div>
      </div>

      <!-- Pilar 2 -->
      <div class="pilar-card">
        <div class="pilar-img-holder">
          <img src="https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?auto=format&fit=crop&w=600&q=80" alt="Pioneirismo e inovação">
          <div class="pilar-badge-icon"><i class="fa-solid fa-leaf"></i></div>
        </div>
        <div class="pilar-content">
          <h3>Prática no Campo</h3>
          <p>Conhecimento prático direto no maior complexo de cultivo medicinal legal do país.</p>
        </div>
      </div>

      <!-- Pilar 3 -->
      <div class="pilar-card">
        <div class="pilar-img-holder">
          <img src="https://images.unsplash.com/photo-1603909223429-69bb7101f420?auto=format&fit=crop&w=600&q=80" alt="Tecnologia e sustentabilidade">
          <div class="pilar-badge-icon"><i class="fa-solid fa-people-group"></i></div>
        </div>
        <div class="pilar-content">
          <h3>Formação Humanizada</h3>
          <p>Foco na escuta empática e no acolhimento de pacientes e suas famílias.</p>
        </div>
      </div>

      <!-- Pilar 4 -->
      <div class="pilar-card">
        <div class="pilar-img-holder">
          <img src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?auto=format&fit=crop&w=600&q=80" alt="Qualidade, segurança e união">
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

<?php
get_footer();
