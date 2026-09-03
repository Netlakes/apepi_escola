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
$hero_bg_img    = apepi_get_option('apepi_hero_bg_image', get_template_directory_uri() . '/assets/home_hero_photo.png');
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
          <h2 class="section-main-title">FORMAÇÕES</h2>
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
                  <h3 class=""><?php the_title(); ?></h3>
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
                <h3 class="">Prescrição Médica</h3>
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
                <h3 class="">Prescrição Veterinária</h3>
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
                <h3 class="">Cannabis na Rotina Profissional</h3>
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
        <h2 class="">Fazenda Experimental</h2>
        <p>
          A maior fazenda de Cannabis Medicinal do Brasil. Estrutura completa de cultivo, processamento, pesquisa e desenvolvimento com os mais altos padrões de qualidade.
        </p>
        <a href="<?php echo esc_url(home_url('/fazenda')); ?>" class="btn btn-primary">CONHEÇA A FAZENDA &rarr;</a>
      </div>
    </div>
  </section>

  <!-- E-Books Gratuitos Section -->
  <section class="ebooks-section-home" id="ebooks">
    <div class="container">
      <div class="ebooks-header">
        <div class="section-badge">CONHECIMENTO PARA SUA PRÁTICA</div>
        <h2 class="ebooks-main-title">5 E-BOOKS GRATUITOS</h2>
        <p class="ebooks-subtitle">Conteúdos exclusivos para aprofundar seus conhecimentos em Cannabis Medicinal.</p>
        <p class="ebooks-cta-text"><strong>Escolha um e-book e baixe gratuitamente.</strong></p>
      </div>

      <div class="ebooks-grid">

        <!-- Ebook 1 -->
        <div class="ebook-card">
          <div class="ebook-cover-holder">
            <img src="https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?auto=format&fit=crop&w=400&q=80" alt="Cannabis e a Vida">
            <div class="ebook-cover-overlay">
              <span class="ebook-cover-title">CANNABIS<br>E A VIDA</span>
            </div>
          </div>
          <div class="ebook-card-body">
            <h3>Cannabis e a vida</h3>
            <p>Entenda a Cannabis Medicinal e sua relação com saúde, bem-estar e qualidade de vida.</p>
            <a href="#" class="ebook-download-link">BAIXAR E-BOOK &nbsp;&rarr;</a>
          </div>
        </div>

        <!-- Ebook 2 -->
        <div class="ebook-card">
          <div class="ebook-cover-holder">
            <img src="https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?auto=format&fit=crop&w=400&q=80" alt="Médicos Prescritores">
            <div class="ebook-cover-overlay">
              <span class="ebook-cover-title">MÉDICOS<br>PRESCRITORES</span>
            </div>
          </div>
          <div class="ebook-card-body">
            <h3>Médicos prescritores</h3>
            <p>Um guia completo sobre a prescrição de Cannabis Medicinal na prática clínica.</p>
            <a href="#" class="ebook-download-link">BAIXAR E-BOOK &nbsp;&rarr;</a>
          </div>
        </div>

        <!-- Ebook 3 -->
        <div class="ebook-card">
          <div class="ebook-cover-holder">
            <img src="https://images.unsplash.com/photo-1603909223429-69bb7101f420?auto=format&fit=crop&w=400&q=80" alt="Cultivo e Extração">
            <div class="ebook-cover-overlay">
              <span class="ebook-cover-title">CULTIVO E<br>EXTRAÇÃO</span>
            </div>
          </div>
          <div class="ebook-card-body">
            <h3>Cultivo e extração</h3>
            <p>Conheça as etapas do cultivo, processamento e extração da Cannabis Medicinal.</p>
            <a href="#" class="ebook-download-link">BAIXAR E-BOOK &nbsp;&rarr;</a>
          </div>
        </div>

        <!-- Ebook 4 -->
        <div class="ebook-card">
          <div class="ebook-cover-holder">
            <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=400&q=80" alt="Rotinas do Prescritor">
            <div class="ebook-cover-overlay">
              <span class="ebook-cover-title">ROTINAS DO<br>PRESCRITOR</span>
            </div>
          </div>
          <div class="ebook-card-body">
            <h3>Rotinas do Prescritor</h3>
            <p>Ferramentas e orientações para apoiar o médico no dia a dia da prática clínica.</p>
            <a href="#" class="ebook-download-link">BAIXAR E-BOOK &nbsp;&rarr;</a>
          </div>
        </div>

        <!-- Ebook 5 -->
        <div class="ebook-card">
          <div class="ebook-cover-holder">
            <img src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?auto=format&fit=crop&w=400&q=80" alt="Vida e Saúde de Cannabis">
            <div class="ebook-cover-overlay">
              <span class="ebook-cover-title">VIDA E SAÚDE<br>DE CANNABIS</span>
            </div>
          </div>
          <div class="ebook-card-body">
            <h3>Vida e saúde de cannabis</h3>
            <p>Informação científica sobre os benefícios e possibilidades terapêuticas da Cannabis.</p>
            <a href="#" class="ebook-download-link">BAIXAR E-BOOK &nbsp;&rarr;</a>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Diferenciais Section -->
  <section class="diferenciais-section-home">
    <div class="container">
      <h2 class="diferenciais-title">O que torna a APEPI diferente?</h2>
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

<?php
get_footer();

