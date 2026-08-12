<?php
/**
 * Template Name: Página Inicial (Front Page)
 * Author: Netlagos Consulting
 */

get_header();
?>

<!-- Hero Section Home -->
<section class="hero-home">
  <div class="container hero-grid">
    <div class="hero-text">
      <span class="hero-badge">A PRINCIPAL ESCOLA BRASILEIRA DE CANNABIS MEDICINAL</span>
      <h1 class="font-serif hero-title">
        Pioneirismo em saúde,<br>
        <span class="highlight-line">pesquisa</span> e educação.
      </h1>
      <p class="hero-desc">
        Capacitação multiprofissional com fundamentação científica rigorosa, prática clínica e compromisso social com o bem-estar e a qualidade de vida.
      </p>
      <div class="hero-actions">
        <a href="#cursos" class="btn btn-primary">CONHEÇA NOSSOS CURSOS &rarr;</a>
        <a href="<?php echo esc_url(home_url('/fazenda')); ?>" class="btn btn-ghost">CONHEÇA A FAZENDA &rarr;</a>
      </div>
    </div>

    <div class="hero-visual">
      <div class="hero-img-wrapper">
        <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1000&q=80" alt="Profissionais de saúde e cientistas em laboratório da APEPI" class="hero-main-img">
      </div>
    </div>
  </div>
</section>

<!-- Stats Bar Section -->
<section class="stats-bar-section">
  <div class="container">
    <div class="stats-bar-grid">
      <!-- Stat 1 -->
      <div class="stat-item">
        <div class="stat-icon-wrapper"><i class="fa-solid fa-graduation-cap"></i></div>
        <div class="stat-info">
          <h3>+2.000</h3>
          <p>Alunos Formados</p>
        </div>
      </div>
      <!-- Stat 2 -->
      <div class="stat-item">
        <div class="stat-icon-wrapper"><i class="fa-solid fa-user-doctor"></i></div>
        <div class="stat-info">
          <h3>+20</h3>
          <p>Professores Especialistas</p>
        </div>
      </div>
      <!-- Stat 3 -->
      <div class="stat-item">
        <div class="stat-icon-wrapper"><i class="fa-solid fa-seedling"></i></div>
        <div class="stat-info">
          <h3>1ª Fazenda</h3>
          <p>Legal de Cannabis do Brasil</p>
        </div>
      </div>
      <!-- Stat 4 -->
      <div class="stat-item">
        <div class="stat-icon-wrapper"><i class="fa-solid fa-book-medical"></i></div>
        <div class="stat-info">
          <h3>Conteúdo</h3>
          <p>Científico Atualizado</p>
        </div>
      </div>
      <!-- Stat 5 -->
      <div class="stat-item">
        <div class="stat-icon-wrapper"><i class="fa-solid fa-users-rectangle"></i></div>
        <div class="stat-info">
          <h3>Formação</h3>
          <p>Multiprofissional</p>
        </div>
      </div>
      <!-- Stat 6 -->
      <div class="stat-item">
        <div class="stat-icon-wrapper"><i class="fa-solid fa-award"></i></div>
        <div class="stat-info">
          <h3>Certificado</h3>
          <p>Reconhecido no Mercado</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Formações Section (Carrossel) -->
<section class="formations-section" id="cursos">
  <div class="container">
    <div class="section-title-area">
      <div>
        <div class="section-badge">NOSSOS CURSOS & MENTORIAS</div>
        <h2 class="font-serif section-main-title">Formações em Destaque</h2>
      </div>
      <div class="section-arrows">
        <button class="arrow-btn arrow-prev" aria-label="Anterior"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="arrow-btn arrow-next" aria-label="Próximo"><i class="fa-solid fa-chevron-right"></i></button>
      </div>
    </div>

    <div class="formations-carousel-wrapper">
      <div class="formations-grid">
        
        <!-- Card 1 -->
        <article class="formation-card">
          <div class="card-img-holder">
            <img src="https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?auto=format&fit=crop&w=600&q=80" alt="Prescrição Médica">
            <div class="card-badge-icon"><i class="fa-solid fa-stethoscope"></i></div>
          </div>
          <div class="card-content">
            <h3>Capacitação em Prescrição de Cannabis</h3>
            <p>Formação completa para médicos com foco em farmacologia, dosagem e prática clínica baseada em evidências.</p>
            <a href="<?php echo esc_url(home_url('/course-detail')); ?>" class="saiba-mais-btn">SAIBA MAIS <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </article>

        <!-- Card 2 -->
        <article class="formation-card">
          <div class="card-img-holder">
            <img src="https://images.unsplash.com/photo-1576201836106-db1758fd1c97?auto=format&fit=crop&w=600&q=80" alt="Prescrição Veterinária">
            <div class="card-badge-icon"><i class="fa-solid fa-paw"></i></div>
          </div>
          <div class="card-content">
            <h3>Cannabis na Medicina Veterinária</h3>
            <p>Capacitação especializada para médicos veterinários no tratamento de cães, gatos e animais de grande porte.</p>
            <a href="<?php echo esc_url(home_url('/course-detail-vet')); ?>" class="saiba-mais-btn">SAIBA MAIS <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </article>

        <!-- Card 3 -->
        <article class="formation-card">
          <div class="card-img-holder">
            <img src="https://images.unsplash.com/photo-1582750433449-648ed127bb54?auto=format&fit=crop&w=600&q=80" alt="Cannabis na Rotina">
            <div class="card-badge-icon"><i class="fa-solid fa-cannabis"></i></div>
          </div>
          <div class="card-content">
            <h3>Curso Prático de Cultivo & Extração</h3>
            <p>Domine o plantio agroecológico e o manuseio seguro para extração de óleos medicinais na fazenda da APEPI.</p>
            <a href="<?php echo esc_url(home_url('/course-detail-cultivo')); ?>" class="saiba-mais-btn">SAIBA MAIS <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </article>

        <!-- Card 4 -->
        <article class="formation-card">
          <div class="card-img-holder">
            <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=600&q=80" alt="Atualização em Prescrição">
            <div class="card-badge-icon"><i class="fa-solid fa-user-doctor"></i></div>
          </div>
          <div class="card-content">
            <h3>Atualização Intensiva para Prescritores</h3>
            <p>Módulos de aprofundamento em casos complexos, interações medicamentosas e titulação contínua.</p>
            <a href="<?php echo esc_url(home_url('/course-detail')); ?>" class="saiba-mais-btn">SAIBA MAIS <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </article>

        <!-- Card 5 -->
        <article class="formation-card">
          <div class="card-img-holder">
            <img src="https://images.unsplash.com/photo-1532938911079-1b06ac7ceec7?auto=format&fit=crop&w=600&q=80" alt="Mentoria Médica">
            <div class="card-badge-icon"><i class="fa-solid fa-users"></i></div>
          </div>
          <div class="card-content">
            <h3>Mentoria Clínica Individualizada</h3>
            <p>Acompanhamento de casos reais com médicos seniores da APEPI para aprimoramento da conduta terapêutica.</p>
            <a href="<?php echo esc_url(home_url('/course-detail')); ?>" class="saiba-mais-btn">SAIBA MAIS <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </article>

      </div>
    </div>
  </div>
</section>

<!-- Fazenda Section Home -->
<section class="fazenda-section-home">
  <div class="container fazenda-home-grid">
    <div class="fazenda-img-box">
      <img src="https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?auto=format&fit=crop&w=1000&q=80" alt="Estufa de cultivo de Cannabis na Fazenda Sofia Langenbach" class="fazenda-home-main-img">
    </div>

    <div class="fazenda-text-card">
      <span class="hero-badge">EXPERIÊNCIA PRÁTICA E IMERSIVA</span>
      <h2 class="font-serif">Fazenda de Cannabis Sofia Langenbach</h2>
      <p>
        A primeira fazenda legal de cultivo de Cannabis do Brasil. Um espaço dedicado à pesquisa acadêmica, controle de qualidade, extração de compostos e aprendizado direto no campo.
      </p>
      <a href="<?php echo esc_url(home_url('/fazenda')); ?>" class="btn btn-secondary">CONHEÇA A FAZENDA &rarr;</a>
    </div>
  </div>
</section>

<!-- Diferenciais Section Home -->
<section class="diferenciais-section-home">
  <div class="container">
    <h2 class="font-serif diferenciais-title">Por que escolher a APEPI Escola?</h2>

    <div class="diferenciais-grid">
      <!-- Dif 1 -->
      <div class="diferencial-card">
        <div class="dif-icon-holder"><i class="fa-solid fa-microscope"></i></div>
        <h3>Rigor Científico</h3>
        <p>Conteúdos embasados nas mais recentes evidências científicas e pesquisas acadêmicas globais.</p>
      </div>

      <!-- Dif 2 -->
      <div class="diferencial-card">
        <div class="dif-icon-holder"><i class="fa-solid fa-house-medical"></i></div>
        <h3>Prática de Campo</h3>
        <p>Acesso exclusivo à Fazenda Sofia Langenbach para vivência do cultivo até a extração.</p>
      </div>

      <!-- Dif 3 -->
      <div class="diferencial-card">
        <div class="dif-icon-holder"><i class="fa-solid fa-user-shield"></i></div>
        <h3>Suporte Contínuo</h3>
        <p>Acompanhamento e discussão de casos clínicos com especialistas renomados na área.</p>
      </div>

      <!-- Dif 4 -->
      <div class="diferencial-card">
        <div class="dif-icon-holder"><i class="fa-solid fa-hands-holding-child"></i></div>
        <h3>Impacto Social</h3>
        <p>Formação alinhada ao compromisso humano de ampliar o acesso à saúde e à qualidade de vida.</p>
      </div>
    </div>
  </div>
</section>

<!-- Professores Section -->
<section class="professores-section-home">
  <div class="container">
    <div class="professores-header">
      <div>
        <div class="section-badge">CORPO DOCENTE QUALIFICADO</div>
        <h2 class="font-serif">Nossos Professores</h2>
      </div>
      <a href="<?php echo esc_url(home_url('/quem-somos')); ?>" class="view-all-link">VER TODOS OS PROFESSORES &rarr;</a>
    </div>

    <div class="professores-grid">
      <!-- Prof 1 -->
      <article class="professor-card">
        <div class="prof-img-holder">
          <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=500&q=80" alt="Dr. Pedro da Costa Mello Neto">
        </div>
        <div class="prof-info">
          <h3>Dr. Pedro Mello Neto</h3>
          <p class="prof-sub">Médico Neurologista</p>
          <span class="prof-crm">CRM-RJ 85940</span>
        </div>
      </article>

      <!-- Prof 2 -->
      <article class="professor-card">
        <div class="prof-img-holder">
          <img src="https://images.unsplash.com/photo-1651008376811-b90baee60c1f?auto=format&fit=crop&w=500&q=80" alt="Dra. Aline Barros">
        </div>
        <div class="prof-info">
          <h3>Dra. Aline Barros</h3>
          <p class="prof-sub">Farmacologista Clínica</p>
          <span class="prof-crm">CRF-RJ 14205</span>
        </div>
      </article>

      <!-- Prof 3 -->
      <article class="professor-card">
        <div class="prof-img-holder">
          <img src="https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=500&q=80" alt="Dr. Carlos Zimmer Jr.">
        </div>
        <div class="prof-info">
          <h3>Dr. Carlos Zimmer</h3>
          <p class="prof-sub">Médico Pediatra</p>
          <span class="prof-crm">CRM-SP 112040</span>
        </div>
      </article>

      <!-- Prof 4 -->
      <article class="professor-card">
        <div class="prof-img-holder">
          <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=500&q=80" alt="Dra. Patrícia Moreira">
        </div>
        <div class="prof-info">
          <h3>Dra. Patrícia Moreira</h3>
          <p class="prof-sub">Médica Veterinária</p>
          <span class="prof-crm">CRMV-RJ 4820</span>
        </div>
      </article>

      <!-- Prof 5 -->
      <article class="professor-card">
        <div class="prof-img-holder">
          <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=500&q=80" alt="Dr. Victor Vilhena Barroso">
        </div>
        <div class="prof-info">
          <h3>Dr. Victor Vilhena</h3>
          <p class="prof-sub">Pesquisador Agrônomo</p>
          <span class="prof-crm">CREA-RJ 99402</span>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- Depoimentos Section -->
<section class="depoimentos-section-home">
  <div class="container">
    <div class="depoimentos-header">
      <div>
        <div class="section-badge">DEPOIMENTOS EM VÍDEO</div>
        <h2 class="font-serif">O que dizem nossos alunos</h2>
      </div>
    </div>

    <div class="depoimentos-grid">
      <!-- Dep 1 -->
      <article class="depoimento-video-card">
        <div class="video-thumbnail-box">
          <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=600&q=80" alt="Dra. Camila Toledo">
          <button class="video-play-btn" aria-label="Tocar Vídeo"><i class="fa-solid fa-play"></i></button>
        </div>
        <div class="video-card-info">
          <h3>Dra. Camila Toledo</h3>
          <p>Médica Psiquiatra</p>
        </div>
      </article>

      <!-- Dep 2 -->
      <article class="depoimento-video-card">
        <div class="video-thumbnail-box">
          <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=600&q=80" alt="Dr. Eduardo Ramos">
          <button class="video-play-btn" aria-label="Tocar Vídeo"><i class="fa-solid fa-play"></i></button>
        </div>
        <div class="video-card-info">
          <h3>Dr. Eduardo Ramos</h3>
          <p>Médico de Família</p>
        </div>
      </article>

      <!-- Dep 3 -->
      <article class="depoimento-video-card">
        <div class="video-thumbnail-box">
          <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=600&q=80" alt="Dra. Mariana Fontes">
          <button class="video-play-btn" aria-label="Tocar Vídeo"><i class="fa-solid fa-play"></i></button>
        </div>
        <div class="video-card-info">
          <h3>Dra. Mariana Fontes</h3>
          <p>Médica Veterinária</p>
        </div>
      </article>

      <!-- Dep 4 -->
      <article class="depoimento-video-card">
        <div class="video-thumbnail-box">
          <img src="https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=600&q=80" alt="Dr. Roberto Guimarães">
          <button class="video-play-btn" aria-label="Tocar Vídeo"><i class="fa-solid fa-play"></i></button>
        </div>
        <div class="video-card-info">
          <h3>Dr. Roberto Guimarães</h3>
          <p>Médico Oncologista</p>
        </div>
      </article>
    </div>
  </div>
</section>

<?php
get_footer();
