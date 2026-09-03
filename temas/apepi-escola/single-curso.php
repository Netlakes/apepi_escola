<?php
/**
 * Template Name: Detalhe do Curso (Single Curso - Elementor & Modelo Page 2)
 * Author: Netlagos Consulting
 */

get_header();

$post_id = get_the_ID();

// Verifica se a página do curso está configurada/editada via Elementor
$is_elementor = false;
if (class_exists('\Elementor\Plugin')) {
    $is_elementor = \Elementor\Plugin::$instance->db->is_built_with_elementor($post_id);
}
if (!$is_elementor && get_post_meta($post_id, '_elementor_edit_mode', true) === 'builder') {
    $is_elementor = true;
}

if ($is_elementor) :
?>

<!-- Elementor Canvas / Full Width Rendering Wrapper -->
<main id="primary" class="site-main elementor-course-wrapper" style="width: 100%; min-height: 50vh;">
  <?php
  while (have_posts()) : the_post();
    the_content();
  endwhile;
  ?>
</main>

<?php
else :
  // Renderiza o Layout de Alta Fidelidade (Modelo Page 2) quando não editado pelo Elementor
  $wa_num_global    = apepi_get_option('apepi_whatsapp_number', '5521979570000');
  
  if (have_posts()) : while (have_posts()) : the_post();
    $hero_img         = apepi_get_course_hero_image($post_id);
    
    // Metadados dinâmicos (Tema + JetEngine)
    $badge_categoria  = apepi_get_course_meta($post_id, 'badge_categoria', 'FORMAÇÃO COMPLETA PARA MÉDICOS');
    $subtitulo        = apepi_get_course_meta($post_id, 'subtitulo', 'Único curso que proporciona uma experiência prática com visita guiada à Fazenda de Cannabis Medicinal da APEPI.');
    $proxima_turma    = apepi_get_course_meta($post_id, 'proxima_turma', 'Setembro/2025');
    $carga_horaria    = apepi_get_course_meta($post_id, 'carga_horaria', '100 horas');
    $duracao          = apepi_get_course_meta($post_id, 'duracao', '3 meses');
    $modalidade       = apepi_get_course_meta($post_id, 'modalidade', 'Online ao vivo');
    $link_inscricao   = apepi_get_course_meta($post_id, 'link_inscricao', '#inscricao');
    $wa_consultor     = apepi_get_course_meta($post_id, 'wa_consultor', $wa_num_global);

    $aprender_raw     = apepi_get_course_meta($post_id, 'voce_vai_aprender', '');
    $dif_titulo       = apepi_get_course_meta($post_id, 'dif_titulo', 'Visita à Fazenda Experimental');
    $dif_desc         = apepi_get_course_meta($post_id, 'dif_desc', 'Experiência prática e imersiva na Fazenda de Cannabis Medicinal da APEPI.');
    $dif_topicos_raw  = apepi_get_course_meta($post_id, 'dif_topicos', '');
    $dif_imagem       = apepi_get_course_meta($post_id, 'dif_imagem', 'https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?auto=format&fit=crop&w=800&q=80');
    $dif_link         = apepi_get_course_meta($post_id, 'dif_link', home_url('/fazenda'));

    $modulos_raw      = apepi_get_course_meta($post_id, 'modulos', '');
  ?>

  <!-- 1. Hero Topo do Curso (Configurações Idênticas ao Hero da Home) -->
  <section class="hero-home hero-banner-degrade">
    <div class="hero-bg-wrapper">
      <img src="<?php echo esc_url($hero_img); ?>" alt="<?php the_title_attribute(); ?>" class="hero-bg-img">
      <div class="hero-gradient-overlay"></div>
    </div>

    <div class="container hero-grid">
      <div class="hero-text">
        <span class="hero-pre-title"><?php echo esc_html($badge_categoria); ?></span>
        <h1 class="font-serif hero-title"><?php the_title(); ?></h1>
        <p class="hero-desc"><?php echo esc_html($subtitulo); ?></p>
        
        <div class="hero-features-strip">
          <div class="h-feature-item">
            <div class="h-feature-icon"><i class="fa-solid fa-display"></i></div>
            <div class="h-feature-text">
              <strong>100% online</strong>
              <span>ao vivo</span>
            </div>
          </div>
          <div class="h-feature-item">
            <div class="h-feature-icon"><i class="fa-solid fa-certificate"></i></div>
            <div class="h-feature-text">
              <strong>Certificado</strong>
              <span>de conclusão</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Floating Glass Card Right (Fidelidade Absoluta com o Hero da Home) -->
      <div class="hero-floating-card-wrapper">
        <div class="hero-floating-card">
          <ul class="card-benefits-list">
            <li>
              <div class="b-icon"><i class="fa-regular fa-calendar-check"></i></div>
              <div class="b-text">
                <span>Próxima turma</span>
                <strong><?php echo esc_html($proxima_turma); ?></strong>
              </div>
            </li>
            <li>
              <div class="b-icon"><i class="fa-regular fa-clock"></i></div>
              <div class="b-text">
                <span>Carga horária</span>
                <strong><?php echo esc_html($carga_horaria); ?></strong>
              </div>
            </li>
            <li>
              <div class="b-icon"><i class="fa-solid fa-hourglass-half"></i></div>
              <div class="b-text">
                <span>Duração</span>
                <strong><?php echo esc_html($duracao); ?></strong>
              </div>
            </li>
            <li>
              <div class="b-icon"><i class="fa-solid fa-desktop"></i></div>
              <div class="b-text">
                <span>Modalidade</span>
                <strong><?php echo esc_html($modalidade); ?></strong>
              </div>
            </li>
          </ul>

          <a href="<?php echo esc_url($link_inscricao); ?>" target="_blank" class="btn btn-primary btn-block btn-hero-cta">
            QUERO ME INSCREVER
          </a>

          <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $wa_consultor)); ?>" target="_blank" class="hero-card-whatsapp">
            <i class="fa-brands fa-whatsapp"></i> Falar com um consultor
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- 2. Feature Bar (Faixa de Ícones - 5 itens) -->
  <section class="p2-feature-bar-section">
    <div class="container">
      <div class="p2-feature-bar-grid">
        <div class="p2-fb-item">
          <i class="fa-solid fa-circle-play"></i>
          <span>Aulas gravadas<br>disponíveis</span>
        </div>
        <div class="p2-fb-item">
          <i class="fa-solid fa-book-open"></i>
          <span>Material didático<br>completo</span>
        </div>
        <div class="p2-fb-item">
          <i class="fa-solid fa-user-doctor"></i>
          <span>Suporte com<br>especialistas</span>
        </div>
        <div class="p2-fb-item">
          <i class="fa-solid fa-people-group"></i>
          <span>Discussões de<br>casos clínicos</span>
        </div>
        <div class="p2-fb-item">
          <i class="fa-solid fa-clipboard-check"></i>
          <span>Certificado de<br>conclusão</span>
        </div>
      </div>
    </div>
  </section>

  <!-- 3. Section Main Info (3 Colunas: SOBRE O CURSO | VOCÊ VAI APRENDER | DIFERENCIAL EXCLUSIVO) -->
  <section class="p2-main-info-section">
    <div class="container">
      <div class="p2-main-info-grid">
        
        <!-- Coluna 1: SOBRE O CURSO -->
        <div class="p2-col-sobre">
          <div class="p2-col-title-badge">SOBRE O CURSO</div>
          <div class="p2-sobre-text entry-content">
            <?php the_content(); ?>
          </div>
        </div>

        <!-- Coluna 2: VOCÊ VAI APRENDER -->
        <div class="p2-col-aprender">
          <div class="p2-col-title-badge">VOCÊ VAI APRENDER</div>
          <ul class="p2-aprender-list">
            <?php
            if (!empty($aprender_raw)) :
              $aprender_lines = explode("\n", trim($aprender_raw));
              foreach ($aprender_lines as $aline) :
                $aline = trim($aline);
                if (empty($aline)) continue;
                echo '<li><i class="fa-regular fa-circle-check"></i> <span>' . esc_html($aline) . '</span></li>';
              endforeach;
            else :
              ?>
              <li><i class="fa-regular fa-circle-check"></i> <span>Fundamentos da Cannabis e do Sistema Endocanabinoide</span></li>
              <li><i class="fa-regular fa-circle-check"></i> <span>Indicações terapêuticas e evidências científicas</span></li>
              <li><i class="fa-regular fa-circle-check"></i> <span>Legislação, ética e responsabilidades do prescritor</span></li>
              <li><i class="fa-regular fa-circle-check"></i> <span>Formas farmacêuticas, doses e vias de administração</span></li>
              <li><i class="fa-regular fa-circle-check"></i> <span>Avaliação do paciente e tomada de decisão clínica</span></li>
              <li><i class="fa-regular fa-circle-check"></i> <span>Monitoramento, ajustes e manejo de efeitos adversos</span></li>
              <li><i class="fa-regular fa-circle-check"></i> <span>Casos clínicos reais e discussões práticas</span></li>
              <?php
            endif;
            ?>
          </ul>
        </div>

        <!-- Coluna 3: DIFERENCIAL EXCLUSIVO (Card Creme / Fazenda) -->
        <div class="p2-col-diferencial">
          <div class="p2-diferencial-card">
            <div class="p2-dif-badge">DIFERENCIAL EXCLUSIVO</div>
            <h3 class="font-serif p2-dif-title"><?php echo esc_html($dif_titulo); ?></h3>
            <p class="p2-dif-desc"><?php echo esc_html($dif_desc); ?></p>
            <ul class="p2-dif-list">
              <?php
              if (!empty($dif_topicos_raw)) :
                $dif_lines = explode("\n", trim($dif_topicos_raw));
                foreach ($dif_lines as $dline) :
                  $dline = trim($dline);
                  if (empty($dline)) continue;
                  echo '<li><i class="fa-regular fa-circle-check"></i> <span>' . esc_html($dline) . '</span></li>';
                endforeach;
              else :
                ?>
                <li><i class="fa-regular fa-circle-check"></i> <span>Conheça de perto o cultivo e o processo produtivo</span></li>
                <li><i class="fa-regular fa-circle-check"></i> <span>Entenda os padrões de qualidade e boas práticas</span></li>
                <li><i class="fa-regular fa-circle-check"></i> <span>Vivencie uma experiência que conecta teoria e prática</span></li>
                <?php
              endif;
              ?>
            </ul>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- 4. Conteúdo Programático + Card da Fazenda -->
  <section class="p2-programmatic-fazenda-section">
    <div class="container">
      <div class="p2-pf-grid">
        
        <!-- Lado Esquerdo: CONTEÚDO PROGRAMÁTICO (Accordions) -->
        <div class="p2-programmatic-col">
          <div class="p2-col-title-badge">CONTEÚDO PROGRAMÁTICO</div>
          
          <div class="p2-accordion-container">
            <?php
            if (!empty($modulos_raw)) :
              $lines = explode("\n", trim($modulos_raw));
              $index = 0;
              foreach ($lines as $line) :
                $line = trim($line);
                if (empty($line)) continue;
                $parts = explode('|', $line);
                $title = isset($parts[0]) ? trim($parts[0]) : '';
                $desc  = isset($parts[1]) ? trim($parts[1]) : '';
                $active = ($index === 0) ? 'active' : '';
                $index++;
                ?>
                <div class="p2-accordion-item <?php echo $active; ?>">
                  <button class="p2-accordion-trigger">
                    <div class="p2-acc-title-group">
                      <div class="p2-acc-icon"><i class="fa-solid fa-leaf"></i></div>
                      <div class="p2-acc-text">
                        <strong><?php echo esc_html($title); ?></strong>
                        <?php if ($desc) : ?><small><?php echo esc_html($desc); ?></small><?php endif; ?>
                      </div>
                    </div>
                    <span class="p2-acc-toggle-icon"><?php echo ($active ? '-' : '+'); ?></span>
                  </button>
                  <div class="p2-accordion-panel" style="<?php echo ($active ? 'display: block;' : 'display: none;'); ?>">
                    <p><?php echo esc_html($desc ? $desc : $title); ?></p>
                  </div>
                </div>
                <?php
              endforeach;
            else :
              ?>
              <div class="p2-accordion-item active">
                <button class="p2-accordion-trigger">
                  <div class="p2-acc-title-group">
                    <div class="p2-acc-icon"><i class="fa-solid fa-leaf"></i></div>
                    <div class="p2-acc-text">
                      <strong>Módulo 1 – Fundamentos da Cannabis Medicinal</strong>
                      <small>História, legislação, Sistema Endocanabinoide e fitocanabinoides.</small>
                    </div>
                  </div>
                  <span class="p2-acc-toggle-icon">-</span>
                </button>
                <div class="p2-accordion-panel" style="display: block;">
                  <p>História, legislação, Sistema Endocanabinoide e fitocanabinoides em profundidade para conduta médica segura.</p>
                </div>
              </div>

              <div class="p2-accordion-item">
                <button class="p2-accordion-trigger">
                  <div class="p2-acc-title-group">
                    <div class="p2-acc-icon"><i class="fa-solid fa-user-doctor"></i></div>
                    <div class="p2-acc-text">
                      <strong>Módulo 2 – Evidências e Indicações Terapêuticas</strong>
                      <small>Revisão das principais condições clínicas e estudos científicos.</small>
                    </div>
                  </div>
                  <span class="p2-acc-toggle-icon">+</span>
                </button>
                <div class="p2-accordion-panel" style="display: none;">
                  <p>Revisão das principais condições clínicas e estudos científicos aplicados a casos reais.</p>
                </div>
              </div>

              <div class="p2-accordion-item">
                <button class="p2-accordion-trigger">
                  <div class="p2-acc-title-group">
                    <div class="p2-acc-icon"><i class="fa-solid fa-flask"></i></div>
                    <div class="p2-acc-text">
                      <strong>Módulo 3 – Farmacologia e Formas de Uso</strong>
                      <small>Produtos disponíveis, doses, vias de administração e interações.</small>
                    </div>
                  </div>
                  <span class="p2-acc-toggle-icon">+</span>
                </button>
                <div class="p2-accordion-panel" style="display: none;">
                  <p>Produtos disponíveis, doses, vias de administração e interações medicamentosas.</p>
                </div>
              </div>

              <div class="p2-accordion-item">
                <button class="p2-accordion-trigger">
                  <div class="p2-acc-title-group">
                    <div class="p2-acc-icon"><i class="fa-solid fa-stethoscope"></i></div>
                    <div class="p2-acc-text">
                      <strong>Módulo 4 – Prática da Prescrição</strong>
                      <small>Avaliação do paciente, escolha terapêutica e acompanhamento.</small>
                    </div>
                  </div>
                  <span class="p2-acc-toggle-icon">+</span>
                </button>
                <div class="p2-accordion-panel" style="display: none;">
                  <p>Avaliação do paciente, escolha terapêutica e acompanhamento contínuo do tratamento.</p>
                </div>
              </div>

              <div class="p2-accordion-item">
                <button class="p2-accordion-trigger">
                  <div class="p2-acc-title-group">
                    <div class="p2-acc-icon"><i class="fa-solid fa-comments"></i></div>
                    <div class="p2-acc-text">
                      <strong>Módulo 5 – Casos Clínicos e Discussões</strong>
                      <small>Análise de casos reais com especialistas da área.</small>
                    </div>
                  </div>
                  <span class="p2-acc-toggle-icon">+</span>
                </button>
                <div class="p2-accordion-panel" style="display: none;">
                  <p>Análise de casos reais com especialistas da área e mentoria ao vivo.</p>
                </div>
              </div>
              <?php
            endif;
            ?>
          </div>
        </div>

        <!-- Lado Direito: Imagem da Fazenda + Botão -->
        <div class="p2-fazenda-card-col">
          <div class="p2-fazenda-img-box">
            <img src="<?php echo esc_url($dif_imagem); ?>" alt="Fazenda de Cannabis Medicinal da APEPI" class="p2-fazenda-img">
          </div>
          <a href="<?php echo esc_url($dif_link); ?>" class="btn btn-primary btn-block p2-btn-fazenda">
            CONHEÇA NOSSA FAZENDA &rarr;
          </a>
        </div>

      </div>
    </div>
  </section>

  <!-- 5. Corpo Docente (Professores) -->
  <section class="p2-professores-section">
    <div class="container">
      <div class="p2-col-title-badge">CORPO DOCENTE</div>
      
      <div class="p2-professores-grid">
        <?php
        $args_profs = array(
          'post_type'      => array('professor', 'professores', 'jet-engine-professor', 'teacher', 'docente'),
          'posts_per_page' => 10,
          'post_status'    => 'publish',
        );
        $query_profs = new WP_Query($args_profs);

        if ($query_profs->have_posts()) :
          while ($query_profs->have_posts()) : $query_profs->the_post();
            $prof_id = get_the_ID();
            $p_thumb = apepi_get_professor_image_url($prof_id);
            $p_cargo = apepi_get_professor_cargo($prof_id);
            $p_crm   = apepi_get_professor_crm($prof_id);
            ?>
            <div class="p2-prof-card">
              <div class="p2-prof-avatar">
                <img src="<?php echo esc_url($p_thumb); ?>" alt="<?php the_title_attribute(); ?>">
              </div>
              <h4 class="p2-prof-name"><?php the_title(); ?></h4>
              <p class="p2-prof-role"><?php echo esc_html($p_cargo); ?></p>
              <p class="p2-prof-crm"><?php echo esc_html($p_crm); ?></p>
            </div>
            <?php
          endwhile;
          wp_reset_postdata();
        else :
          // Fallback de demonstração idêntico à imagem page_2.png
          ?>
          <div class="p2-prof-card">
            <div class="p2-prof-avatar"><img src="https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=300&q=80" alt="Dr. Pedro da Costa Mello Neto"></div>
            <h4 class="p2-prof-name">Dr. Pedro da Costa Mello Neto</h4>
            <p class="p2-prof-role">Médico</p>
            <p class="p2-prof-crm">CRM 52 011296-4</p>
          </div>

          <div class="p2-prof-card">
            <div class="p2-prof-avatar"><img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=300&q=80" alt="Dra. Aline Barros"></div>
            <h4 class="p2-prof-name">Dra. Aline Barros</h4>
            <p class="p2-prof-role">Médica • Psiquiatra</p>
            <p class="p2-prof-crm">CRM 52 60737-4</p>
          </div>

          <div class="p2-prof-card">
            <div class="p2-prof-avatar"><img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=300&q=80" alt="Dr. Carlos Zimmer Jr."></div>
            <h4 class="p2-prof-name">Dr. Carlos Zimmer Jr.</h4>
            <p class="p2-prof-role">Médico • Anestesiologista</p>
            <p class="p2-prof-crm">CRM 52 34188-8</p>
          </div>

          <div class="p2-prof-card">
            <div class="p2-prof-avatar"><img src="https://images.unsplash.com/photo-1594824813566-88855ce78907?auto=format&fit=crop&w=300&q=80" alt="Dra. Patricia Moreira"></div>
            <h4 class="p2-prof-name">Dra. Patricia Moreira</h4>
            <p class="p2-prof-role">Médica Veterinária</p>
            <p class="p2-prof-crm">CRMV-RJ 12 345</p>
          </div>

          <div class="p2-prof-card">
            <div class="p2-prof-avatar"><img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=300&q=80" alt="Dr. Victor Vilhena Barroso"></div>
            <h4 class="p2-prof-name">Dr. Victor Vilhena Barroso</h4>
            <p class="p2-prof-role">Médico</p>
            <p class="p2-prof-crm">CRM 52 81058-2</p>
          </div>
          <?php
        endif;
        ?>

        <!-- 6th Card: Ver Todos -->
        <a href="<?php echo esc_url(home_url('/#professores')); ?>" class="p2-prof-card p2-prof-card-more">
          <div class="p2-prof-more-icon"><i class="fa-solid fa-users"></i></div>
          <h4 class="p2-prof-name">Veja todos os professores</h4>
          <span class="p2-prof-more-arrow">&rarr;</span>
        </a>

      </div>
    </div>
  </section>

  <!-- 6. Bottom Banner CTA -->
  <section class="p2-bottom-cta-banner">
    <div class="container p2-bottom-cta-container">
      <div class="p2-bottom-cta-left">
        <div class="p2-bcta-icon"><i class="fa-solid fa-graduation-cap"></i></div>
        <p class="p2-bcta-text">Invista no conhecimento que transforma sua prática e oferece o melhor para seus pacientes.</p>
      </div>
      <a href="<?php echo esc_url($link_inscricao); ?>" target="_blank" class="btn btn-primary p2-btn-bcta">
        QUERO ME INSCREVER &rarr;
      </a>
    </div>
  </section>

  <script>
  jQuery(document).ready(function($){
    $('.p2-accordion-trigger').click(function(){
      var item = $(this).closest('.p2-accordion-item');
      var panel = item.find('.p2-accordion-panel');
      var toggleIcon = item.find('.p2-acc-toggle-icon');

      if (item.hasClass('active')) {
        item.removeClass('active');
        panel.slideUp(200);
        toggleIcon.text('+');
      } else {
        $('.p2-accordion-item').removeClass('active');
        $('.p2-accordion-panel').slideUp(200);
        $('.p2-acc-toggle-icon').text('+');

        item.addClass('active');
        panel.slideDown(200);
        toggleIcon.text('-');
      }
    });
  });
  </script>

  <?php endwhile; endif; ?>
<?php endif; ?>

<?php
get_footer();
