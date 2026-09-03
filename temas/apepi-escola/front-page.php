<?php
/**
 * Template Name: Página Inicial (Front Page)
 * Description: Template oficial da página inicial da APEPI Escola dinâmico e integrado ao WordPress
 * Author: Netlagos Consulting
 */

get_header();

// Opções do Hero via apepi_get_option
$hero_title     = apepi_get_option('apepi_hero_title', "A principal Escola\nBrasileira de\nCannabis Medicinal");
$hero_desc      = apepi_get_option('apepi_hero_desc', "Formação baseada em evidências científicas,\nprática clínica e experiências reais de cultivo\ne acompanhamento terapêutico.");
$hero_cta1_text = apepi_get_option('apepi_hero_cta_text', 'CONHEÇA NOSSOS CURSOS');
$hero_cta1_url  = apepi_get_option('apepi_hero_cta_url', '#cursos');
$hero_cta2_text = apepi_get_option('apepi_hero_cta2_text', 'CONHEÇA A FAZENDA');
$hero_cta2_url  = apepi_get_option('apepi_hero_cta2_url', home_url('/fazenda'));
$hero_bg_img    = apepi_get_option('apepi_hero_bg_image', get_template_directory_uri() . '/assets/hero_lab_clean.png');
$wa_num         = apepi_get_option('apepi_whatsapp_number', '5521979570000');

// Estatísticas
$stat_years  = apepi_get_option('apepi_stat_exp_years', '10 anos');
$stat_profs  = apepi_get_option('apepi_stat_professors', '120+');
$stat_stud   = apepi_get_option('apepi_stat_students', '6.500+');
$stat_states = apepi_get_option('apepi_stat_states', '26');
$stat_hours  = apepi_get_option('apepi_stat_hours', '2.400+');
$stat_cases  = apepi_get_option('apepi_stat_cases', '1.500+');
?>

  <!-- Hero Section Home (Estilo Degradê Idêntico a Quem Somos - Sans-serif) -->
  <section class="hero-home-exact hero-banner-degrade">
    <div class="hero-bg-wrapper">
      <img src="<?php echo esc_url($hero_bg_img); ?>" alt="APEPI Escola - Laboratório e Prática Clínica" class="hero-bg-img">
      <div class="hero-gradient-overlay"></div>
    </div>

    <div class="container hero-container-exact">
      <div class="hero-content-exact">
        <h1 class="hero-title-exact">
          <?php 
          if (!empty($hero_title)) {
              $formatted_title = esc_html($hero_title);
              $formatted_title = str_replace("Cannabis Medicinal", '<span class="text-green">Cannabis Medicinal</span>', $formatted_title);
              echo nl2br($formatted_title);
          } else {
              echo 'A principal Escola Brasileira de <span class="text-green">Cannabis Medicinal</span>';
          }
          ?>
        </h1>

        <div class="hero-green-divider"></div>

        <p class="hero-desc-exact">
          <?php echo nl2br(esc_html($hero_desc)); ?>
        </p>

        <div class="hero-cta-group-exact">
          <?php if (!empty($hero_cta1_text)) : ?>
            <a href="<?php echo esc_url($hero_cta1_url); ?>" class="btn-hero-green">
              <?php echo esc_html($hero_cta1_text); ?> &nbsp;&rarr;
            </a>
          <?php endif; ?>
          <?php if (!empty($hero_cta2_text)) : ?>
            <a href="<?php echo esc_url($hero_cta2_url); ?>" class="btn-hero-outline">
              <?php echo esc_html($hero_cta2_text); ?> &nbsp;&rarr;
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- Stats Bar Section (Fundo Creme / Ícones Redondos Verdes) -->
  <section class="stats-bar-exact">
    <div class="container stats-grid-exact">
      <div class="stat-item-exact">
        <div class="stat-icon-exact"><i class="fa-solid fa-graduation-cap"></i></div>
        <div class="stat-text-exact">
          <span class="stat-number-exact"><?php echo esc_html($stat_years); ?></span>
          <span class="stat-label-exact">De experiência educacional</span>
        </div>
      </div>

      <div class="stat-item-exact">
        <div class="stat-icon-exact"><i class="fa-solid fa-users"></i></div>
        <div class="stat-text-exact">
          <span class="stat-number-exact"><?php echo esc_html($stat_profs); ?></span>
          <span class="stat-label-exact">Professores especialistas</span>
        </div>
      </div>

      <div class="stat-item-exact">
        <div class="stat-icon-exact"><i class="fa-regular fa-user"></i></div>
        <div class="stat-text-exact">
          <span class="stat-number-exact"><?php echo esc_html($stat_stud); ?></span>
          <span class="stat-label-exact">Alunos capacitados</span>
        </div>
      </div>

      <div class="stat-item-exact">
        <div class="stat-icon-exact"><i class="fa-solid fa-map-location-dot"></i></div>
        <div class="stat-text-exact">
          <span class="stat-number-exact"><?php echo esc_html($stat_states); ?></span>
          <span class="stat-label-exact">Estados atendidos</span>
        </div>
      </div>

      <div class="stat-item-exact">
        <div class="stat-icon-exact"><i class="fa-regular fa-clock"></i></div>
        <div class="stat-text-exact">
          <span class="stat-number-exact"><?php echo esc_html($stat_hours); ?></span>
          <span class="stat-label-exact">Horas de conteúdo</span>
        </div>
      </div>

      <div class="stat-item-exact">
        <div class="stat-icon-exact"><i class="fa-regular fa-clipboard"></i></div>
        <div class="stat-text-exact">
          <span class="stat-number-exact"><?php echo esc_html($stat_cases); ?></span>
          <span class="stat-label-exact">Casos clínicos discutidos</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Formações Section (Loop Dinâmico do CPT Curso com Fallback) -->
  <section class="formations-section" id="cursos">
    <div class="container">
      <div class="section-title-area">
        <div>
          <div class="section-badge">CONHEÇA NOSSAS</div>
          <h2 class="section-main-title font-serif">FORMAÇÕES</h2>
        </div>
        <div class="section-arrows">
          <button class="arrow-btn prevFormBtn" id="prevForm" aria-label="Anterior"><i class="fa-solid fa-chevron-left"></i></button>
          <button class="arrow-btn nextFormBtn" id="nextForm" aria-label="Próximo"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
      </div>

      <div class="formations-carousel-wrapper">
        <div class="formations-grid" id="formationsGrid">
          
          <?php
          $args_cursos = array(
            'post_type'      => array('curso', 'cursos', 'jet-engine-curso'),
            'posts_per_page' => 10,
            'post_status'    => 'publish',
          );
          $query_cursos = new WP_Query($args_cursos);

          if ($query_cursos->have_posts()) :
            while ($query_cursos->have_posts()) : $query_cursos->the_post();
              $icone = apepi_get_course_meta(get_the_ID(), 'icone', 'fa-solid fa-user-doctor');
              $thumb = apepi_get_course_thumb_image(get_the_ID());
              ?>
              <div class="formation-card">
                <div class="card-img-holder">
                  <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>">
                  <div class="card-badge-icon"><i class="<?php echo esc_attr($icone); ?>"></i></div>
                </div>
                <div class="card-content">
                  <h3 class="font-serif"><?php the_title(); ?></h3>
                  <p><?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?></p>
                  <a href="<?php the_permalink(); ?>" class="saiba-mais-btn">SAIBA MAIS &rarr;</a>
                </div>
              </div>
              <?php
            endwhile;
            wp_reset_postdata();
          else :
            // Fallback de demonstração caso ainda não existam posts de curso cadastrados no WP
            ?>
            <div class="formation-card">
              <div class="card-img-holder">
                <img src="https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?auto=format&fit=crop&w=600&q=80" alt="Prescrição Médica">
                <div class="card-badge-icon"><i class="fa-solid fa-user-doctor"></i></div>
              </div>
              <div class="card-content">
                <h3 class="font-serif">Prescrição Médica</h3>
                <p>Aprenda a indicar e acompanhar tratamentos com Cannabis Medicinal.</p>
                <a href="<?php echo esc_url(home_url('/course-detail')); ?>" class="saiba-mais-btn">SAIBA MAIS &rarr;</a>
              </div>
            </div>

            <div class="formation-card">
              <div class="card-img-holder">
                <img src="https://images.unsplash.com/photo-1576201836106-db1758fd1c97?auto=format&fit=crop&w=600&q=80" alt="Prescrição Veterinária">
                <div class="card-badge-icon"><i class="fa-solid fa-paw"></i></div>
              </div>
              <div class="card-content">
                <h3 class="font-serif">Prescrição Veterinária</h3>
                <p>Formação completa para veterinários na prescrição canabinoide.</p>
                <a href="<?php echo esc_url(home_url('/course-detail-vet')); ?>" class="saiba-mais-btn">SAIBA MAIS &rarr;</a>
              </div>
            </div>

            <div class="formation-card">
              <div class="card-img-holder">
                <img src="https://images.unsplash.com/photo-1582750433449-648ed127bb54?auto=format&fit=crop&w=600&q=80" alt="Cannabis na Rotina">
                <div class="card-badge-icon"><i class="fa-solid fa-briefcase-medical"></i></div>
              </div>
              <div class="card-content">
                <h3 class="font-serif">Cannabis na Rotina Profissional</h3>
                <p>Integração da Cannabis Medicinal na prática clínica multiprofissional.</p>
                <a href="<?php echo esc_url(home_url('/course-detail')); ?>" class="saiba-mais-btn">SAIBA MAIS &rarr;</a>
              </div>
            </div>
            <?php
          endif;
          ?>

        </div>
      </div>
    </div>
  </section>

  <!-- Fazenda Experimental Section -->
  <section class="fazenda-section-home">
    <div class="container fazenda-home-grid">
      <div class="fazenda-img-box">
        <img src="https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?auto=format&fit=crop&w=1000&q=80" alt="Estufa de cultivo de Cannabis na Fazenda Sofia Langenbach" class="fazenda-home-main-img">
      </div>
      <div class="fazenda-text-card">
        <div class="section-badge">CONHEÇA NOSSA</div>
        <h2 class="font-serif">Fazenda Experimental</h2>
        <p>
          A maior fazenda de Cannabis Medicinal do Brasil. Estrutura completa de cultivo, processamento, pesquisa e desenvolvimento com os mais altos padrões de qualidade.
        </p>
        <a href="<?php echo esc_url(home_url('/fazenda')); ?>" class="btn btn-primary">CONHEÇA A FAZENDA &rarr;</a>
      </div>
    </div>
  </section>

  <!-- Diferenciais Section -->
  <section class="diferenciais-section-home">
    <div class="container">
      <h2 class="diferenciais-title font-serif">O que torna a APEPI diferente?</h2>
      <div class="diferenciais-grid">
        <div class="diferencial-card">
          <div class="dif-icon-holder"><i class="fa-solid fa-seedling"></i></div>
          <h3>Fazenda Experimental</h3>
          <p>Vivência prática em uma das maiores estruturas de cultivo de Cannabis Medicinal do Brasil.</p>
        </div>
        <div class="diferencial-card">
          <div class="dif-icon-holder"><i class="fa-solid fa-users"></i></div>
          <h3>Corpo Docente</h3>
          <p>Professores reconhecidos nacionalmente com experiência acadêmica e clínica.</p>
        </div>
        <div class="diferencial-card">
          <div class="dif-icon-holder"><i class="fa-solid fa-notes-medical"></i></div>
          <h3>Casos Clínicos Reais</h3>
          <p>Aprendizagem baseada em prática clínica e acompanhamento de pacientes.</p>
        </div>
        <div class="diferencial-card">
          <div class="dif-icon-holder"><i class="fa-solid fa-book-open"></i></div>
          <h3>Educação Baseada em Evidências</h3>
          <p>Conteúdo científico atualizado e alinhado às melhores evidências internacionais.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Professores Section (Loop Dinâmico do CPT Professor com Fallback) -->
  <section class="professores-section-home">
    <div class="container">
      <div class="professores-header">
        <div>
          <div class="section-badge">NOSSOS PROFESSORES</div>
          <h2 class="font-serif">Referência em Cannabis Medicinal</h2>
        </div>
        <a href="<?php echo esc_url(home_url('/quem-somos')); ?>" class="view-all-link">VER TODOS OS PROFESSORES &rarr;</a>
      </div>

      <div class="professores-grid">
        <?php
        $args_prof = array(
          'post_type'      => array('professor', 'professores', 'jet-engine-professor', 'teacher', 'docente'),
          'posts_per_page' => 10,
          'post_status'    => 'publish',
        );
        $query_prof = new WP_Query($args_prof);

        if ($query_prof->have_posts()) :
          while ($query_prof->have_posts()) : $query_prof->the_post();
            $prof_id       = get_the_ID();
            $especialidade = apepi_get_professor_cargo($prof_id);
            $crm           = apepi_get_professor_crm($prof_id);
            $thumb         = apepi_get_professor_image_url($prof_id);
            ?>
            <div class="professor-card">
              <div class="prof-img-holder">
                <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>">
              </div>
              <div class="prof-info">
                <h3><?php the_title(); ?></h3>
                <?php if ($especialidade) : ?><p class="prof-sub"><?php echo esc_html($especialidade); ?></p><?php endif; ?>
                <?php if ($crm) : ?><p class="prof-crm"><?php echo esc_html($crm); ?></p><?php endif; ?>
              </div>
            </div>
            <?php
          endwhile;
          wp_reset_postdata();
        else :
          // Fallback de demonstração
          ?>
          <div class="professor-card">
            <div class="prof-img-holder">
              <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=500&q=80" alt="Dr. Pedro da Costa Mello Neto">
            </div>
            <div class="prof-info">
              <h3>Dr. Pedro da Costa Mello Neto</h3>
              <p class="prof-sub">Médico</p>
              <p class="prof-crm">CRM 52 011296-4</p>
            </div>
          </div>

          <div class="professor-card">
            <div class="prof-img-holder">
              <img src="https://images.unsplash.com/photo-1651008376811-b90baee60c1f?auto=format&fit=crop&w=500&q=80" alt="Dra. Aline Barros">
            </div>
            <div class="prof-info">
              <h3>Dra. Aline Barros</h3>
              <p class="prof-sub">Médica • Psiquiatra</p>
              <p class="prof-crm">CRM 52 60737-4</p>
            </div>
          </div>

          <div class="professor-card">
            <div class="prof-img-holder">
              <img src="https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=500&q=80" alt="Dr. Carlos Zimmer Jr.">
            </div>
            <div class="prof-info">
              <h3>Dr. Carlos Zimmer Jr.</h3>
              <p class="prof-sub">Médico • Anestesiologista</p>
              <p class="prof-crm">CRM 52 34188-8</p>
            </div>
          </div>
          <?php
        endif;
        ?>
      </div>
    </div>
  </section>

  <!-- Depoimentos Section (Loop Dinâmico do CPT Depoimento com Fallback) -->
  <section class="depoimentos-section-home">
    <div class="container">
      <div class="depoimentos-header">
        <div>
          <div class="section-badge">DEPOIMENTOS</div>
          <h2 class="font-serif">O que dizem os nossos alunos</h2>
        </div>
        <a href="#cursos" class="view-all-link">VER TODOS OS DEPOIMENTOS &rarr;</a>
      </div>

      <div class="depoimentos-grid">
        <?php
        $args_dep = array(
          'post_type'      => 'depoimento',
          'posts_per_page' => 4,
          'post_status'    => 'publish',
        );
        $query_dep = new WP_Query($args_dep);

        if ($query_dep->have_posts()) :
          while ($query_dep->have_posts()) : $query_dep->the_post();
            $cargo = get_post_meta(get_the_ID(), '_depoimento_cargo', true);
            $thumb = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium') : 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=600&q=80';
            ?>
            <div class="depoimento-video-card">
              <div class="video-thumbnail-box">
                <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>">
                <button class="video-play-btn" aria-label="Play video"><i class="fa-solid fa-circle-play"></i></button>
              </div>
              <div class="video-card-info">
                <h3><?php the_title(); ?></h3>
                <?php if ($cargo) : ?><p><?php echo esc_html($cargo); ?></p><?php endif; ?>
              </div>
            </div>
            <?php
          endwhile;
          wp_reset_postdata();
        else :
          // Fallback de demonstração
          ?>
          <div class="depoimento-video-card">
            <div class="video-thumbnail-box">
              <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=600&q=80" alt="Dra. Camila Toledo">
              <button class="video-play-btn" aria-label="Play video"><i class="fa-solid fa-circle-play"></i></button>
            </div>
            <div class="video-card-info">
              <h3>Dra. Camila Toledo</h3>
              <p>Médica Veterinária</p>
            </div>
          </div>

          <div class="depoimento-video-card">
            <div class="video-thumbnail-box">
              <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=600&q=80" alt="Dr. Eduardo Ramos">
              <button class="video-play-btn" aria-label="Play video"><i class="fa-solid fa-circle-play"></i></button>
            </div>
            <div class="video-card-info">
              <h3>Dr. Eduardo Ramos</h3>
              <p>Médico Neurologista</p>
            </div>
          </div>
          <?php
        endif;
        ?>
      </div>
    </div>
  </section>

<?php
get_footer();
