<?php
/**
 * APEPI Escola Theme Functions and Definitions
 * Author: Netlagos Consulting
 * URI: https://netlagos.com.br
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Configurações Iniciais do Tema
 */
function apepi_escola_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('elementor');

    // Suporte nativo ao Custom Logo do WordPress
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    register_nav_menus(array(
        'primary' => __('Menu Cabeçalho (Principal)', 'apepi-escola'),
        'footer'  => __('Menu Rodapé', 'apepi-escola'),
        'mobile'  => __('Menu Mobile', 'apepi-escola'),
    ));

    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
}
add_action('after_setup_theme', 'apepi_escola_setup');

/**
 * Registro de Sidebars / Widgets
 */
function apepi_escola_widgets_init() {
    register_sidebar(array(
        'name'          => __('Barra Lateral do Blog', 'apepi-escola'),
        'id'            => 'blog-sidebar',
        'description'   => __('Barra lateral para posts do blog e páginas.', 'apepi-escola'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'apepi_escola_widgets_init');

/**
 * Helper para obter opções do tema
 */
function apepi_get_option($key, $default = '') {
    $mod = get_theme_mod($key);
    if ($mod !== false && $mod !== '' && !is_array($mod)) {
        return $mod;
    }
    $val = get_option($key);
    if ($val !== false && $val !== '' && !is_array($val)) {
        return $val;
    }
    return $default;
}

/**
 * Helper infalível e compatível com PHP 7.x e 8.x para obter a URL da Logo
 */
function apepi_get_logo_url($type = 'light') {
    $default_file = ($type === 'dark') ? 'logo_apepi_escola_dark.png' : 'logo_apepi_escola.png';
    $default_url  = get_template_directory_uri() . '/assets/' . $default_file;
    $key          = ($type === 'dark') ? 'apepi_logo_dark' : 'apepi_logo_light';

    $val = apepi_get_option($key);

    if (empty($val) || !is_string($val)) {
        return $default_url;
    }

    // Se for ID de anexo (do Customizer Image Control)
    if (is_numeric($val)) {
        $img = wp_get_attachment_image_url((int)$val, 'full');
        return $img ? $img : $default_url;
    }

    // Se for uma URL HTTP/HTTPS válida
    if (filter_var($val, FILTER_VALIDATE_URL)) {
        return $val;
    }

    // Se não for URL absoluta válida, retorna a logo oficial do tema
    return $default_url;
}

/**
 * Enfileirar Estilos e Scripts
 */
function apepi_escola_scripts() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
    wp_enqueue_style('apepi-escola-style', get_stylesheet_uri(), array('font-awesome'), '4.2.0');
    wp_enqueue_script('apepi-escola-script', get_template_directory_uri() . '/script.js', array(), '4.2.0', true);
}
add_action('wp_enqueue_scripts', 'apepi_escola_scripts');

/**
 * Enfileirar scripts de mídia do WordPress para o Painel Admin
 */
function apepi_escola_admin_scripts($hook) {
    if (strpos($hook, 'apepi-escola') !== false || $hook === 'post.php' || $hook === 'post-new.php') {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'apepi_escola_admin_scripts');

/**
 * Página de Opções no Menu do WordPress Admin (WP Admin Sidebar)
 */
function apepi_escola_add_admin_menu() {
    add_menu_page(
        'APEPI Escola',
        'APEPI Escola',
        'manage_options',
        'apepi-escola-options',
        'apepi_escola_admin_page_callback',
        'dashicons-welcome-learn-more',
        30
    );
}
add_action('admin_menu', 'apepi_escola_add_admin_menu');

function apepi_escola_admin_page_callback() {
    if (isset($_POST['apepi_save_options']) && check_admin_referer('apepi_options_nonce_action', 'apepi_options_nonce')) {
        $fields = array(
            'apepi_logo_light', 'apepi_logo_dark',
            'apepi_whatsapp_number', 'apepi_whatsapp_text',
            'apepi_contact_email', 'apepi_contact_phone', 'apepi_contact_address',
            'apepi_social_instagram', 'apepi_social_linkedin', 'apepi_social_youtube', 'apepi_social_facebook',
            'apepi_hero_pre_title', 'apepi_hero_title', 'apepi_hero_desc', 'apepi_hero_cta_text', 'apepi_hero_cta_url', 'apepi_hero_cta2_text', 'apepi_hero_cta2_url', 'apepi_hero_bg_image',
            'apepi_stat_exp_years', 'apepi_stat_professors', 'apepi_stat_students', 'apepi_stat_states', 'apepi_stat_hours', 'apepi_stat_cases',
            'apepi_fazenda_title', 'apepi_fazenda_subtitle', 'apepi_fazenda_desc', 'apepi_fazenda_subdesc', 'apepi_fazenda_main_img',
            'apepi_fazenda_badge1', 'apepi_fazenda_badge2', 'apepi_fazenda_badge3',
            'apepi_fazenda_callout_left', 'apepi_fazenda_callout_right',
            'apepi_quemsomos_title', 'apepi_quemsomos_subtitle', 'apepi_quemsomos_desc', 'apepi_quemsomos_founders_img', 'apepi_quemsomos_speech',
            'apepi_quemsomos_missao_text', 'apepi_quemsomos_visao_text',
            'apepi_quemsomos_pilar1_img', 'apepi_quemsomos_pilar1_title', 'apepi_quemsomos_pilar1_text',
            'apepi_quemsomos_pilar2_img', 'apepi_quemsomos_pilar2_title', 'apepi_quemsomos_pilar2_text',
            'apepi_quemsomos_pilar3_img', 'apepi_quemsomos_pilar3_title', 'apepi_quemsomos_pilar3_text',
            'apepi_quemsomos_pilar4_img', 'apepi_quemsomos_pilar4_title', 'apepi_quemsomos_pilar4_text',
            'apepi_quemsomos_quote_p1', 'apepi_quemsomos_quote_p2',
            'apepi_nc_ebook_title', 'apepi_nc_ebook_subtitle', 'apepi_nc_ebook_btn', 'apepi_nc_ebook_url', 'apepi_nc_ebook_cover',
            'apepi_contato_hero_title', 'apepi_contato_hero_sub', 'apepi_contato_hero_desc',
            'apepi_contato_card1_title', 'apepi_contato_card1_desc', 'apepi_contato_card1_phone',
            'apepi_contato_card2_title', 'apepi_contato_card2_desc', 'apepi_contato_card2_phone1', 'apepi_contato_card2_phone2',
            'apepi_contato_card3_title', 'apepi_contato_card3_desc', 'apepi_contato_card3_handle', 'apepi_contato_card3_url',
            'apepi_contato_card4_title', 'apepi_contato_card4_desc', 'apepi_contato_card4_email',
            'apepi_contato_banner_text',
            'apepi_footer_copyright'
        );

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $is_textarea = in_array($field, array('apepi_hero_title', 'apepi_hero_desc', 'apepi_fazenda_desc', 'apepi_fazenda_subdesc', 'apepi_quemsomos_desc', 'apepi_quemsomos_speech', 'apepi_contato_hero_desc', 'apepi_contato_banner_text'));
                $val = $is_textarea ? sanitize_textarea_field($_POST[$field]) : sanitize_text_field($_POST[$field]);
                update_option($field, $val);
                set_theme_mod($field, $val);
            }
        }
        echo '<div class="notice notice-success is-dismissible" style="margin-top:15px;"><p><strong>Configurações salvas com sucesso no portal APEPI Escola!</strong></p></div>';
    }

    $logo_light = apepi_get_logo_url('light');
    $logo_dark  = apepi_get_logo_url('dark');
    $wa_num     = apepi_get_option('apepi_whatsapp_number', '5521979570000');
    $wa_text    = apepi_get_option('apepi_whatsapp_text', 'Atendimento via WhatsApp');
    $email      = apepi_get_option('apepi_contact_email', 'contato@apepi.com.br');
    $phone      = apepi_get_option('apepi_contact_phone', '(21) 97957-0000');
    $address    = apepi_get_option('apepi_contact_address', 'Rio de Janeiro - RJ');

    $insta      = apepi_get_option('apepi_social_instagram', '#');
    $linkedin   = apepi_get_option('apepi_social_linkedin', '#');
    $youtube    = apepi_get_option('apepi_social_youtube', '#');
    $fb         = apepi_get_option('apepi_social_facebook', '#');

    $hero_pre   = apepi_get_option('apepi_hero_pre_title', '');
    $hero_title = apepi_get_option('apepi_hero_title', "A principal Escola\nBrasileira de\nCannabis Medicinal");
    $hero_desc  = apepi_get_option('apepi_hero_desc', "Formação baseada em evidências científicas,\nprática clínica e experiências reais de cultivo\ne acompanhamento terapêutico.");
    $hero_btn   = apepi_get_option('apepi_hero_cta_text', 'CONHEÇA NOSSOS CURSOS');
    $hero_url   = apepi_get_option('apepi_hero_cta_url', '#cursos');
    $hero_btn2  = apepi_get_option('apepi_hero_cta2_text', 'CONHEÇA A FAZENDA');
    $hero_url2  = apepi_get_option('apepi_hero_cta2_url', '/fazenda');
    $hero_bg    = apepi_get_option('apepi_hero_bg_image', get_template_directory_uri() . '/assets/home_hero_photo.png');

    $stat_years  = apepi_get_option('apepi_stat_exp_years', '10 anos');
    $stat_profs  = apepi_get_option('apepi_stat_professors', '120+');
    $stat_stud   = apepi_get_option('apepi_stat_students', '6.500+');
    $stat_states = apepi_get_option('apepi_stat_states', '26');
    $stat_hours  = apepi_get_option('apepi_stat_hours', '2.400+');
    $stat_cases  = apepi_get_option('apepi_stat_cases', '1.500+');

    $fazenda_title    = apepi_get_option('apepi_fazenda_title', 'Visita à Fazenda Sofia Langenbach');
    $fazenda_subtitle = apepi_get_option('apepi_fazenda_subtitle', 'Aprendizado que nasce na prática');
    $fazenda_desc     = apepi_get_option('apepi_fazenda_desc', 'Um marco da cannabis para fins medicinais no Brasil. Acompanhe de perto todo o processo de produção dos nossos óleos — desde a germinação até a extração dos compostos da Cannabis.');
    $fazenda_subdesc  = apepi_get_option('apepi_fazenda_subdesc', 'A Fazenda Sofia Langenbach nasce do sonho de Marcos Langenbach e Margarete Brito, fundadores da APEPI, de tornar o tratamento medicinal mais acessível. Uma experiência imersiva, guiada por especialistas, para quem busca conhecimento com ciência, segurança e responsabilidade.');
    $fazenda_img      = apepi_get_option('apepi_fazenda_main_img', 'https://apepiescola.org/wp-content/uploads/2026/07/fazenda.jpg');

    $qs_title         = apepi_get_option('apepi_quemsomos_title', 'Missão e Valores');
    $qs_subtitle      = apepi_get_option('apepi_quemsomos_subtitle', 'Uma trajetória de saúde e cuidado');
    $qs_desc          = apepi_get_option('apepi_quemsomos_desc', 'A APEPI existe para transformar vidas por meio da Cannabis Medicinal, promovendo acesso, conhecimento, inovação e tratamento com qualidade e responsabilidade.');
    $qs_founders_img  = apepi_get_option('apepi_quemsomos_founders_img', 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=800&q=80');
    $qs_speech        = apepi_get_option('apepi_quemsomos_speech', 'A APEPI Escola iniciou com a ideia de Margarete Brito e Marcos Langenbach e ensinar as pessoas a cultivar seu próprio óleo.');

    $copyright   = apepi_get_option('apepi_footer_copyright', '© ' . date('Y') . ' APEPI Escola. Todos os direitos reservados.');
    ?>
    <style>
        .apepi-admin-card {
            background: #ffffff;
            border: 1px solid #ccd0d4;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .apepi-admin-card h2 {
            margin-top: 0;
            padding-bottom: 12px;
            border-bottom: 1px solid #eee;
            color: #003E19;
            font-size: 18px;
        }
        .apepi-img-preview {
            max-height: 50px;
            width: auto;
            margin-top: 10px;
            display: block;
            border: 1px solid #ddd;
            padding: 4px;
            background: #fafafa;
            border-radius: 4px;
        }
        .apepi-flex-input {
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>

    <div class="wrap">
        <h1 style="font-size:24px; font-weight:700; color:#003E19;">Painel APEPI Escola — Configurações Gerais</h1>
        <p style="font-size:14px; color:#555;">Edite os logotipos, contatos, banners e botões do portal de forma simples e imediata.</p>
        <hr style="margin-bottom:24px;">

        <form method="post" action="">
            <?php wp_nonce_field('apepi_options_nonce_action', 'apepi_options_nonce'); ?>

            <!-- 1. Identidade & Logotipos -->
            <div class="apepi-admin-card">
                <h2>1. Identidade e Logotipos Oficials</h2>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="apepi_logo_light">Logo Modo Claro</label></th>
                        <td>
                            <div class="apepi-flex-input">
                                <input type="text" id="apepi_logo_light" name="apepi_logo_light" value="<?php echo esc_attr($logo_light); ?>" class="regular-text">
                                <button type="button" class="button apepi-upload-btn">Selecionar na Galeria</button>
                            </div>
                            <img src="<?php echo esc_url($logo_light); ?>" class="apepi-img-preview" alt="Preview Logo Claro">
                            <p class="description">Logo utilizada no tema claro do site.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apepi_logo_dark">Logo Modo Escuro</label></th>
                        <td>
                            <div class="apepi-flex-input">
                                <input type="text" id="apepi_logo_dark" name="apepi_logo_dark" value="<?php echo esc_attr($logo_dark); ?>" class="regular-text">
                                <button type="button" class="button apepi-upload-btn">Selecionar na Galeria</button>
                            </div>
                            <img src="<?php echo esc_url($logo_dark); ?>" class="apepi-img-preview" style="background:#1a1a1a;" alt="Preview Logo Escuro">
                            <p class="description">Logo utilizada no tema escuro (Dark Mode).</p>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- 2. Contatos e Atendimento -->
            <div class="apepi-admin-card">
                <h2>2. Contatos e Canais de Atendimento</h2>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="apepi_whatsapp_number">Número do WhatsApp (com DDD)</label></th>
                        <td>
                            <input type="text" id="apepi_whatsapp_number" name="apepi_whatsapp_number" value="<?php echo esc_attr($wa_num); ?>" class="regular-text" placeholder="5521979570000">
                            <p class="description">Exemplo: 5521979570000 (somente números)</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apepi_whatsapp_text">Texto do Botão WhatsApp</label></th>
                        <td><input type="text" id="apepi_whatsapp_text" name="apepi_whatsapp_text" value="<?php echo esc_attr($wa_text); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apepi_contact_email">E-mail de Contato</label></th>
                        <td><input type="email" id="apepi_contact_email" name="apepi_contact_email" value="<?php echo esc_attr($email); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apepi_contact_phone">Telefone Fixo / Celular</label></th>
                        <td><input type="text" id="apepi_contact_phone" name="apepi_contact_phone" value="<?php echo esc_attr($phone); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apepi_contact_address">Cidade / Endereço</label></th>
                        <td><input type="text" id="apepi_contact_address" name="apepi_contact_address" value="<?php echo esc_attr($address); ?>" class="regular-text"></td>
                    </tr>
                </table>
            </div>

            <!-- 3. Redes Sociais -->
            <div class="apepi-admin-card">
                <h2>3. Redes Sociais</h2>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="apepi_social_instagram">Instagram (URL)</label></th>
                        <td><input type="text" id="apepi_social_instagram" name="apepi_social_instagram" value="<?php echo esc_attr($insta); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apepi_social_linkedin">LinkedIn (URL)</label></th>
                        <td><input type="text" id="apepi_social_linkedin" name="apepi_social_linkedin" value="<?php echo esc_attr($linkedin); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apepi_social_youtube">YouTube (URL)</label></th>
                        <td><input type="text" id="apepi_social_youtube" name="apepi_social_youtube" value="<?php echo esc_attr($youtube); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apepi_social_facebook">Facebook (URL)</label></th>
                        <td><input type="text" id="apepi_social_facebook" name="apepi_social_facebook" value="<?php echo esc_attr($fb); ?>" class="regular-text"></td>
                    </tr>
                </table>
            </div>

            <!-- 4. Banner Hero Página Inicial -->
            <div class="apepi-admin-card">
                <h2>4. Banner Principal (Hero) da Página Inicial</h2>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="apepi_hero_pre_title">Pré-Título</label></th>
                        <td><input type="text" id="apepi_hero_pre_title" name="apepi_hero_pre_title" value="<?php echo esc_attr($hero_pre); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apepi_hero_title">Título Principal</label></th>
                        <td><textarea id="apepi_hero_title" name="apepi_hero_title" rows="2" class="large-text"><?php echo esc_textarea($hero_title); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apepi_hero_desc">Descrição do Banner</label></th>
                        <td><textarea id="apepi_hero_desc" name="apepi_hero_desc" rows="3" class="large-text"><?php echo esc_textarea($hero_desc); ?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apepi_hero_cta_text">Texto do Botão Principal (1)</label></th>
                        <td><input type="text" id="apepi_hero_cta_text" name="apepi_hero_cta_text" value="<?php echo esc_attr($hero_btn); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apepi_hero_cta_url">Link do Botão Principal (1)</label></th>
                        <td><input type="text" id="apepi_hero_cta_url" name="apepi_hero_cta_url" value="<?php echo esc_attr($hero_url); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apepi_hero_cta2_text">Texto do Botão Secundário (2)</label></th>
                        <td><input type="text" id="apepi_hero_cta2_text" name="apepi_hero_cta2_text" value="<?php echo esc_attr($hero_btn2); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apepi_hero_cta2_url">Link do Botão Secundário (2)</label></th>
                        <td><input type="text" id="apepi_hero_cta2_url" name="apepi_hero_cta2_url" value="<?php echo esc_attr($hero_url2); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apepi_hero_bg_image">Imagem de Fundo do Banner Hero</label></th>
                        <td>
                            <div class="apepi-flex-input">
                                <input type="text" id="apepi_hero_bg_image" name="apepi_hero_bg_image" value="<?php echo esc_attr($hero_bg); ?>" class="regular-text">
                                <button type="button" class="button apepi-upload-btn">Selecionar na Galeria</button>
                            </div>
                            <img src="<?php echo esc_url($hero_bg); ?>" class="apepi-img-preview" style="max-height:80px;" alt="Preview Hero Background">
                            <p class="description">Imagem de fundo exibida no Banner Principal da Página Inicial.</p>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- 5. Estatísticas e Números -->
            <div class="apepi-admin-card">
                <h2>5. Estatísticas e Números em Destaque</h2>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="apepi_stat_exp_years">Anos de Experiência</label></th>
                        <td><input type="text" id="apepi_stat_exp_years" name="apepi_stat_exp_years" value="<?php echo esc_attr($stat_years); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apepi_stat_professors">Professores Especialistas</label></th>
                        <td><input type="text" id="apepi_stat_professors" name="apepi_stat_professors" value="<?php echo esc_attr($stat_profs); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apepi_stat_students">Alunos Capacitados</label></th>
                        <td><input type="text" id="apepi_stat_students" name="apepi_stat_students" value="<?php echo esc_attr($stat_stud); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apepi_stat_states">Estados Atendidos</label></th>
                        <td><input type="text" id="apepi_stat_states" name="apepi_stat_states" value="<?php echo esc_attr($stat_states); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apepi_stat_hours">Horas de Conteúdo</label></th>
                        <td><input type="text" id="apepi_stat_hours" name="apepi_stat_hours" value="<?php echo esc_attr($stat_hours); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="apepi_stat_cases">Casos Clínicos Discutidos</label></th>
                        <td><input type="text" id="apepi_stat_cases" name="apepi_stat_cases" value="<?php echo esc_attr($stat_cases); ?>" class="regular-text"></td>
                    </tr>
                </table>
            </div>

            <!-- 6. Rodapé e Direitos Autorais -->
            <div class="apepi-admin-card">
                <h2>6. Rodapé e Direitos Autorais</h2>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="apepi_footer_copyright">Texto de Direitos Autorais</label></th>
                        <td><input type="text" id="apepi_footer_copyright" name="apepi_footer_copyright" value="<?php echo esc_attr($copyright); ?>" class="regular-text"></td>
                    </tr>
                </table>
            </div>

            <p class="submit">
                <input type="submit" name="apepi_save_options" class="button button-primary button-hero" value="Salvar Todas as Configurações">
            </p>
        </form>
    </div>

    <script>
    jQuery(document).ready(function($){
        $('.apepi-upload-btn').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var targetInput = btn.prev('input');
            var previewImg = btn.parent().next('.apepi-img-preview');

            var customUploader = wp.media({
                title: 'Selecionar Imagem de Logotipo',
                button: { text: 'Usar esta Imagem' },
                multiple: false
            }).on('select', function() {
                var attachment = customUploader.state().get('selection').first().toJSON();
                targetInput.val(attachment.url);
                if (previewImg.length) {
                    previewImg.attr('src', attachment.url).show();
                }
            }).open();
        });
    });
    </script>
    <?php
}

/**
 * Registro de Seções Diretas no WordPress Customizer (Aparecem no Topo do Menu)
 */
function apepi_escola_customize_register($wp_customize) {
    // 1. Logotipos
    $wp_customize->add_section('apepi_logos_section', array(
        'title'       => __('APEPI - Logotipos (Claro / Escuro)', 'apepi-escola'),
        'priority'    => 1,
        'description' => __('Envie ou altere as imagens do logotipo para modo claro e escuro.', 'apepi-escola'),
    ));

    $wp_customize->add_setting('apepi_logo_light', array(
        'default'           => get_template_directory_uri() . '/assets/logo_apepi_escola.png',
        'sanitize_callback' => 'esc_url_raw',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'apepi_logo_light', array(
        'label'    => __('Logo Modo Claro', 'apepi-escola'),
        'section'  => 'apepi_logos_section',
        'settings' => 'apepi_logo_light',
    )));

    $wp_customize->add_setting('apepi_logo_dark', array(
        'default'           => get_template_directory_uri() . '/assets/logo_apepi_escola_dark.png',
        'sanitize_callback' => 'esc_url_raw',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'apepi_logo_dark', array(
        'label'    => __('Logo Modo Escuro', 'apepi-escola'),
        'section'  => 'apepi_logos_section',
        'settings' => 'apepi_logo_dark',
    )));

    // 2. Contatos & WhatsApp
    $wp_customize->add_section('apepi_contact_section', array(
        'title'    => __('APEPI - Contatos & WhatsApp', 'apepi-escola'),
        'priority' => 2,
    ));

    $wp_customize->add_setting('apepi_whatsapp_number', array(
        'default'           => '5521979570000',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_whatsapp_number', array(
        'label'    => __('Número WhatsApp (com DDD)', 'apepi-escola'),
        'section'  => 'apepi_contact_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('apepi_whatsapp_text', array(
        'default'           => 'Atendimento via WhatsApp',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_whatsapp_text', array(
        'label'    => __('Texto do Botão WhatsApp', 'apepi-escola'),
        'section'  => 'apepi_contact_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('apepi_contact_email', array(
        'default'           => 'contato@apepi.com.br',
        'sanitize_callback' => 'sanitize_email',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_contact_email', array(
        'label'    => __('E-mail de Contato', 'apepi-escola'),
        'section'  => 'apepi_contact_section',
        'type'     => 'email',
    ));

    $wp_customize->add_setting('apepi_contact_phone', array(
        'default'           => '(21) 97957-0000',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_contact_phone', array(
        'label'    => __('Telefone', 'apepi-escola'),
        'section'  => 'apepi_contact_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('apepi_contact_address', array(
        'default'           => 'Rio de Janeiro - RJ',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_contact_address', array(
        'label'    => __('Cidade / Endereço', 'apepi-escola'),
        'section'  => 'apepi_contact_section',
        'type'     => 'text',
    ));

    // 3. Banner Hero
    $wp_customize->add_section('apepi_hero_section', array(
        'title'    => __('APEPI - Banner Hero (Home)', 'apepi-escola'),
        'priority' => 3,
    ));

    $wp_customize->add_setting('apepi_hero_title', array(
        'default'           => "A principal Escola\nBrasileira de\nCannabis Medicinal",
        'sanitize_callback' => 'sanitize_textarea_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_hero_title', array(
        'label'    => __('Título Principal', 'apepi-escola'),
        'section'  => 'apepi_hero_section',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('apepi_hero_desc', array(
        'default'           => "Formação baseada em evidências científicas,\nprática clínica e experiências reais de cultivo\ne acompanhamento terapêutico.",
        'sanitize_callback' => 'sanitize_textarea_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_hero_desc', array(
        'label'    => __('Descrição do Hero', 'apepi-escola'),
        'section'  => 'apepi_hero_section',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('apepi_hero_cta_text', array(
        'default'           => 'CONHEÇA NOSSOS CURSOS',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_hero_cta_text', array(
        'label'    => __('Texto do Botão Principal (1)', 'apepi-escola'),
        'section'  => 'apepi_hero_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('apepi_hero_cta_url', array(
        'default'           => '#cursos',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_hero_cta_url', array(
        'label'    => __('Link do Botão Principal (1)', 'apepi-escola'),
        'section'  => 'apepi_hero_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('apepi_hero_cta2_text', array(
        'default'           => 'CONHEÇA A FAZENDA',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_hero_cta2_text', array(
        'label'    => __('Texto do Botão Secundário (2)', 'apepi-escola'),
        'section'  => 'apepi_hero_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('apepi_hero_cta2_url', array(
        'default'           => '/fazenda',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_hero_cta2_url', array(
        'label'    => __('Link do Botão Secundário (2)', 'apepi-escola'),
        'section'  => 'apepi_hero_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('apepi_hero_bg_image', array(
        'default'           => get_template_directory_uri() . '/assets/home_hero_photo.png',
        'sanitize_callback' => 'esc_url_raw',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'apepi_hero_bg_image', array(
        'label'    => __('Imagem de Destaque do Hero', 'apepi-escola'),
        'section'  => 'apepi_hero_section',
        'settings' => 'apepi_hero_bg_image',
    )));

    // 4. Redes Sociais
    $wp_customize->add_section('apepi_social_section', array(
        'title'    => __('APEPI - Redes Sociais', 'apepi-escola'),
        'priority' => 4,
    ));

    $wp_customize->add_setting('apepi_social_instagram', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_social_instagram', array(
        'label'    => __('Instagram URL', 'apepi-escola'),
        'section'  => 'apepi_social_section',
        'type'     => 'url',
    ));

    $wp_customize->add_setting('apepi_social_linkedin', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_social_linkedin', array(
        'label'    => __('LinkedIn URL', 'apepi-escola'),
        'section'  => 'apepi_social_section',
        'type'     => 'url',
    ));

    $wp_customize->add_setting('apepi_social_youtube', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_social_youtube', array(
        'label'    => __('YouTube URL', 'apepi-escola'),
        'section'  => 'apepi_social_section',
        'type'     => 'url',
    ));

    $wp_customize->add_setting('apepi_social_facebook', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_social_facebook', array(
        'label'    => __('Facebook URL', 'apepi-escola'),
        'section'  => 'apepi_social_section',
        'type'     => 'url',
    ));

    // 5. Estatísticas
    $wp_customize->add_section('apepi_stats_section', array(
        'title'    => __('APEPI - Estatísticas da Home', 'apepi-escola'),
        'priority' => 5,
    ));

    $wp_customize->add_setting('apepi_stat_exp_years', array(
        'default'           => '10 anos',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_stat_exp_years', array(
        'label'    => __('Anos de Experiência', 'apepi-escola'),
        'section'  => 'apepi_stats_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('apepi_stat_professors', array(
        'default'           => '120+',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_stat_professors', array(
        'label'    => __('Professores Especialistas', 'apepi-escola'),
        'section'  => 'apepi_stats_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('apepi_stat_students', array(
        'default'           => '6.500+',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_stat_students', array(
        'label'    => __('Alunos Capacitados', 'apepi-escola'),
        'section'  => 'apepi_stats_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('apepi_stat_states', array(
        'default'           => '26',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_stat_states', array(
        'label'    => __('Estados Atendidos', 'apepi-escola'),
        'section'  => 'apepi_stats_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('apepi_stat_hours', array(
        'default'           => '2.400+',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_stat_hours', array(
        'label'    => __('Horas de Conteúdo', 'apepi-escola'),
        'section'  => 'apepi_stats_section',
        'type'     => 'text',
    ));

    // 6. Página Fazenda
    $wp_customize->add_section('apepi_fazenda_section', array(
        'title'    => __('APEPI - Página Fazenda', 'apepi-escola'),
        'priority' => 6,
    ));

    $wp_customize->add_setting('apepi_fazenda_title', array(
        'default'           => 'Visita à Fazenda Sofia Langenbach',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_fazenda_title', array(
        'label'    => __('Título Principal (Hero)', 'apepi-escola'),
        'section'  => 'apepi_fazenda_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('apepi_fazenda_subtitle', array(
        'default'           => 'Aprendizado que nasce na prática',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_fazenda_subtitle', array(
        'label'    => __('Subtítulo (Hero)', 'apepi-escola'),
        'section'  => 'apepi_fazenda_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('apepi_fazenda_desc', array(
        'default'           => 'Um marco da cannabis para fins medicinais no Brasil. Acompanhe de perto todo o processo de produção dos nossos óleos — desde a germinação até a extração dos compostos da Cannabis.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_fazenda_desc', array(
        'label'    => __('Descrição do Hero', 'apepi-escola'),
        'section'  => 'apepi_fazenda_section',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('apepi_fazenda_subdesc', array(
        'default'           => 'A Fazenda Sofia Langenbach nasce do sonho de Marcos Langenbach e Margarete Brito, fundadores da APEPI, de tornar o tratamento medicinal mais acessível. Uma experiência imersiva, guiada por especialistas, para quem busca conhecimento com ciência, segurança e responsabilidade.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_fazenda_subdesc', array(
        'label'    => __('Descrição Complementar do Hero', 'apepi-escola'),
        'section'  => 'apepi_fazenda_section',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('apepi_fazenda_main_img', array(
        'default'           => 'https://apepiescola.org/wp-content/uploads/2026/07/fazenda.jpg',
        'sanitize_callback' => 'esc_url_raw',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'apepi_fazenda_main_img', array(
        'label'    => __('Imagem Principal do Hero (Fazenda)', 'apepi-escola'),
        'section'  => 'apepi_fazenda_section',
        'settings' => 'apepi_fazenda_main_img',
    )));

    // 7. Página Quem Somos
    $wp_customize->add_section('apepi_quemsomos_section', array(
        'title'    => __('APEPI - Página Quem Somos', 'apepi-escola'),
        'priority' => 7,
    ));

    $wp_customize->add_setting('apepi_quemsomos_title', array(
        'default'           => 'Missão e Valores',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_quemsomos_title', array(
        'label'    => __('Título Principal (Hero)', 'apepi-escola'),
        'section'  => 'apepi_quemsomos_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('apepi_quemsomos_subtitle', array(
        'default'           => 'Uma trajetória de saúde e cuidado',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_quemsomos_subtitle', array(
        'label'    => __('Subtítulo (Hero)', 'apepi-escola'),
        'section'  => 'apepi_quemsomos_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('apepi_quemsomos_desc', array(
        'default'           => 'A APEPI existe para transformar vidas por meio da Cannabis Medicinal, promovendo acesso, conhecimento, inovação e tratamento com qualidade e responsabilidade.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_quemsomos_desc', array(
        'label'    => __('Descrição do Hero', 'apepi-escola'),
        'section'  => 'apepi_quemsomos_section',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('apepi_quemsomos_founders_img', array(
        'default'           => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=800&q=80',
        'sanitize_callback' => 'esc_url_raw',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'apepi_quemsomos_founders_img', array(
        'label'    => __('Imagem dos Fundadores (Quem Somos)', 'apepi-escola'),
        'section'  => 'apepi_quemsomos_section',
        'settings' => 'apepi_quemsomos_founders_img',
    )));

    $wp_customize->add_setting('apepi_quemsomos_speech', array(
        'default'           => 'A APEPI Escola iniciou com a ideia de Margarete Brito e Marcos Langenbach e ensinar as pessoas a cultivar seu próprio óleo.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_quemsomos_speech', array(
        'label'    => __('Balão de Fala (Imagem dos Fundadores)', 'apepi-escola'),
        'section'  => 'apepi_quemsomos_section',
        'type'     => 'textarea',
    ));

    // ==========================================================================
    // 6. PÁGINA NOSSOS CURSOS (apepi_nossos_cursos_section)
    // ==========================================================================
    $wp_customize->add_section('apepi_nossos_cursos_section', array(
        'title'       => __('APEPI - Página "Nossos Cursos"', 'apepi-escola'),
        'priority'    => 10,
        'description' => __('Personalize os títulos, botões, números e depoimentos da página Nossos Cursos.', 'apepi-escola'),
    ));

    $wp_customize->add_setting('apepi_nc_catalog_sub', array('default' => 'NOSSO CATÁLOGO', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_catalog_sub', array('label' => __('Rótulo do Catálogo', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'text'));

    $wp_customize->add_setting('apepi_nc_main_title', array('default' => 'FORMAÇÕES', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_main_title', array('label' => __('Título Principal', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'text'));

    $wp_customize->add_setting('apepi_nc_numeros_tag', array('default' => '🌿 APEPI ESCOLA EM NÚMEROS 🌿', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_numeros_tag', array('label' => __('Tag da Seção APEPI em Números', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'text'));

    $wp_customize->add_setting('apepi_nc_num1_big', array('default' => '14 anos', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_num1_big', array('label' => __('Item 1: Valor / Destaque', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'text'));
    $wp_customize->add_setting('apepi_nc_num1_desc', array('default' => 'de experiência na educação canábica', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_num1_desc', array('label' => __('Item 1: Descrição', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'text'));

    $wp_customize->add_setting('apepi_nc_num2_big', array('default' => '+1000', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_num2_big', array('label' => __('Item 2: Valor / Destaque', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'text'));
    $wp_customize->add_setting('apepi_nc_num2_desc', array('default' => 'alunos formados e preparados para fazer a diferença', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_num2_desc', array('label' => __('Item 2: Descrição', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'text'));

    $wp_customize->add_setting('apepi_nc_num3_big', array('default' => '+10h', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_num3_big', array('label' => __('Item 3: Valor / Destaque', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'text'));
    $wp_customize->add_setting('apepi_nc_num3_sub', array('default' => 'de conteúdo', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_num3_sub', array('label' => __('Item 3: Sub-Rótulo', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'text'));
    $wp_customize->add_setting('apepi_nc_num3_desc', array('default' => 'aulas online e ao vivo com especialistas referência na área', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_num3_desc', array('label' => __('Item 3: Descrição', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'text'));

    $wp_customize->add_setting('apepi_nc_num4_title', array('default' => 'Formação completa', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_num4_title', array('label' => __('Item 4: Título', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'text'));
    $wp_customize->add_setting('apepi_nc_num4_desc', array('default' => 'da teoria à prática, com segurança e responsabilidade', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_num4_desc', array('label' => __('Item 4: Descrição', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'text'));

    $wp_customize->add_setting('apepi_nc_num5_title', array('default' => 'E-books gratuitos', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_num5_title', array('label' => __('Item 5: Título', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'text'));
    $wp_customize->add_setting('apepi_nc_num5_desc', array('default' => 'materiais exclusivos para aprofundar seu conhecimento', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_num5_desc', array('label' => __('Item 5: Descrição', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'text'));

    $wp_customize->add_setting('apepi_nc_dep_tag', array('default' => '🌿 DEPOIMENTOS 🌿', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_dep_tag', array('label' => __('Tag da Seção de Depoimentos', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'text'));
    $wp_customize->add_setting('apepi_nc_dep_title', array('default' => 'O que nossos alunos dizem', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_dep_title', array('label' => __('Título dos Depoimentos', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'text'));
    $wp_customize->add_setting('apepi_nc_dep_sub', array('default' => 'Histórias reais de médicos, veterinários e profissionais que transformaram sua prática com o conhecimento em Cannabis Medicinal.', 'sanitize_callback' => 'sanitize_textarea_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_dep_sub', array('label' => __('Subtítulo dos Depoimentos', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'textarea'));

    $wp_customize->add_setting('apepi_nc_ebook_title', array('default' => 'Conhecimento que vai além da sala de aula', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_ebook_title', array('label' => __('Banner E-books: Título', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'text'));
    $wp_customize->add_setting('apepi_nc_ebook_sub', array('default' => 'Acesse nossos e-books gratuitos e aprofunde ainda mais seus estudos sobre Cannabis Medicinal.', 'sanitize_callback' => 'sanitize_textarea_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_ebook_sub', array('label' => __('Banner E-books: Subtítulo', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'textarea'));
    $wp_customize->add_setting('apepi_nc_ebook_btn', array('default' => 'BAIXAR E-BOOKS GRATUITOS', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_ebook_btn', array('label' => __('Banner E-books: Texto do Botão', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'text'));
    $wp_customize->add_setting('apepi_nc_ebook_url', array('default' => '#ebooks', 'sanitize_callback' => 'esc_url_raw', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_ebook_url', array('label' => __('Banner E-books: Link do Botão', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'url'));

    $wp_customize->add_setting('apepi_nc_foot_text', array('default' => 'APEPI Escola – Transformando conhecimento em cuidado e qualidade de vida. Junte-se a mais de 1000 alunos e faça parte dessa história.', 'sanitize_callback' => 'sanitize_textarea_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_nc_foot_text', array('label' => __('Texto do Banner de Rodapé', 'apepi-escola'), 'section' => 'apepi_nossos_cursos_section', 'type' => 'textarea'));

    // ==========================================================================
    // 7. PÁGINA CONTATO (apepi_contato_section)
    // ==========================================================================
    $wp_customize->add_section('apepi_contato_section', array(
        'title'       => __('APEPI - Página "Contato"', 'apepi-escola'),
        'priority'    => 11,
        'description' => __('Personalize os textos do hero, cards de atendimento e banner da página Contato.', 'apepi-escola'),
    ));

    $wp_customize->add_setting('apepi_contato_hero_title', array('default' => 'Contato', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_contato_hero_title', array('label' => __('Hero: Título Principal', 'apepi-escola'), 'section' => 'apepi_contato_section', 'type' => 'text'));
    $wp_customize->add_setting('apepi_contato_hero_sub', array('default' => 'Fale com a APEPI Escola', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_contato_hero_sub', array('label' => __('Hero: Subtítulo', 'apepi-escola'), 'section' => 'apepi_contato_section', 'type' => 'text'));
    $wp_customize->add_setting('apepi_contato_hero_desc', array('default' => 'Nossa equipe está pronta para te atender e ajudar você a escolher o melhor caminho na formação em Cannabis Medicinal.', 'sanitize_callback' => 'sanitize_textarea_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_contato_hero_desc', array('label' => __('Hero: Descrição', 'apepi-escola'), 'section' => 'apepi_contato_section', 'type' => 'textarea'));

    $wp_customize->add_setting('apepi_contato_card1_title', array('default' => 'Fale com nossa secretaria', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_contato_card1_title', array('label' => __('Card 1: Título', 'apepi-escola'), 'section' => 'apepi_contato_section', 'type' => 'text'));
    $wp_customize->add_setting('apepi_contato_card1_desc', array('default' => 'Dúvidas sobre cursos, parcerias, documentos e outros assuntos.', 'sanitize_callback' => 'sanitize_textarea_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_contato_card1_desc', array('label' => __('Card 1: Descrição', 'apepi-escola'), 'section' => 'apepi_contato_section', 'type' => 'textarea'));
    $wp_customize->add_setting('apepi_contato_card1_phone', array('default' => '+55 21 97495-2236', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_contato_card1_phone', array('label' => __('Card 1: Telefone/WhatsApp', 'apepi-escola'), 'section' => 'apepi_contato_section', 'type' => 'text'));

    $wp_customize->add_setting('apepi_contato_card2_title', array('default' => 'Inscrição de cursos pelo WhatsApp', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_contato_card2_title', array('label' => __('Card 2: Título', 'apepi-escola'), 'section' => 'apepi_contato_section', 'type' => 'text'));
    $wp_customize->add_setting('apepi_contato_card2_desc', array('default' => 'Entre em contato com um de nossos atendentes e garanta sua vaga!', 'sanitize_callback' => 'sanitize_textarea_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_contato_card2_desc', array('label' => __('Card 2: Descrição', 'apepi-escola'), 'section' => 'apepi_contato_section', 'type' => 'textarea'));
    $wp_customize->add_setting('apepi_contato_card2_phone1', array('default' => '+55 21 96753-7633', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_contato_card2_phone1', array('label' => __('Card 2: WhatsApp 1', 'apepi-escola'), 'section' => 'apepi_contato_section', 'type' => 'text'));
    $wp_customize->add_setting('apepi_contato_card2_phone2', array('default' => '+55 21 99724-0283', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_contato_card2_phone2', array('label' => __('Card 2: WhatsApp 2', 'apepi-escola'), 'section' => 'apepi_contato_section', 'type' => 'text'));

    $wp_customize->add_setting('apepi_contato_card3_title', array('default' => 'Acompanhe no Instagram', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_contato_card3_title', array('label' => __('Card 3: Título', 'apepi-escola'), 'section' => 'apepi_contato_section', 'type' => 'text'));
    $wp_customize->add_setting('apepi_contato_card3_desc', array('default' => 'Fique por dentro das novidades, conteúdos e bastidores da APEPI Escola.', 'sanitize_callback' => 'sanitize_textarea_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_contato_card3_desc', array('label' => __('Card 3: Descrição', 'apepi-escola'), 'section' => 'apepi_contato_section', 'type' => 'textarea'));
    $wp_customize->add_setting('apepi_contato_card3_handle', array('default' => '@apepiescola', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_contato_card3_handle', array('label' => __('Card 3: Nome de Usuário', 'apepi-escola'), 'section' => 'apepi_contato_section', 'type' => 'text'));
    $wp_customize->add_setting('apepi_contato_card3_url', array('default' => 'https://instagram.com/apepiescola', 'sanitize_callback' => 'esc_url_raw', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_contato_card3_url', array('label' => __('Card 3: Link do Instagram', 'apepi-escola'), 'section' => 'apepi_contato_section', 'type' => 'url'));

    $wp_customize->add_setting('apepi_contato_card4_title', array('default' => 'Envie um e-mail', 'sanitize_callback' => 'sanitize_text_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_contato_card4_title', array('label' => __('Card 4: Título', 'apepi-escola'), 'section' => 'apepi_contato_section', 'type' => 'text'));
    $wp_customize->add_setting('apepi_contato_card4_desc', array('default' => 'Entre em contato por e-mail.', 'sanitize_callback' => 'sanitize_textarea_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_contato_card4_desc', array('label' => __('Card 4: Descrição', 'apepi-escola'), 'section' => 'apepi_contato_section', 'type' => 'textarea'));
    $wp_customize->add_setting('apepi_contato_card4_email', array('default' => 'ead@apepi.org', 'sanitize_callback' => 'sanitize_email', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_contato_card4_email', array('label' => __('Card 4: Endereço de E-mail', 'apepi-escola'), 'section' => 'apepi_contato_section', 'type' => 'email'));

    $wp_customize->add_setting('apepi_contato_banner_text', array('default' => 'Nosso compromisso é com a excelência na formação e no atendimento. Ficaremos felizes em te ajudar!', 'sanitize_callback' => 'sanitize_textarea_field', 'type' => 'theme_mod'));
    $wp_customize->add_control('apepi_contato_banner_text', array('label' => __('Banner Compromisso: Texto', 'apepi-escola'), 'section' => 'apepi_contato_section', 'type' => 'textarea'));
}
add_action('customize_register', 'apepi_escola_customize_register');

/**
 * Helper Inteligente para Puxar Metadados de Cursos (Compatível com JetEngine e Tema Nativo)
 */
function apepi_get_course_meta($post_id, $field, $default = '') {
    $mapping = array(
        'badge_categoria'  => array('_curso_badge_categoria', 'badge_categoria', 'categoria_badge', 'categoria', 'curso_badge'),
        'subtitulo'        => array('_curso_subtitulo', 'subtitulo', 'sub_titulo', 'curso_subtitulo', 'description'),
        'proxima_turma'    => array('_curso_proxima_turma', 'proxima_turma', 'turma', 'data_turma', 'start_date'),
        'carga_horaria'    => array('_curso_carga_horaria', 'carga_horaria', 'carga-horaria', 'horas', 'duration'),
        'duracao'          => array('_curso_duracao', 'duracao', 'tempo_duracao', 'meses'),
        'modalidade'       => array('_curso_modalidade', '_curso_formato', 'modalidade', 'formato', 'tipo_curso'),
        'link_inscricao'   => array('_curso_link_inscricao', 'link_inscricao', 'link_do_curso', 'url_inscricao', 'link_hotmart', 'link_sympla', 'link'),
        'wa_consultor'     => array('_curso_wa_consultor', 'wa_consultor', 'whatsapp_consultor', 'telefone_consultor'),
        'voce_vai_aprender'=> array('_curso_voce_vai_aprender', 'voce_vai_aprender', 'o_que_vai_aprender', 'conteudo_aprendizado'),
        'dif_titulo'       => array('_curso_dif_titulo', 'dif_titulo', 'diferencial_titulo', 'titulo_diferencial'),
        'dif_desc'         => array('_curso_dif_desc', 'dif_desc', 'diferencial_desc', 'descricao_diferencial'),
        'dif_topicos'      => array('_curso_dif_topicos', 'dif_topicos', 'diferencial_topicos', 'topicos_diferencial'),
        'dif_imagem'       => array('_curso_dif_imagem', 'dif_imagem', 'diferencial_imagem', 'imagem_fazenda'),
        'dif_link'         => array('_curso_dif_link', 'dif_link', 'diferencial_link', 'link_fazenda'),
        'modulos'          => array('_curso_modulos', 'modulos', 'conteudo_programatico', 'ementa'),
        'icone'            => array('_curso_icone', 'icone', 'icon', 'fa_icon'),
        'thumb_imagem'     => array('_curso_thumb_imagem', 'thumb_imagem', 'imagem_thumb', 'thumbnail', 'thumb_image', 'card_imagem'),
        'hero_imagem'      => array('_curso_hero_imagem', 'hero_imagem', 'imagem_hero', 'hero_bg', 'hero_image')
    );

    $keys_to_check = isset($mapping[$field]) ? $mapping[$field] : array($field, '_' . $field);

    foreach ($keys_to_check as $key) {
        $val = get_post_meta($post_id, $key, true);
        if (!empty($val)) {
            return $val;
        }
    }

    return $default;
}

/**
 * Helper Universal para Obter a Imagem da Thumbnail (Card) do Curso
 */
function apepi_get_course_thumb_image($post_id) {
    if (!$post_id) return 'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?auto=format&fit=crop&w=600&q=80';

    $thumb_val = apepi_get_course_meta($post_id, 'thumb_imagem', '');
    if (!empty($thumb_val)) {
        if (is_numeric($thumb_val) && intval($thumb_val) > 0) {
            $url = wp_get_attachment_image_url(intval($thumb_val), 'medium_large');
            if ($url) return $url;
        }
        if (is_string($thumb_val) && (strpos($thumb_val, 'http') === 0 || strpos($thumb_val, '/') === 0)) {
            return $thumb_val;
        }
    }

    if (has_post_thumbnail($post_id)) {
        $url = get_the_post_thumbnail_url($post_id, 'medium_large');
        if ($url) return $url;
    }

    return 'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?auto=format&fit=crop&w=600&q=80';
}

/**
 * Helper Universal para Obter a Imagem do Banner Hero do Curso
 */
function apepi_get_course_hero_image($post_id) {
    if (!$post_id) return get_template_directory_uri() . '/assets/hero_doctor_medical_desk.png';

    $hero_val = apepi_get_course_meta($post_id, 'hero_imagem', '');
    if (!empty($hero_val)) {
        if (is_numeric($hero_val) && intval($hero_val) > 0) {
            $url = wp_get_attachment_image_url(intval($hero_val), 'full');
            if ($url) return $url;
        }
        if (is_string($hero_val) && (strpos($hero_val, 'http') === 0 || strpos($hero_val, '/') === 0)) {
            return $hero_val;
        }
    }

    if (has_post_thumbnail($post_id)) {
        $url = get_the_post_thumbnail_url($post_id, 'full');
        if ($url) return $url;
    }

    return get_template_directory_uri() . '/assets/hero_doctor_medical_desk.png';
}

/**
 * Filtro Template Include para Cursos do JetEngine e do Tema
 */
function apepi_escola_course_template_redirect($template) {
    if (is_singular(array('curso', 'cursos', 'jet-engine-curso'))) {
        $single_template = locate_template('single-curso.php');
        if ($single_template) {
            return $single_template;
        }
    }
    return $template;
}
add_filter('template_include', 'apepi_escola_course_template_redirect');

/**
 * Registro dos Custom Post Types (Cursos, Professores, Depoimentos)
 */
function apepi_escola_register_cpts() {
    register_post_type('curso', array(
        'labels' => array(
            'name'          => __('Cursos', 'apepi-escola'),
            'singular_name' => __('Curso', 'apepi-escola'),
            'add_new_item'  => __('Adicionar Novo Curso', 'apepi-escola'),
            'edit_item'     => __('Editar Curso', 'apepi-escola'),
        ),
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => array('slug' => 'cursos'),
        'menu_icon'    => 'dashicons-welcome-learn-more',
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest' => true,
    ));

    register_post_type('professor', array(
        'labels' => array(
            'name'          => __('Professores', 'apepi-escola'),
            'singular_name' => __('Professor', 'apepi-escola'),
            'add_new_item'  => __('Adicionar Novo Professor', 'apepi-escola'),
            'edit_item'     => __('Editar Professor', 'apepi-escola'),
        ),
        'public'       => true,
        'has_archive'  => false,
        'menu_icon'    => 'dashicons-businessperson',
        'supports'     => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'show_in_rest' => true,
    ));

    register_post_type('depoimento', array(
        'labels' => array(
            'name'          => __('Depoimentos', 'apepi-escola'),
            'singular_name' => __('Depoimento', 'apepi-escola'),
            'add_new_item'  => __('Adicionar Novo Depoimento', 'apepi-escola'),
            'edit_item'     => __('Editar Depoimento', 'apepi-escola'),
        ),
        'public'       => true,
        'has_archive'  => false,
        'menu_icon'    => 'dashicons-video-alt3',
        'supports'     => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'apepi_escola_register_cpts');

/**
 * Meta Boxes Nativas para o CPT Curso (Layout page_2.png)
 */
function apepi_escola_add_curso_metaboxes() {
    add_meta_box(
        'apepi_curso_details',
        __('APEPI Escola — Configurações Completas do Curso (Layout Modelo Page 2)', 'apepi-escola'),
        'apepi_escola_curso_metabox_callback',
        array('curso', 'cursos', 'jet-engine-curso'),
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'apepi_escola_add_curso_metaboxes');

function apepi_escola_curso_metabox_callback($post) {
    wp_nonce_field('apepi_save_curso_meta', 'apepi_curso_meta_nonce');

    $badge_cat   = get_post_meta($post->ID, '_curso_badge_categoria', true);
    $subtitulo   = get_post_meta($post->ID, '_curso_subtitulo', true);
    $prox_turma  = get_post_meta($post->ID, '_curso_proxima_turma', true);
    $carga_hor   = get_post_meta($post->ID, '_curso_carga_horaria', true);
    $duracao     = get_post_meta($post->ID, '_curso_duracao', true);
    $modalidade  = get_post_meta($post->ID, '_curso_modalidade', true);
    $link_insc   = get_post_meta($post->ID, '_curso_link_inscricao', true);
    $wa_consult  = get_post_meta($post->ID, '_curso_wa_consultor', true);

    $thumb_img   = get_post_meta($post->ID, '_curso_thumb_imagem', true);
    $hero_img    = get_post_meta($post->ID, '_curso_hero_imagem', true);

    $aprender    = get_post_meta($post->ID, '_curso_voce_vai_aprender', true);
    $dif_titulo  = get_post_meta($post->ID, '_curso_dif_titulo', true);
    $dif_desc    = get_post_meta($post->ID, '_curso_dif_desc', true);
    $dif_topicos = get_post_meta($post->ID, '_curso_dif_topicos', true);
    $dif_imagem  = get_post_meta($post->ID, '_curso_dif_imagem', true);
    $dif_link    = get_post_meta($post->ID, '_curso_dif_link', true);
    $modulos     = get_post_meta($post->ID, '_curso_modulos', true);
    ?>
    <style>
        .apepi-mb-section { background:#fcfcfc; border:1px solid #e0e0e0; border-radius:8px; padding:15px; margin-bottom:15px; }
        .apepi-mb-section h4 { margin-top:0; color:#003E19; font-size:15px; border-bottom:1px solid #eee; padding-bottom:8px; }
        .apepi-meta-field { margin-bottom:12px; }
        .apepi-meta-field label { font-weight:bold; display:block; margin-bottom:4px; font-size:13px; }
        .apepi-meta-field input[type="text"], .apepi-meta-field textarea { width:100%; padding:6px 10px; border-radius:4px; border:1px solid #ccc; }
    </style>

    <!-- Section 0: Imagens do Curso (Thumbnail & Hero) -->
    <div class="apepi-mb-section">
        <h4>1. Imagens do Curso (Thumbnail do Card & Banner Hero)</h4>
        
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
            <div class="apepi-meta-field">
                <label for="apepi_curso_thumb_imagem"><?php _e('Imagem da Thumbnail / Card (Listagem)', 'apepi-escola'); ?></label>
                <div style="display:flex; gap:8px; align-items:center; margin-bottom: 6px;">
                    <input type="text" id="apepi_curso_thumb_imagem" name="apepi_curso_thumb_imagem" value="<?php echo esc_attr($thumb_img); ?>" placeholder="https://...">
                    <button type="button" class="button button-secondary" id="apepi_upload_thumb_btn"><?php _e('Galeria / Enviar', 'apepi-escola'); ?></button>
                </div>
                <div id="apepi_thumb_preview_box" style="margin-top: 6px;">
                    <img id="apepi_thumb_preview_img" src="<?php echo esc_url($thumb_img ? $thumb_img : (has_post_thumbnail($post->ID) ? get_the_post_thumbnail_url($post->ID, 'medium') : 'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?auto=format&fit=crop&w=300&q=80')); ?>" style="max-width:180px; max-height:110px; object-fit:cover; border-radius:6px; border:1px solid #ccc; display:block;" alt="Pré-visualização da Thumbnail">
                </div>
                <p class="description" style="margin-top: 4px; font-size:11px; color:#666;"><?php _e('Exibida no carrossel de formações na Home. Se vazio, usará a Imagem em Destaque do post.', 'apepi-escola'); ?></p>
            </div>

            <div class="apepi-meta-field">
                <label for="apepi_curso_hero_imagem"><?php _e('Imagem do Banner Hero (Topo da Página do Curso)', 'apepi-escola'); ?></label>
                <div style="display:flex; gap:8px; align-items:center; margin-bottom: 6px;">
                    <input type="text" id="apepi_curso_hero_imagem" name="apepi_curso_hero_imagem" value="<?php echo esc_attr($hero_img); ?>" placeholder="https://...">
                    <button type="button" class="button button-secondary" id="apepi_upload_hero_btn"><?php _e('Galeria / Enviar', 'apepi-escola'); ?></button>
                </div>
                <div id="apepi_hero_preview_box" style="margin-top: 6px;">
                    <img id="apepi_hero_preview_img" src="<?php echo esc_url($hero_img ? $hero_img : (has_post_thumbnail($post->ID) ? get_the_post_thumbnail_url($post->ID, 'full') : get_template_directory_uri() . '/assets/hero_doctor_medical_desk.png')); ?>" style="max-width:180px; max-height:110px; object-fit:cover; border-radius:6px; border:1px solid #ccc; display:block;" alt="Pré-visualização do Hero">
                </div>
                <p class="description" style="margin-top: 4px; font-size:11px; color:#666;"><?php _e('Exibida no topo da página de detalhes do curso. Se vazio, usará a Imagem em Destaque do post.', 'apepi-escola'); ?></p>
            </div>
        </div>
    </div>

    <!-- Section 1: Hero Topo & Card Flutuante -->
    <div class="apepi-mb-section">
        <h4>2. Configurações do Hero Topo e Card Flutuante de Inscrição</h4>
        
        <div class="apepi-meta-field">
            <label for="apepi_curso_badge_categoria"><?php _e('Badge da Categoria Superior (ex: FORMAÇÃO COMPLETA PARA MÉDICOS)', 'apepi-escola'); ?></label>
            <input type="text" id="apepi_curso_badge_categoria" name="apepi_curso_badge_categoria" value="<?php echo esc_attr($badge_cat); ?>">
        </div>

        <div class="apepi-meta-field">
            <label for="apepi_curso_subtitulo"><?php _e('Subtítulo do Curso (ex: Único curso que proporciona uma experiência prática...)', 'apepi-escola'); ?></label>
            <textarea id="apepi_curso_subtitulo" name="apepi_curso_subtitulo" rows="2"><?php echo esc_textarea($subtitulo); ?></textarea>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr 1fr 1fr; gap:10px;">
            <div class="apepi-meta-field">
                <label for="apepi_curso_proxima_turma"><?php _e('Próxima Turma', 'apepi-escola'); ?></label>
                <input type="text" id="apepi_curso_proxima_turma" name="apepi_curso_proxima_turma" value="<?php echo esc_attr($prox_turma); ?>" placeholder="Setembro/2025">
            </div>
            <div class="apepi-meta-field">
                <label for="apepi_curso_carga_horaria"><?php _e('Carga Horária', 'apepi-escola'); ?></label>
                <input type="text" id="apepi_curso_carga_horaria" name="apepi_curso_carga_horaria" value="<?php echo esc_attr($carga_hor); ?>" placeholder="100 horas">
            </div>
            <div class="apepi-meta-field">
                <label for="apepi_curso_duracao"><?php _e('Duração', 'apepi-escola'); ?></label>
                <input type="text" id="apepi_curso_duracao" name="apepi_curso_duracao" value="<?php echo esc_attr($duracao); ?>" placeholder="3 meses">
            </div>
            <div class="apepi-meta-field">
                <label for="apepi_curso_modalidade"><?php _e('Modalidade', 'apepi-escola'); ?></label>
                <input type="text" id="apepi_curso_modalidade" name="apepi_curso_modalidade" value="<?php echo esc_attr($modalidade); ?>" placeholder="Online ao vivo">
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
            <div class="apepi-meta-field">
                <label for="apepi_curso_link_inscricao"><?php _e('Link do Botão "QUERO ME INSCREVER"', 'apepi-escola'); ?></label>
                <input type="text" id="apepi_curso_link_inscricao" name="apepi_curso_link_inscricao" value="<?php echo esc_attr($link_insc); ?>" placeholder="https://...">
            </div>
            <div class="apepi-meta-field">
                <label for="apepi_curso_wa_consultor"><?php _e('WhatsApp / Telefone do Consultor', 'apepi-escola'); ?></label>
                <input type="text" id="apepi_curso_wa_consultor" name="apepi_curso_wa_consultor" value="<?php echo esc_attr($wa_consult); ?>" placeholder="5521979570000">
            </div>
        </div>
    </div>

    <!-- Section 2: Você Vai Aprender -->
    <div class="apepi-mb-section">
        <h4>3. Seção "Você Vai Aprender"</h4>
        <div class="apepi-meta-field">
            <label for="apepi_curso_voce_vai_aprender"><?php _e('Tópicos Aprendidos (Um por linha)', 'apepi-escola'); ?></label>
            <textarea id="apepi_curso_voce_vai_aprender" name="apepi_curso_voce_vai_aprender" rows="4"><?php echo esc_textarea($aprender); ?></textarea>
            <p class="description"><?php _e('Exemplo:<br>Fundamentos da Cannabis e do Sistema Endocanabinoide<br>Indicações terapêuticas e evidências científicas', 'apepi-escola'); ?></p>
        </div>
    </div>

    <!-- Section 3: Diferencial Exclusivo (Card Fazenda) -->
    <div class="apepi-mb-section">
        <h4>4. Card "Diferencial Exclusivo" (Fazenda Experimental)</h4>
        
        <div class="apepi-meta-field">
            <label for="apepi_curso_dif_titulo"><?php _e('Título do Diferencial (ex: Visita à Fazenda Experimental)', 'apepi-escola'); ?></label>
            <input type="text" id="apepi_curso_dif_titulo" name="apepi_curso_dif_titulo" value="<?php echo esc_attr($dif_titulo); ?>">
        </div>

        <div class="apepi-meta-field">
            <label for="apepi_curso_dif_desc"><?php _e('Descrição do Diferencial', 'apepi-escola'); ?></label>
            <textarea id="apepi_curso_dif_desc" name="apepi_curso_dif_desc" rows="2"><?php echo esc_textarea($dif_desc); ?></textarea>
        </div>

        <div class="apepi-meta-field">
            <label for="apepi_curso_dif_topicos"><?php _e('Tópicos com Checkmark do Diferencial (Um por linha)', 'apepi-escola'); ?></label>
            <textarea id="apepi_curso_dif_topicos" name="apepi_curso_dif_topicos" rows="3"><?php echo esc_textarea($dif_topicos); ?></textarea>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
            <div class="apepi-meta-field">
                <label for="apepi_curso_dif_imagem"><?php _e('URL da Imagem da Fazenda/Diferencial', 'apepi-escola'); ?></label>
                <input type="text" id="apepi_curso_dif_imagem" name="apepi_curso_dif_imagem" value="<?php echo esc_attr($dif_imagem); ?>" placeholder="https://...">
            </div>
            <div class="apepi-meta-field">
                <label for="apepi_curso_dif_link"><?php _e('Link do Botão "CONHEÇA NOSSA FAZENDA"', 'apepi-escola'); ?></label>
                <input type="text" id="apepi_curso_dif_link" name="apepi_curso_dif_link" value="<?php echo esc_attr($dif_link); ?>" placeholder="<?php echo esc_url(home_url('/fazenda')); ?>">
            </div>
        </div>
    </div>

    <!-- Section 4: Conteúdo Programático -->
    <div class="apepi-mb-section">
        <h4>5. Conteúdo Programático (Módulos)</h4>
        <div class="apepi-meta-field">
            <label for="apepi_curso_modulos"><?php _e('Módulos do Curso (Um por linha)', 'apepi-escola'); ?></label>
            <textarea id="apepi_curso_modulos" name="apepi_curso_modulos" rows="5"><?php echo esc_textarea($modulos); ?></textarea>
            <p class="description"><?php _e('Formato: Título do Módulo | Subtítulo ou Descrição Rápida<br>Exemplo: Módulo 1 – Fundamentos da Cannabis | História, legislação e Sistema Endocanabinoide.', 'apepi-escola'); ?></p>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        // Media uploader para Thumbnail do Curso
        $('#apepi_upload_thumb_btn').on('click', function(e) {
            e.preventDefault();
            var frame = wp.media({
                title: 'Selecionar Imagem da Thumbnail / Card',
                button: { text: 'Usar esta imagem' },
                multiple: false
            });
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#apepi_curso_thumb_imagem').val(attachment.url);
                $('#apepi_thumb_preview_img').attr('src', attachment.url);
            }).open();
        });

        // Media uploader para Hero do Curso
        $('#apepi_upload_hero_btn').on('click', function(e) {
            e.preventDefault();
            var frame = wp.media({
                title: 'Selecionar Imagem do Hero (Banner de Topo)',
                button: { text: 'Usar esta imagem' },
                multiple: false
            });
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#apepi_curso_hero_imagem').val(attachment.url);
                $('#apepi_hero_preview_img').attr('src', attachment.url);
            }).open();
        });
    });
    </script>
    <?php
}

function apepi_escola_save_curso_meta($post_id) {
    if (!isset($_POST['apepi_curso_meta_nonce']) || !wp_verify_nonce($_POST['apepi_curso_meta_nonce'], 'apepi_save_curso_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = array(
        'apepi_curso_badge_categoria' => '_curso_badge_categoria',
        'apepi_curso_subtitulo'       => '_curso_subtitulo',
        'apepi_curso_proxima_turma'   => '_curso_proxima_turma',
        'apepi_curso_carga_horaria'   => '_curso_carga_horaria',
        'apepi_curso_duracao'         => '_curso_duracao',
        'apepi_curso_modalidade'      => '_curso_modalidade',
        'apepi_curso_link_inscricao'  => '_curso_link_inscricao',
        'apepi_curso_wa_consultor'    => '_curso_wa_consultor',
        'apepi_curso_thumb_imagem'    => '_curso_thumb_imagem',
        'apepi_curso_hero_imagem'     => '_curso_hero_imagem',
        'apepi_curso_voce_vai_aprender'=> '_curso_voce_vai_aprender',
        'apepi_curso_dif_titulo'      => '_curso_dif_titulo',
        'apepi_curso_dif_desc'        => '_curso_dif_desc',
        'apepi_curso_dif_topicos'     => '_curso_dif_topicos',
        'apepi_curso_dif_imagem'      => '_curso_dif_imagem',
        'apepi_curso_dif_link'        => '_curso_dif_link',
        'apepi_curso_modulos'         => '_curso_modulos',
    );

    foreach ($fields as $input_key => $meta_key) {
        if (isset($_POST[$input_key])) {
            if (in_array($input_key, array('apepi_curso_subtitulo', 'apepi_curso_voce_vai_aprender', 'apepi_curso_dif_desc', 'apepi_curso_dif_topicos', 'apepi_curso_modulos'))) {
                update_post_meta($post_id, $meta_key, sanitize_textarea_field($_POST[$input_key]));
            } else if (in_array($input_key, array('apepi_curso_thumb_imagem', 'apepi_curso_hero_imagem', 'apepi_curso_dif_imagem'))) {
                update_post_meta($post_id, $meta_key, esc_url_raw(trim($_POST[$input_key])));
            } else {
                update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$input_key]));
            }
        }
    }
}
add_action('save_post', 'apepi_escola_save_curso_meta');

/**
 * Meta Boxes Nativas para o CPT Professor
 */
function apepi_escola_add_professor_metaboxes() {
    add_meta_box(
        'apepi_professor_details',
        __('Informações e Foto do Professor', 'apepi-escola'),
        'apepi_escola_professor_metabox_callback',
        array('professor', 'professores', 'jet-engine-professor'),
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'apepi_escola_add_professor_metaboxes');

function apepi_escola_professor_metabox_callback($post) {
    wp_nonce_field('apepi_save_professor_meta', 'apepi_professor_meta_nonce');

    $especialidade = get_post_meta($post->ID, '_professor_especialidade', true);
    if (empty($especialidade)) {
        $especialidade = get_post_meta($post->ID, '_professor_cargo', true);
    }
    $crm  = get_post_meta($post->ID, '_professor_crm', true);
    $foto = get_post_meta($post->ID, '_professor_foto', true);
    if (empty($foto) && has_post_thumbnail($post->ID)) {
        $foto = get_the_post_thumbnail_url($post->ID, 'full');
    }
    ?>
    <div style="margin-bottom: 15px;">
        <label style="font-weight:bold; display:block; margin-bottom: 6px;" for="apepi_professor_foto"><?php _e('Foto / Imagem do Professor', 'apepi-escola'); ?></label>
        <div style="display:flex; gap:10px; align-items:center; margin-bottom: 8px;">
            <input type="text" id="apepi_professor_foto" name="apepi_professor_foto" value="<?php echo esc_attr($foto); ?>" style="flex:1; padding:6px 10px; border-radius:4px; border:1px solid #ccc;" placeholder="https://...">
            <button type="button" class="button button-secondary" id="apepi_upload_prof_foto_btn"><?php _e('Selecionar da Galeria / Enviar Foto', 'apepi-escola'); ?></button>
        </div>
        <div id="apepi_prof_foto_preview_box" style="margin-top: 8px;">
            <img id="apepi_prof_foto_img" src="<?php echo esc_url($foto ? $foto : get_template_directory_uri() . '/assets/logo_apepi_escola.png'); ?>" style="width:90px; height:90px; object-fit:cover; border-radius:50%; border:2px solid #003E19; background:#fff; padding:2px;" alt="Pré-visualização">
        </div>
        <p class="description" style="margin-top: 4px; color:#666;"><?php _e('Você também pode definir a imagem do professor usando a opção "Imagem em Destaque" no menu lateral direito do WordPress.', 'apepi-escola'); ?></p>
    </div>

    <div style="margin-bottom: 12px;">
        <label style="font-weight:bold; display:block; margin-bottom: 4px;" for="apepi_professor_especialidade"><?php _e('Especialidade / Título (ex: Médico • Psiquiatra)', 'apepi-escola'); ?></label>
        <input type="text" id="apepi_professor_especialidade" name="apepi_professor_especialidade" value="<?php echo esc_attr($especialidade); ?>" style="width:100%; padding:6px 10px; border-radius:4px; border:1px solid #ccc;">
    </div>

    <div>
        <label style="font-weight:bold; display:block; margin-bottom: 4px;" for="apepi_professor_crm"><?php _e('CRM / CRMV / Registro Profissional (ex: CRM 52 011296-4)', 'apepi-escola'); ?></label>
        <input type="text" id="apepi_professor_crm" name="apepi_professor_crm" value="<?php echo esc_attr($crm); ?>" style="width:100%; padding:6px 10px; border-radius:4px; border:1px solid #ccc;">
    </div>

    <script>
    jQuery(document).ready(function($) {
        $('#apepi_upload_prof_foto_btn').on('click', function(e) {
            e.preventDefault();
            var frame = wp.media({
                title: 'Selecionar Foto do Professor',
                button: { text: 'Usar esta foto' },
                multiple: false
            });
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#apepi_professor_foto').val(attachment.url);
                $('#apepi_prof_foto_img').attr('src', attachment.url);
            }).open();
        });
    });
    </script>
    <?php
}

function apepi_escola_save_professor_meta($post_id) {
    if (!isset($_POST['apepi_professor_meta_nonce']) || !wp_verify_nonce($_POST['apepi_professor_meta_nonce'], 'apepi_save_professor_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['apepi_professor_especialidade'])) {
        update_post_meta($post_id, '_professor_especialidade', sanitize_text_field($_POST['apepi_professor_especialidade']));
    }
    if (isset($_POST['apepi_professor_crm'])) {
        update_post_meta($post_id, '_professor_crm', sanitize_text_field($_POST['apepi_professor_crm']));
    }
    if (isset($_POST['apepi_professor_foto'])) {
        $foto_val = trim($_POST['apepi_professor_foto']);
        update_post_meta($post_id, '_professor_foto', esc_url_raw($foto_val));

        // Se a foto corresponder a uma imagem da galeria, atualiza também a Imagem em Destaque
        if (!empty($foto_val)) {
            $attachment_id = attachment_url_to_postid($foto_val);
            if ($attachment_id) {
                set_post_thumbnail($post_id, $attachment_id);
            }
        }
    }
}
add_action('save_post', 'apepi_escola_save_professor_meta');

/**
 * Helper Universal para Obter a Foto do Professor
 */
function apepi_get_professor_image_url($post_id) {
    if (!$post_id) return get_template_directory_uri() . '/assets/logo_apepi_escola.png';

    $meta_keys = array(
        '_professor_foto',
        'professor_foto',
        'foto',
        'foto_professor',
        'imagem',
        'avatar',
        'foto_do_professor',
        'profile_image',
        'foto_perfil',
        'imagem_professor',
        '_thumbnail_id'
    );

    foreach ($meta_keys as $key) {
        $val = get_post_meta($post_id, $key, true);
        if (empty($val)) continue;

        // Se for um ID numérico de anexo da galeria do WP
        if (is_numeric($val) && intval($val) > 0) {
            $url = wp_get_attachment_image_url(intval($val), 'full');
            if ($url) return $url;
        }

        // Se for um array de dados do JetEngine (ex: array('url' => '...', 'id' => 123))
        if (is_array($val)) {
            if (!empty($val['url'])) return $val['url'];
            if (!empty($val['id'])) {
                $url = wp_get_attachment_image_url(intval($val['id']), 'full');
                if ($url) return $url;
            }
        }

        // Se for uma URL em string
        if (is_string($val) && (strpos($val, 'http') === 0 || strpos($val, '/') === 0)) {
            return $val;
        }
    }

    // Tenta a Imagem em Destaque nativa do post
    if (has_post_thumbnail($post_id)) {
        $url = get_the_post_thumbnail_url($post_id, 'full');
        if ($url) return $url;
    }

    return get_template_directory_uri() . '/assets/logo_apepi_escola.png';
}

/**
 * Helper Universal para Obter Especialidade / Cargo do Professor
 */
function apepi_get_professor_cargo($post_id) {
    $keys = array('_professor_especialidade', '_professor_cargo', 'especialidade', 'cargo', 'titulo', 'profissao', 'role');
    foreach ($keys as $key) {
        $val = get_post_meta($post_id, $key, true);
        if (!empty($val) && is_string($val)) return $val;
    }
    return 'Especialista';
}

/**
 * Helper Universal para Obter CRM / Registro do Professor
 */
function apepi_get_professor_crm($post_id) {
    $keys = array('_professor_crm', 'crm', 'crmv', 'registro', 'registro_profissional');
    foreach ($keys as $key) {
        $val = get_post_meta($post_id, $key, true);
        if (!empty($val) && is_string($val)) return $val;
    }
    return 'Professor APEPI';
}

/**
 * Meta Boxes Nativas para o CPT Depoimento
 */
function apepi_escola_add_depoimento_metaboxes() {
    add_meta_box(
        'apepi_depoimento_details',
        __('Informações do Depoimento', 'apepi-escola'),
        'apepi_escola_depoimento_metabox_callback',
        'depoimento',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'apepi_escola_add_depoimento_metaboxes');

function apepi_escola_depoimento_metabox_callback($post) {
    wp_nonce_field('apepi_save_depoimento_meta', 'apepi_depoimento_meta_nonce');

    $cargo     = get_post_meta($post->ID, '_depoimento_cargo', true);
    $video_url = get_post_meta($post->ID, '_depoimento_video_url', true);
    ?>
    <div style="margin-bottom: 12px;">
        <label style="font-weight:bold; display:block; margin-bottom: 4px;" for="apepi_depoimento_cargo"><?php _e('Cargo / Profissão do Aluno (ex: Médica Veterinária)', 'apepi-escola'); ?></label>
        <input type="text" id="apepi_depoimento_cargo" name="apepi_depoimento_cargo" value="<?php echo esc_attr($cargo); ?>" style="width:100%;">
    </div>
    <div>
        <label style="font-weight:bold; display:block; margin-bottom: 4px;" for="apepi_depoimento_video_url"><?php _e('URL do Vídeo do Depoimento (YouTube / Vimeo)', 'apepi-escola'); ?></label>
        <input type="text" id="apepi_depoimento_video_url" name="apepi_depoimento_video_url" value="<?php echo esc_attr($video_url); ?>" style="width:100%;">
    </div>
    <?php
}

function apepi_escola_save_depoimento_meta($post_id) {
    if (!isset($_POST['apepi_depoimento_meta_nonce']) || !wp_verify_nonce($_POST['apepi_depoimento_meta_nonce'], 'apepi_save_depoimento_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['apepi_depoimento_cargo'])) {
        update_post_meta($post_id, '_depoimento_cargo', sanitize_text_field($_POST['apepi_depoimento_cargo']));
    }
    if (isset($_POST['apepi_depoimento_video_url'])) {
        update_post_meta($post_id, '_depoimento_video_url', sanitize_text_field($_POST['apepi_depoimento_video_url']));
    }
}
add_action('save_post', 'apepi_escola_save_depoimento_meta');

/**
 * Injector de Classes do Menu
 */
function apepi_escola_nav_menu_link_attributes($atts, $item, $args) {
    if (isset($args->theme_location) && $args->theme_location === 'primary') {
        $atts['class'] = isset($atts['class']) ? $atts['class'] . ' nav-link-item' : 'nav-link-item';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'apepi_escola_nav_menu_link_attributes', 10, 3);

/**
 * Shortcodes Modulares de Curso para o Elementor
 */

// 1. Shortcode Hero
function apepi_shortcode_curso_hero($atts) {
    $atts = shortcode_atts(array('id' => get_the_ID()), $atts);
    $post_id = intval($atts['id']);
    if (!$post_id) $post_id = get_the_ID();

    $hero_img        = apepi_get_course_hero_image($post_id);
    $badge_categoria = apepi_get_course_meta($post_id, 'badge_categoria', 'FORMAÇÃO COMPLETA PARA MÉDICOS');
    $subtitulo       = apepi_get_course_meta($post_id, 'subtitulo', 'Único curso que proporciona uma experiência prática com visita guiada à Fazenda de Cannabis Medicinal da APEPI.');
    $proxima_turma   = apepi_get_course_meta($post_id, 'proxima_turma', 'Setembro/2025');
    $carga_horaria   = apepi_get_course_meta($post_id, 'carga_horaria', '100 horas');
    $duracao         = apepi_get_course_meta($post_id, 'duracao', '3 meses');
    $modalidade      = apepi_get_course_meta($post_id, 'modalidade', 'Online ao vivo');
    $link_inscricao  = apepi_get_course_meta($post_id, 'link_inscricao', '#inscricao');
    $wa_consultor    = apepi_get_course_meta($post_id, 'wa_consultor', apepi_get_option('apepi_whatsapp_number', '5521979570000'));

    ob_start();
    ?>
    <section class="course-hero-p2 hero-banner-degrade">
      <div class="hero-bg-wrapper">
        <img src="<?php echo esc_url($hero_img); ?>" alt="<?php echo esc_attr(get_the_title($post_id)); ?>" class="hero-bg-img">
        <div class="hero-gradient-overlay"></div>
      </div>
      <div class="container course-hero-grid-p2">
        <div class="course-hero-left-p2">
          <span class="course-badge-sub" style="color: var(--secondary); font-weight: 800; letter-spacing: 0.12em; text-transform: uppercase; font-size: 0.85rem;"><?php echo esc_html($badge_categoria); ?></span>
          <h1 class="course-title-p2"><?php echo esc_html(get_the_title($post_id)); ?></h1>
          <p class="course-subtitle-p2"><?php echo esc_html($subtitulo); ?></p>
          <div class="course-quick-highlights-p2">
            <div class="cqh-item">
              <div class="cqh-icon"><i class="fa-solid fa-display"></i></div>
              <span><strong>100% online</strong><br>ao vivo</span>
            </div>
            <div class="cqh-item">
              <div class="cqh-icon"><i class="fa-solid fa-certificate"></i></div>
              <span><strong>Certificado de</strong><br>conclusão</span>
            </div>
          </div>
        </div>
        <div class="course-hero-right-p2">
          <div class="course-floating-white-card-p2">
            <ul class="p2-card-info-list">
              <li>
                <div class="p2-info-icon"><i class="fa-regular fa-calendar-check"></i></div>
                <div class="p2-info-text"><span>Próxima turma</span><strong><?php echo esc_html($proxima_turma); ?></strong></div>
              </li>
              <li>
                <div class="p2-info-icon"><i class="fa-regular fa-clock"></i></div>
                <div class="p2-info-text"><span>Carga horária</span><strong><?php echo esc_html($carga_horaria); ?></strong></div>
              </li>
              <li>
                <div class="p2-info-icon"><i class="fa-solid fa-hourglass-half"></i></div>
                <div class="p2-info-text"><span>Duração</span><strong><?php echo esc_html($duracao); ?></strong></div>
              </li>
              <li>
                <div class="p2-info-icon"><i class="fa-solid fa-desktop"></i></div>
                <div class="p2-info-text"><span>Modalidade</span><strong><?php echo esc_html($modalidade); ?></strong></div>
              </li>
            </ul>
            <a href="<?php echo esc_url($link_inscricao); ?>" target="_blank" class="btn btn-primary btn-block btn-p2-cta">QUERO ME INSCREVER</a>
            <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $wa_consultor)); ?>" target="_blank" class="p2-wa-consultor">
              <i class="fa-brands fa-whatsapp"></i> Falar com um consultor
            </a>
          </div>
        </div>
      </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('apepi_curso_hero', 'apepi_shortcode_curso_hero');

// 2. Shortcode Feature Bar
function apepi_shortcode_curso_feature_bar() {
    ob_start();
    ?>
    <section class="p2-feature-bar-section">
      <div class="container">
        <div class="p2-feature-bar-grid">
          <div class="p2-fb-item"><i class="fa-solid fa-circle-play"></i><span>Aulas gravadas<br>disponíveis</span></div>
          <div class="p2-fb-item"><i class="fa-solid fa-book-open"></i><span>Material didático<br>completo</span></div>
          <div class="p2-fb-item"><i class="fa-solid fa-user-doctor"></i><span>Suporte com<br>especialistas</span></div>
          <div class="p2-fb-item"><i class="fa-solid fa-people-group"></i><span>Discussões de<br>casos clínicos</span></div>
          <div class="p2-fb-item"><i class="fa-solid fa-clipboard-check"></i><span>Certificado de<br>conclusão</span></div>
        </div>
      </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('apepi_curso_feature_bar', 'apepi_shortcode_curso_feature_bar');

// 3. Shortcode Página Completa
function apepi_shortcode_curso_pagina_completa($atts) {
    $atts = shortcode_atts(array('id' => get_the_ID()), $atts);
    $post_id = intval($atts['id']);
    if (!$post_id) $post_id = get_the_ID();

    ob_start();
    echo do_shortcode('[apepi_curso_hero id="' . $post_id . '"]');
    echo do_shortcode('[apepi_curso_feature_bar]');
    return ob_get_clean();
}
add_shortcode('apepi_curso_pagina_completa', 'apepi_shortcode_curso_pagina_completa');

// 4. Shortcode Listagem de Cursos (Layout da Home)
function apepi_shortcode_lista_cursos($atts) {
    $atts = shortcode_atts(array(
        'limit' => 10,
        'title' => 'FORMAÇÕES',
        'badge' => 'NOSSO CATÁLOGO'
    ), $atts);

    $limit = intval($atts['limit']);
    if ($limit <= 0) $limit = 10;

    $args_cursos = array(
        'post_type'      => array('curso', 'cursos', 'jet-engine-curso'),
        'posts_per_page' => $limit,
        'post_status'    => 'publish',
    );
    $query_cursos = new WP_Query($args_cursos);

    ob_start();
    ?>
    <section class="formations-section" style="padding: 4rem 0;">
      <div class="container">
        <div class="section-title-area">
          <div>
            <?php if (!empty($atts['badge'])) : ?><div class="section-badge"><?php echo esc_html($atts['badge']); ?></div><?php endif; ?>
            <?php if (!empty($atts['title'])) : ?><h2 class="section-main-title"><?php echo esc_html($atts['title']); ?></h2><?php endif; ?>
          </div>
          <div class="section-arrows">
            <button class="arrow-btn prevFormBtn" aria-label="Anterior"><i class="fa-solid fa-chevron-left"></i></button>
            <button class="arrow-btn nextFormBtn" aria-label="Próximo"><i class="fa-solid fa-chevron-right"></i></button>
          </div>
        </div>

        <div class="formations-carousel-wrapper">
          <div class="formations-grid">
            <?php
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
              // Fallback
              ?>
              <div class="formation-card">
                <div class="card-img-holder">
                  <img src="https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?auto=format&fit=crop&w=600&q=80" alt="Prescrição Médica">
                  <div class="card-badge-icon"><i class="fa-solid fa-user-doctor"></i></div>
                </div>
                <div class="card-content">
                  <h3 class="">Prescrição Médica</h3>
                  <p>Aprenda a indicar e acompanhar tratamentos com Cannabis Medicinal.</p>
                  <a href="<?php echo esc_url(home_url('/cursos')); ?>" class="saiba-mais-btn">SAIBA MAIS &rarr;</a>
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
                  <a href="<?php echo esc_url(home_url('/cursos')); ?>" class="saiba-mais-btn">SAIBA MAIS &rarr;</a>
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
                  <a href="<?php echo esc_url(home_url('/cursos')); ?>" class="saiba-mais-btn">SAIBA MAIS &rarr;</a>
                </div>
              </div>
              <?php
            endif;
            ?>
          </div>
        </div>
      </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('apepi_lista_cursos', 'apepi_shortcode_lista_cursos');
add_shortcode('apepi_cursos_grid', 'apepi_shortcode_lista_cursos');

// 5. Shortcode Listagem de Professores (Layout da Home)
function apepi_shortcode_lista_professores($atts) {
    $atts = shortcode_atts(array(
        'limit' => 10,
        'title' => 'Referência em Cannabis Medicinal',
        'badge' => 'NOSSOS PROFESSORES'
    ), $atts);

    $limit = intval($atts['limit']);
    if ($limit <= 0) $limit = 10;

    $args_prof = array(
        'post_type'      => array('professor', 'professores', 'jet-engine-professor', 'teacher', 'docente'),
        'posts_per_page' => $limit,
        'post_status'    => 'publish',
    );
    $query_prof = new WP_Query($args_prof);

    ob_start();
    ?>
    <section class="professores-section-home" style="padding: 4rem 0;">
      <div class="container">
        <div class="professores-header">
          <div>
            <?php if (!empty($atts['badge'])) : ?><div class="section-badge"><?php echo esc_html($atts['badge']); ?></div><?php endif; ?>
            <?php if (!empty($atts['title'])) : ?><h2 class=""><?php echo esc_html($atts['title']); ?></h2><?php endif; ?>
          </div>
          <a href="<?php echo esc_url(home_url('/quem-somos')); ?>" class="view-all-link">VER TODOS OS PROFESSORES &rarr;</a>
        </div>

        <div class="professores-grid">
          <?php
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
            // Fallback
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
    <?php
    return ob_get_clean();
}
add_shortcode('apepi_lista_professores', 'apepi_shortcode_lista_professores');
add_shortcode('apepi_professores_grid', 'apepi_shortcode_lista_professores');

// 6. Shortcode Página Quem Somos – Fidelidade Absoluta ref/missaoevalores.jfif
function apepi_shortcode_pagina_quem_somos() {
    ob_start();
    $qs_title        = apepi_get_option('apepi_quemsomos_title', "Missão\nVisão e Valores");
    $qs_subtitle     = apepi_get_option('apepi_quemsomos_subtitle', 'Uma trajetória de saúde e cuidado');
    $qs_desc         = apepi_get_option('apepi_quemsomos_desc', 'A APEPI existe para transformar vidas por meio da Cannabis Medicinal, promovendo acesso, conhecimento, inovação e tratamento com qualidade e responsabilidade.');
    $qs_founders_img = apepi_get_option('apepi_quemsomos_founders_img', get_template_directory_uri() . '/assets/qs_founders_hero.png');
    $qs_speech       = apepi_get_option('apepi_quemsomos_speech', 'A APEPI Escola iniciou com a ideia de <strong>Margarete Brito e Marcos Langenbach</strong> e ensinar as pessoas a cultivar seu próprio óleo.');

    $missao_text     = apepi_get_option('apepi_quemsomos_missao_text', 'Promover saúde e qualidade de vida por meio do acesso ao conhecimento, formação e tratamentos seguros com Cannabis Medicinal.');
    $visao_text      = apepi_get_option('apepi_quemsomos_visao_text', 'Ser referência nacional e internacional em ciência, educação e inovação em Cannabis Medicinal, transformando realidades e impulsionando o futuro da saúde.');
    
    $pilar1_img      = apepi_get_option('apepi_quemsomos_pilar1_img', get_template_directory_uri() . '/assets/qs_pilar1.png');
    $pilar1_title    = apepi_get_option('apepi_quemsomos_pilar1_title', 'Parte da história');
    $pilar1_text     = apepi_get_option('apepi_quemsomos_pilar1_text', 'Em mais de uma década, a APEPI ajudou a mudar leis e quebrar o preconceito sobre a planta. Ser associado APEPI é fazer parte da história da cannabis medicinal.');

    $pilar2_img      = apepi_get_option('apepi_quemsomos_pilar2_img', get_template_directory_uri() . '/assets/qs_pilar2.png');
    $pilar2_title    = apepi_get_option('apepi_quemsomos_pilar2_title', 'Pioneirismo e inovação');
    $pilar2_text     = apepi_get_option('apepi_quemsomos_pilar2_text', 'Primeira e maior fazenda legal de cannabis no país, para garantir qualidade e inovação aos associados. É planta no chão e remédio na mão.');

    $pilar3_img      = apepi_get_option('apepi_quemsomos_pilar3_img', get_template_directory_uri() . '/assets/qs_pilar3.png');
    $pilar3_title    = apepi_get_option('apepi_quemsomos_pilar3_title', 'Tecnologia e sustentabilidade');
    $pilar3_text     = apepi_get_option('apepi_quemsomos_pilar3_text', 'Controle avançado de cada planta, unindo plantio com insumos agroecológicos à pesquisa e maquinário de última geração.');

    $pilar4_img      = apepi_get_option('apepi_quemsomos_pilar4_img', get_template_directory_uri() . '/assets/qs_pilar4.png');
    $pilar4_title    = apepi_get_option('apepi_quemsomos_pilar4_title', 'Qualidade, segurança e união');
    $pilar4_text     = apepi_get_option('apepi_quemsomos_pilar4_text', 'Remédios à base de cannabis com certificado de análise (COA), que garante a efetividade do tratamento a preço justo.');

    $quote_p1        = apepi_get_option('apepi_quemsomos_quote_p1', 'Acreditamos que educar é cultivar. E cultivar conhecimento é transformar vidas.');
    $quote_p2        = apepi_get_option('apepi_quemsomos_quote_p2', 'Vamos juntos por uma sociedade mais saudável, informada e consciente.');
    ?>
        <div class="qs-page-exact-wrapper">

      <!-- ======================== 1. HERO QUEM SOMOS (FULL-WIDTH EDGE-TO-EDGE) ======================== -->
      <section class="hero-home-exact hero-banner-degrade qs-hero-banner">
        <div class="hero-bg-wrapper">
          <img src="<?php echo esc_url($qs_founders_img); ?>" alt="Margarete Brito e Marcos Langenbach - Fundadores da APEPI" class="hero-bg-img">
          <div class="hero-gradient-overlay"></div>
        </div>

        <div class="container hero-container-exact qs-hero-container">
          <div class="hero-content-exact qs-hero-content">
            <span class="qs-kicker">QUEM SOMOS</span>
            <h1 class="hero-title-exact"><?php echo nl2br(esc_html($qs_title)); ?></h1>
            <div class="hero-green-divider"></div>
            <h2 class="qs-subtitle"><?php echo esc_html($qs_subtitle); ?></h2>
            <p class="hero-desc-exact"><?php echo esc_html($qs_desc); ?></p>

            <!-- Refined Floating Organic Speech Balloon -->
            <div class="qs-speech-bubble-organic">
              <div class="qs-bubble-leaf-icon"><i class="fa-solid fa-leaf"></i></div>
              <p><?php echo wp_kses($qs_speech, array('strong' => array(), 'em' => array())); ?></p>
            </div>
          </div>
        </div>
      </section>

      <!-- ======================== 2. MISSÃO, VISÃO E VALORES ======================== -->
      <section class="qs-mvv-section">
        <div class="container">
          <div class="qs-mvv-grid">
            
            <div class="qs-mvv-card">
              <div class="qs-mvv-icon-circle"><i class="fa-solid fa-bullseye"></i></div>
              <h3 class="qs-mvv-card-title">MISSÃO</h3>
              <p class="qs-mvv-card-desc"><?php echo esc_html($missao_text); ?></p>
            </div>

            <div class="qs-mvv-card">
              <div class="qs-mvv-icon-circle"><i class="fa-solid fa-eye"></i></div>
              <h3 class="qs-mvv-card-title">VISÃO</h3>
              <p class="qs-mvv-card-desc"><?php echo esc_html($visao_text); ?></p>
            </div>

            <div class="qs-mvv-card">
              <div class="qs-mvv-icon-circle"><i class="fa-solid fa-gem"></i></div>
              <h3 class="qs-mvv-card-title">VALORES</h3>
              <ul class="qs-valores-checklist">
                <li><span class="bullet-dot">•</span> Ética e transparência</li>
                <li><span class="bullet-dot">•</span> Ciência e evidência</li>
                <li><span class="bullet-dot">•</span> Respeito à vida</li>
                <li><span class="bullet-dot">•</span> Inovação e excelência</li>
                <li><span class="bullet-dot">•</span> Responsabilidade social e ambiental</li>
              </ul>
            </div>

          </div>
        </div>
      </section>

      <!-- ======================== 3. TIMELINE ======================== -->
      <section class="qs-timeline-section">
        <div class="container">
          <div class="qs-timeline-header text-center">
            <h2 class="qs-timeline-title">DE ONDE VEMOS E PARA ONDE VAMOS</h2>
            <p class="qs-timeline-subtitle">Do cultivo ao conhecimento. Do conhecimento ao cuidado. Do cuidado à transformação.</p>
          </div>

          <div class="qs-stepper-container">
            <div class="qs-step-item">
              <div class="qs-step-circle"><i class="fa-solid fa-seedling"></i></div>
              <div class="qs-step-info">
                <h4 class="qs-step-name">A IDEIA</h4>
                <p class="qs-step-text">Ensinar as pessoas a cultivar seu próprio óleo com qualidade e segurança.</p>
              </div>
            </div>

            <div class="qs-step-arrow"><i class="fa-solid fa-arrow-right"></i></div>

            <div class="qs-step-item">
              <div class="qs-step-circle"><i class="fa-solid fa-graduation-cap"></i></div>
              <div class="qs-step-info">
                <h4 class="qs-step-name">A EVOLUÇÃO</h4>
                <p class="qs-step-text">Expandimos o propósito e transformamos a experiência prática em formação especializada.</p>
              </div>
            </div>

            <div class="qs-step-arrow"><i class="fa-solid fa-arrow-right"></i></div>

            <div class="qs-step-item qs-step-active">
              <div class="qs-step-circle qs-step-circle-filled"><i class="fa-solid fa-plus"></i></div>
              <div class="qs-step-info">
                <h4 class="qs-step-name">A MISSÃO</h4>
                <p class="qs-step-text">Criamos cursos para médicos, veterinários e profissionais de saúde, levando conhecimento científico e responsável sobre a Cannabis Medicinal.</p>
              </div>
            </div>

            <div class="qs-step-arrow"><i class="fa-solid fa-arrow-right"></i></div>

            <div class="qs-step-item">
              <div class="qs-step-circle"><i class="fa-solid fa-users"></i></div>
              <div class="qs-step-info">
                <h4 class="qs-step-name">O IMPACTO</h4>
                <p class="qs-step-text">Formamos profissionais mais preparados e promovemos mais acesso, qualidade de vida e bem-estar para milhares de pacientes.</p>
              </div>
            </div>

            <div class="qs-step-arrow"><i class="fa-solid fa-arrow-right"></i></div>

            <div class="qs-step-item">
              <div class="qs-step-circle qs-step-circle-dark"><i class="fa-solid fa-leaf"></i></div>
              <div class="qs-step-info">
                <h4 class="qs-step-name">O FUTURO</h4>
                <p class="qs-step-text">Continuamos inovando, pesquisando e educando para construir um futuro com mais saúde, liberdade e respeito à planta e às pessoas.</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ======================== 4. NOSSOS PILARES ======================== -->
      <section class="qs-pilares-section">
        <div class="container">
          <div class="qs-pilares-header text-center">
            <h2 class="qs-pilares-title">NOSSOS PILARES</h2>
            <div class="qs-pilares-line"></div>
          </div>

          <div class="qs-pilares-grid">
            
            <div class="qs-pilar-card">
              <div class="qs-pilar-photo-wrap">
                <img src="<?php echo esc_url($pilar1_img); ?>" alt="<?php echo esc_attr($pilar1_title); ?>" class="qs-pilar-img">
                <div class="qs-pilar-badge-icon"><i class="fa-solid fa-flag"></i></div>
              </div>
              <div class="qs-pilar-body">
                <h3 class="qs-pilar-name"><?php echo esc_html($pilar1_title); ?></h3>
                <p class="qs-pilar-text"><?php echo esc_html($pilar1_text); ?></p>
              </div>
            </div>

            <div class="qs-pilar-card">
              <div class="qs-pilar-photo-wrap">
                <img src="<?php echo esc_url($pilar2_img); ?>" alt="<?php echo esc_attr($pilar2_title); ?>" class="qs-pilar-img">
                <div class="qs-pilar-badge-icon"><i class="fa-solid fa-lightbulb"></i></div>
              </div>
              <div class="qs-pilar-body">
                <h3 class="qs-pilar-name"><?php echo esc_html($pilar2_title); ?></h3>
                <p class="qs-pilar-text"><?php echo esc_html($pilar2_text); ?></p>
              </div>
            </div>

            <div class="qs-pilar-card">
              <div class="qs-pilar-photo-wrap">
                <img src="<?php echo esc_url($pilar3_img); ?>" alt="<?php echo esc_attr($pilar3_title); ?>" class="qs-pilar-img">
                <div class="qs-pilar-badge-icon"><i class="fa-solid fa-leaf"></i></div>
              </div>
              <div class="qs-pilar-body">
                <h3 class="qs-pilar-name"><?php echo esc_html($pilar3_title); ?></h3>
                <p class="qs-pilar-text"><?php echo esc_html($pilar3_text); ?></p>
              </div>
            </div>

            <div class="qs-pilar-card">
              <div class="qs-pilar-photo-wrap">
                <img src="<?php echo esc_url($pilar4_img); ?>" alt="<?php echo esc_attr($pilar4_title); ?>" class="qs-pilar-img">
                <div class="qs-pilar-badge-icon"><i class="fa-solid fa-shield-halved"></i></div>
              </div>
              <div class="qs-pilar-body">
                <h3 class="qs-pilar-name"><?php echo esc_html($pilar4_title); ?></h3>
                <p class="qs-pilar-text"><?php echo esc_html($pilar4_text); ?></p>
              </div>
            </div>

          </div>
        </div>
      </section>

      <!-- ======================== 5. BANNER FINAL ======================== -->
      <section class="qs-quote-banner">
        <div class="container qs-quote-banner-container">
          <div class="qs-quote-leaf-icon"><i class="fa-solid fa-leaf"></i></div>
          <div class="qs-quote-content">
            <p class="qs-quote-primary"><?php echo esc_html($quote_p1); ?></p>
            <p class="qs-quote-secondary"><?php echo esc_html($quote_p2); ?></p>
          </div>
        </div>
      </section>

    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('apepi_pagina_quem_somos', 'apepi_shortcode_pagina_quem_somos');


// 7. Shortcode Página Fazenda – Fidelidade Absoluta ref/fazenda.jfif
function apepi_shortcode_pagina_fazenda() {
    ob_start();
    $wa_num           = apepi_get_option('apepi_whatsapp_number', '5521979570000');
    $fazenda_title    = apepi_get_option('apepi_fazenda_title', "Visita à\nFazenda da APEPI");
    $fazenda_subtitle = apepi_get_option('apepi_fazenda_subtitle', 'Aprendizado que nasce na prática');
    $fazenda_desc     = apepi_get_option('apepi_fazenda_desc', 'Acompanhe de perto todo o processo de produção dos nossos óleos — desde a germinação até a extração dos compostos da Cannabis.');
    $fazenda_subdesc  = apepi_get_option('apepi_fazenda_subdesc', 'Uma experiência imersiva, guiada por especialistas, para quem busca conhecimento com ciência, segurança e responsabilidade.');
    $fazenda_img      = apepi_get_option('apepi_fazenda_main_img', get_template_directory_uri() . '/assets/fazenda_hero_photo.png');

    $badge1           = apepi_get_option('apepi_fazenda_badge1', 'Para médicos, veterinários e profissionais da saúde');
    $badge2           = apepi_get_option('apepi_fazenda_badge2', 'Imersão prática e conteúdo científico');
    $badge3           = apepi_get_option('apepi_fazenda_badge3', 'Conexão entre teoria e prática com excelência');

    $callout_left     = apepi_get_option('apepi_fazenda_callout_left', 'Nossa equipe de professores e técnicos especializados estará com você durante toda a experiência, garantindo aprendizado com clareza, segurança e troca de conhecimento.');
    $callout_right    = apepi_get_option('apepi_fazenda_callout_right', 'O dia de imersão para conhecer do cultivo até a produção dos óleos.');

    $dest_lab_img     = get_template_directory_uri() . '/assets/faz_dest_lab.png';
    $dest_cult_img    = get_template_directory_uri() . '/assets/faz_dest_cultivo.png';
    $dest_proc_img    = get_template_directory_uri() . '/assets/faz_dest_processos.png';

    $gal1             = get_template_directory_uri() . '/assets/faz_galeria_1.png';
    $gal2             = get_template_directory_uri() . '/assets/faz_galeria_2.png';
    $gal3             = get_template_directory_uri() . '/assets/faz_galeria_3.png';
    $gal4             = get_template_directory_uri() . '/assets/faz_galeria_4.png';
    ?>
    <div class="faz-page-exact-wrapper">

      

            <!-- ======================== 1. HERO COM DEGRADÊ ======================== -->
      <section class="hero-home-exact hero-banner-degrade faz-hero-banner">
        <div class="hero-bg-wrapper">
          <img src="<?php echo esc_url($fazenda_img); ?>" alt="Visita à Fazenda da APEPI" class="hero-bg-img">
          <div class="hero-gradient-overlay"></div>
        </div>

        <div class="container hero-container-exact">
          <div class="hero-content-exact faz-hero-content">
            <h1 class="hero-title-exact"><?php echo nl2br(esc_html($fazenda_title)); ?></h1>
            <div class="hero-green-divider"></div>
            <h2 class="faz-hero-subtitle"><?php echo esc_html($fazenda_subtitle); ?></h2>

            <p class="hero-desc-exact"><?php echo esc_html($fazenda_desc); ?></p>
            <p class="hero-desc-exact" style="margin-top:-1rem;"><?php echo esc_html($fazenda_subdesc); ?></p>

            <div class="faz-badges-row">
              <div class="faz-badge-item">
                <div class="faz-badge-icon"><i class="fa-solid fa-user-doctor"></i></div>
                <span><?php echo esc_html($badge1); ?></span>
              </div>
              <div class="faz-badge-item">
                <div class="faz-badge-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                <span><?php echo esc_html($badge2); ?></span>
              </div>
              <div class="faz-badge-item">
                <div class="faz-badge-icon"><i class="fa-solid fa-seedling"></i></div>
                <span><?php echo esc_html($badge3); ?></span>
              </div>
            </div>

            <!-- Callout Box Flutuante Verde -->
            <div class="faz-callout-box">
              <div class="faz-callout-col">
                <div class="faz-callout-icon-wrap"><i class="fa-solid fa-users"></i></div>
                <p><?php echo esc_html($callout_left); ?></p>
              </div>
              <div class="faz-callout-divider"></div>
              <div class="faz-callout-col faz-callout-col-right">
                <div class="faz-callout-icon-wrap"><i class="fa-solid fa-calendar-day"></i></div>
                <p><?php echo esc_html($callout_right); ?></p>
              </div>
            </div>

          </div>
        </div>
      </section>

      <!-- ======================== 2. DESTAQUES DA EXPERIÊNCIA ======================== -->
      <section class="faz-destaques-section">
        <div class="container">
          <div class="faz-destaques-header text-center">
            <h2 class="faz-destaques-title">DESTAQUES DA EXPERIÊNCIA</h2>
            <div class="faz-destaques-line"></div>
          </div>

          <div class="faz-destaques-grid">
            
            <div class="faz-dest-card">
              <div class="faz-dest-photo-wrap">
                <img src="<?php echo esc_url($dest_lab_img); ?>" alt="Laboratório de extração" class="faz-dest-img">
                <div class="faz-dest-badge-icon"><i class="fa-solid fa-flask-vial"></i></div>
              </div>
              <div class="faz-dest-card-body">
                <h3 class="faz-dest-card-title">Laboratório<br>de extração</h3>
                <p class="faz-dest-card-text">Conheça nosso laboratório e acompanhe o processo de extração e controle de qualidade dos óleos.</p>
              </div>
            </div>

            <div class="faz-dest-card">
              <div class="faz-dest-photo-wrap">
                <img src="<?php echo esc_url($dest_lab_img); ?>" alt="Laboratório de extração" class="faz-dest-img">
                <div class="faz-dest-badge-icon"><i class="fa-solid fa-flask"></i></div>
              </div>
              <div class="faz-dest-card-body">
                <h3 class="faz-dest-card-title">Laboratório<br>de extração</h3>
                <p class="faz-dest-card-text">Conheça nosso laboratório e acompanhe o processo de extração e controle de qualidade dos óleos.</p>
              </div>
            </div>

            <div class="faz-dest-card">
              <div class="faz-dest-photo-wrap">
                <img src="<?php echo esc_url($dest_cult_img); ?>" alt="Cultivo com excelência" class="faz-dest-img">
                <div class="faz-dest-badge-icon"><i class="fa-solid fa-seedling"></i></div>
              </div>
              <div class="faz-dest-card-body">
                <h3 class="faz-dest-card-title">Cultivo com<br>excelência</h3>
                <p class="faz-dest-card-text">Visite o matrizário, berçário e as áreas de cultivo em ambiente controlado e sustentável.</p>
              </div>
            </div>

            <div class="faz-dest-card">
              <div class="faz-dest-photo-wrap">
                <img src="<?php echo esc_url($dest_proc_img); ?>" alt="Processos completos" class="faz-dest-img">
                <div class="faz-dest-badge-icon"><i class="fa-solid fa-leaf"></i></div>
              </div>
              <div class="faz-dest-card-body">
                <h3 class="faz-dest-card-title">Processos<br>completos</h3>
                <p class="faz-dest-card-text">Acompanhe cada etapa: germinação, crescimento, colheita, secagem e beneficiamento.</p>
              </div>
            </div>

            <div class="faz-dest-card">
              <div class="faz-dest-photo-wrap">
                <img src="<?php echo esc_url($dest_lab_img); ?>" alt="Laboratório de extração" class="faz-dest-img">
                <div class="faz-dest-badge-icon"><i class="fa-solid fa-flask-vial"></i></div>
              </div>
              <div class="faz-dest-card-body">
                <h3 class="faz-dest-card-title">Laboratório<br>de extração</h3>
                <p class="faz-dest-card-text">Conheça nosso laboratório e acompanhe o processo de extração e controle de qualidade dos óleos.</p>
              </div>
            </div>

            <div class="faz-dest-card">
              <div class="faz-dest-photo-wrap">
                <img src="<?php echo esc_url($dest_lab_img); ?>" alt="Laboratório de extração" class="faz-dest-img">
                <div class="faz-dest-badge-icon"><i class="fa-solid fa-flask"></i></div>
              </div>
              <div class="faz-dest-card-body">
                <h3 class="faz-dest-card-title">Laboratório<br>de extração</h3>
                <p class="faz-dest-card-text">Conheça nosso laboratório e acompanhe o processo de extração e controle de qualidade dos óleos.</p>
              </div>
            </div>

            <div class="faz-dest-card">
              <div class="faz-dest-photo-wrap">
                <img src="<?php echo esc_url($dest_cult_img); ?>" alt="Cultivo com excelência" class="faz-dest-img">
                <div class="faz-dest-badge-icon"><i class="fa-solid fa-seedling"></i></div>
              </div>
              <div class="faz-dest-card-body">
                <h3 class="faz-dest-card-title">Cultivo com<br>excelência</h3>
                <p class="faz-dest-card-text">Visite o matrizário, berçário e as áreas de cultivo em ambiente controlado e sustentável.</p>
              </div>
            </div>

            <div class="faz-dest-card">
              <div class="faz-dest-photo-wrap">
                <img src="<?php echo esc_url($dest_proc_img); ?>" alt="Processos completos" class="faz-dest-img">
                <div class="faz-dest-badge-icon"><i class="fa-solid fa-leaf"></i></div>
              </div>
              <div class="faz-dest-card-body">
                <h3 class="faz-dest-card-title">Processos<br>completos</h3>
                <p class="faz-dest-card-text">Acompanhe cada etapa: germinação, crescimento, colheita, secagem e beneficiamento.</p>
              </div>
            </div>

          </div>
        </div>
      </section>

      <!-- ======================== 3. LOGÍSTICA & INCLUSÕES ======================== -->
      <section class="faz-logistica-section">
        <div class="container">
          <div class="faz-logistica-grid">
            
            <div class="faz-log-item">
              <div class="faz-log-icon"><i class="fa-solid fa-bus"></i></div>
              <div class="faz-log-info">
                <h4>Transporte<br>(ida e volta)</h4>
                <p>Transporte confortável e seguro, com saída do Rio.</p>
              </div>
            </div>

            <div class="faz-log-item">
              <div class="faz-log-icon"><i class="fa-solid fa-utensils"></i></div>
              <div class="faz-log-info">
                <h4>Alimentação completa</h4>
                <p>Café da manhã, almoço e lanche da tarde na fazenda.</p>
              </div>
            </div>

            <div class="faz-log-item">
              <div class="faz-log-icon"><i class="fa-solid fa-shield-halved"></i></div>
              <div class="faz-log-info">
                <h4>Equipamentos<br>de proteção (EPI)</h4>
                <p>Fornecidos para sua segurança durante toda a visita.</p>
              </div>
            </div>

          </div>
        </div>
      </section>

      <!-- ======================== 4. GALERIA DE FOTOS ======================== -->
      <section class="faz-galeria-section">
        <div class="container">
          <div class="faz-galeria-grid">
            <div class="faz-gal-item"><img src="<?php echo esc_url($gal1); ?>" alt="Estufa de cultivo"></div>
            <div class="faz-gal-item"><img src="<?php echo esc_url($gal2); ?>" alt="Florescimento"></div>
            <div class="faz-gal-item"><img src="<?php echo esc_url($gal3); ?>" alt="Vista aérea da fazenda"></div>
            <div class="faz-gal-item"><img src="<?php echo esc_url($gal4); ?>" alt="Extração em laboratório"></div>
          </div>
        </div>
      </section>

      <!-- ======================== 5. CTA BANNER ======================== -->
      <section class="faz-cta-banner">
        <div class="container faz-cta-container">
          <div class="faz-cta-left">
            <div class="faz-cta-leaf-icon"><i class="fa-solid fa-leaf"></i></div>
            <p class="faz-cta-text">Viva uma experiência única e transforme seu conhecimento em prática responsável.</p>
          </div>
          <div class="faz-cta-right">
            <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $wa_num)); ?>" target="_blank" class="btn btn-faz-cta">
              QUERO PARTICIPAR DA VISITA
            </a>
            <span class="faz-vagas-badge">Vagas limitadas</span>
          </div>
        </div>
      </section>

    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('apepi_pagina_fazenda', 'apepi_shortcode_pagina_fazenda');


// 8. Shortcode Depoimentos de Alunos
function apepi_shortcode_depoimentos($atts) {
    $atts = shortcode_atts(array(
        'limit' => 3,
        'title' => 'O Que Dizem Nossos Formandos',
        'badge' => 'DEPOIMENTOS DE ALUNOS',
        'sub'   => 'A experiência de médicos e profissionais que transformaram sua prática clínica com a APEPI Escola.'
    ), $atts);

    $limit = intval($atts['limit']);
    if ($limit <= 0) $limit = 3;

    $args = array(
        'post_type'      => array('depoimento', 'depoimentos', 'jet-engine-depoimento'),
        'posts_per_page' => $limit,
        'post_status'    => 'publish'
    );
    $query = new WP_Query($args);

    ob_start();
    ?>
    <section class="course-testimonials-section">
      <div class="container">
        <div class="testimonials-header text-center">
          <?php if (!empty($atts['badge'])) : ?><div class="section-badge"><?php echo esc_html($atts['badge']); ?></div><?php endif; ?>
          <?php if (!empty($atts['title'])) : ?><h2 class="section-main-title"><?php echo esc_html($atts['title']); ?></h2><?php endif; ?>
          <?php if (!empty($atts['sub'])) : ?><p class="section-subtitle"><?php echo esc_html($atts['sub']); ?></p><?php endif; ?>
        </div>

        <div class="course-testimonials-grid">
          <?php
          if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
              $d_id    = get_the_ID();
              $d_cargo = get_post_meta($d_id, '_depoimento_cargo', true);
              if (!$d_cargo) $d_cargo = get_post_meta($d_id, 'cargo', true);
              $d_thumb = has_post_thumbnail($d_id) ? get_the_post_thumbnail_url($d_id, 'large') : 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=600&q=80';
              ?>
              <div class="course-testimonial-card">
                <div class="test-video-thumb">
                  <img src="<?php echo esc_url($d_thumb); ?>" alt="<?php the_title_attribute(); ?>">
                  <button class="test-play-btn" aria-label="Assistir Depoimento"><i class="fa-solid fa-play"></i></button>
                </div>
                <div class="test-card-content">
                  <div class="test-stars">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                  </div>
                  <p class="test-quote">"<?php echo esc_html(wp_strip_all_tags(get_the_content())); ?>"</p>
                  <div class="test-author-info">
                    <h4 class="test-author-name"><?php the_title(); ?></h4>
                    <?php if (!empty($d_cargo)) : ?><p class="test-author-role"><?php echo esc_html($d_cargo); ?></p><?php endif; ?>
                  </div>
                </div>
              </div>
              <?php
            endwhile;
            wp_reset_postdata();
          else :
            ?>
            <div class="course-testimonial-card">
              <div class="test-video-thumb">
                <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=600&q=80" alt="Dra. Mariana Costa">
                <button class="test-play-btn" aria-label="Assistir Depoimento"><i class="fa-solid fa-play"></i></button>
              </div>
              <div class="test-card-content">
                <div class="test-stars">
                  <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="test-quote">"O curso me deu total segurança técnica e respaldo ético para começar a prescrever Cannabis aos meus pacientes neurológicos. A imersão na fazenda foi um divisor de águas."</p>
                <div class="test-author-info">
                  <h4 class="test-author-name">Dra. Mariana Costa</h4>
                  <p class="test-author-role">Médica Neurologista • CRM 52 98412-1</p>
                </div>
              </div>
            </div>

            <div class="course-testimonial-card">
              <div class="test-video-thumb">
                <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=600&q=80" alt="Dr. Roberto Albuquerque">
                <button class="test-play-btn" aria-label="Assistir Depoimento"><i class="fa-solid fa-play"></i></button>
              </div>
              <div class="test-card-content">
                <div class="test-stars">
                  <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="test-quote">"A clareza dos professores e o rigor científico das aulas superaram minhas expectativas. Hoje consigo acompanhar a evolução dos pacientes com muito mais precisão."</p>
                <div class="test-author-info">
                  <h4 class="test-author-name">Dr. Roberto Albuquerque</h4>
                  <p class="test-author-role">Médico Psiquiatra • CRM 52 44781-0</p>
                </div>
              </div>
            </div>

            <div class="course-testimonial-card">
              <div class="test-video-thumb">
                <img src="https://images.unsplash.com/photo-1651008376811-b90baee60c1f?auto=format&fit=crop&w=600&q=80" alt="Dra. Luciana Paiva">
                <button class="test-play-btn" aria-label="Assistir Depoimento"><i class="fa-solid fa-play"></i></button>
              </div>
              <div class="test-card-content">
                <div class="test-stars">
                  <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="test-quote">"Ver a seriedade do laboratório de extração e a conexão com a prática clínica me deu a certeza de que a APEPI Escola é a maior referência do país no tema."</p>
                <div class="test-author-info">
                  <h4 class="test-author-name">Dra. Luciana Paiva</h4>
                  <p class="test-author-role">Médica de Família e Comunidade • CRM 52 61209-3</p>
                </div>
              </div>
            </div>
            <?php
          endif;
          ?>
        </div>
      </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('apepi_depoimentos', 'apepi_shortcode_depoimentos');
add_shortcode('apepi_depoimentos_grid', 'apepi_shortcode_depoimentos');


// ==========================================================================
// SISTEMA NATIVO DE BREADCRUMBS DO WORDPRESS (APEPI ESCOLA)
// ==========================================================================
function apepi_breadcrumbs() {
    // Se estiver na Home / Front Page, não exibe breadcrumb
    if (is_front_page() || is_home()) {
        return;
    }

    // Suporte a plugins de SEO consagrados (Yoast, RankMath) se ativos
    if (function_exists('yoast_breadcrumb')) {
        yoast_breadcrumb('<nav class="apepi-breadcrumbs-nav" aria-label="Breadcrumb"><div class="container">', '</div></nav>');
        return;
    }
    if (function_exists('rank_math_the_breadcrumbs')) {
        rank_math_the_breadcrumbs();
        return;
    }

    // Breadcrumbs Nativos APEPI
    $separator = '<span class="breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span>';
    $home_title = 'Início';
    
    echo '<nav class="apepi-breadcrumbs-nav" aria-label="Breadcrumbs">';
    echo '<div class="container breadcrumbs-container">';
    echo '<span class="breadcrumb-item"><a href="' . esc_url(home_url('/')) . '"><i class="fa-solid fa-house-chimney"></i> ' . esc_html($home_title) . '</a></span>';

    if (is_singular('curso') || is_singular('cursos')) {
        echo $separator;
        echo '<span class="breadcrumb-item"><a href="' . esc_url(home_url('/#cursos')) . '">Cursos</a></span>';
        echo $separator;
        echo '<span class="breadcrumb-item active" aria-current="page">' . esc_html(get_the_title()) . '</span>';
    } elseif (is_singular('post')) {
        $cats = get_the_category();
        if (!empty($cats)) {
            echo $separator;
            echo '<span class="breadcrumb-item"><a href="' . esc_url(get_category_link($cats[0]->term_id)) . '">' . esc_html($cats[0]->name) . '</a></span>';
        }
        echo $separator;
        echo '<span class="breadcrumb-item active" aria-current="page">' . esc_html(get_the_title()) . '</span>';
    } elseif (is_page()) {
        global $post;
        if ($post->post_parent) {
            $anc = get_post_ancestors($post->ID);
            $anc = array_reverse($anc);
            foreach ($anc as $ancestor) {
                echo $separator;
                echo '<span class="breadcrumb-item"><a href="' . esc_url(get_permalink($ancestor)) . '">' . esc_html(get_the_title($ancestor)) . '</a></span>';
            }
        }
        echo $separator;
        echo '<span class="breadcrumb-item active" aria-current="page">' . esc_html(get_the_title()) . '</span>';
    } elseif (is_category()) {
        echo $separator;
        echo '<span class="breadcrumb-item active" aria-current="page">' . single_cat_title('', false) . '</span>';
    } elseif (is_tag()) {
        echo $separator;
        echo '<span class="breadcrumb-item active" aria-current="page">' . single_tag_title('', false) . '</span>';
    } elseif (is_search()) {
        echo $separator;
        echo '<span class="breadcrumb-item active" aria-current="page">Busca: "' . get_search_query() . '"</span>';
    } elseif (is_404()) {
        echo $separator;
        echo '<span class="breadcrumb-item active" aria-current="page">Página Não Encontrada</span>';
    } elseif (is_archive()) {
        echo $separator;
        echo '<span class="breadcrumb-item active" aria-current="page">' . get_the_archive_title() . '</span>';
    }

    echo '</div>';
    echo '</nav>';
}
add_shortcode('apepi_breadcrumbs', function() {
    ob_start();
    apepi_breadcrumbs();
    return ob_get_clean();
});


// ==========================================================================
// SHORTCODES E PÁGINAS CUSTOMIZÁVEIS: NOSSOS CURSOS & CONTATO
// ==========================================================================

// Shortcode: Números e Estatísticas da Escola
function apepi_shortcode_escola_numeros() {
    $years   = apepi_get_option('apepi_stat_exp_years', '10+');
    $profs   = apepi_get_option('apepi_stat_professors', '40+');
    $stud    = apepi_get_option('apepi_stat_students', '5.000+');
    $states  = apepi_get_option('apepi_stat_states', '27');
    $hours   = apepi_get_option('apepi_stat_hours', '300+');
    $cases   = apepi_get_option('apepi_stat_cases', '1.000+');

    ob_start();
    ?>
    <section class="nc-stats-bar">
      <div class="container">
        <div class="nc-stats-grid">
          <div class="nc-stat-item">
            <div class="nc-stat-icon"><i class="fa-solid fa-award"></i></div>
            <div class="nc-stat-num"><?php echo esc_html($years); ?></div>
            <div class="nc-stat-label">Anos de experiência da APEPI</div>
          </div>
          <div class="nc-stat-item">
            <div class="nc-stat-icon"><i class="fa-solid fa-user-doctor"></i></div>
            <div class="nc-stat-num"><?php echo esc_html($profs); ?></div>
            <div class="nc-stat-label">Professores pesquisadores</div>
          </div>
          <div class="nc-stat-item">
            <div class="nc-stat-icon"><i class="fa-solid fa-user-graduate"></i></div>
            <div class="nc-stat-num"><?php echo esc_html($stud); ?></div>
            <div class="nc-stat-label">Alunos capacitados no Brasil</div>
          </div>
          <div class="nc-stat-item">
            <div class="nc-stat-icon"><i class="fa-solid fa-clock"></i></div>
            <div class="nc-stat-num"><?php echo esc_html($hours); ?></div>
            <div class="nc-stat-label">Horas de conteúdo especializado</div>
          </div>
        </div>
      </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('apepi_escola_numeros', 'apepi_shortcode_escola_numeros');


// Shortcode: Banner E-Books Gratuitos (Grid de Cards Profissionais)
function apepi_shortcode_banner_ebooks() {
    $eb_title    = apepi_get_option('apepi_nc_ebook_title', 'Materiais Gratuitos APEPI');
    $eb_sub      = apepi_get_option('apepi_nc_ebook_subtitle', 'Baixe nossos E-books e guias práticos sobre Cannabis Medicinal e amplie seu conhecimento.');
    $eb_btn      = apepi_get_option('apepi_nc_ebook_btn', 'BAIXAR TODOS OS E-BOOKS');
    $eb_url      = apepi_get_option('apepi_nc_ebook_url', '#ebooks');

    ob_start();
    ?>
    <section class="nc-ebooks-banner-section" id="ebooks">
      <div class="container">
        <div class="nc-ebooks-header text-center">
          <span class="nc-badge-gold"><i class="fa-solid fa-book-open"></i> MATERIAL DE APOIO</span>
          <h2 class="nc-ebooks-title"><?php echo esc_html($eb_title); ?></h2>
          <p class="nc-ebooks-sub"><?php echo esc_html($eb_sub); ?></p>
        </div>

        <div class="nc-ebooks-cards-grid">
          
          <div class="nc-ebook-card-box">
            <div class="nc-ebook-badge">PRESCRIÇÃO</div>
            <div class="nc-ebook-icon-wrap"><i class="fa-solid fa-book-medical"></i></div>
            <h4>Guia Prático de Prescrição</h4>
            <p>Posologia, terpenos, canabinoides e acompanhamento clínico de pacientes.</p>
            <a href="<?php echo esc_url($eb_url); ?>" class="btn-ebook-download"><i class="fa-solid fa-download"></i> Baixar E-book</a>
          </div>

          <div class="nc-ebook-card-box">
            <div class="nc-ebook-badge">LEGISLAÇÃO</div>
            <div class="nc-ebook-icon-wrap"><i class="fa-solid fa-scale-balanced"></i></div>
            <h4>Aspectos Jurídicos & Regulatórios</h4>
            <p>Habeas Corpus, direitos do paciente e regulamentação da Anvisa.</p>
            <a href="<?php echo esc_url($eb_url); ?>" class="btn-ebook-download"><i class="fa-solid fa-download"></i> Baixar E-book</a>
          </div>

          <div class="nc-ebook-card-box">
            <div class="nc-ebook-badge">CULTIVO</div>
            <div class="nc-ebook-icon-wrap"><i class="fa-solid fa-seedling"></i></div>
            <h4>Cultivo & Extração Medicinal</h4>
            <p>Boas práticas agrícolas, controle de qualidade e extração artesanal segura.</p>
            <a href="<?php echo esc_url($eb_url); ?>" class="btn-ebook-download"><i class="fa-solid fa-download"></i> Baixar E-book</a>
          </div>

        </div>

        <div class="nc-ebooks-footer-action text-center">
          <a href="<?php echo esc_url($eb_url); ?>" class="btn btn-primary btn-lg nc-ebooks-master-btn">
            <i class="fa-solid fa-file-pdf"></i> <?php echo esc_html($eb_btn); ?>
          </a>
        </div>
      </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('apepi_banner_ebooks', 'apepi_shortcode_banner_ebooks');


// Shortcode: Template da Página "Nossos Cursos" (100% Fiel à Imagem de Referência)
function apepi_shortcode_pagina_nossos_cursos() {
    ob_start();
    $assets_url = get_template_directory_uri() . '/assets/';

    // Opções do Customizer (Catálogo & Header)
    $catalog_sub = apepi_get_option('apepi_nc_catalog_sub', 'NOSSO CATÁLOGO');
    $main_title  = apepi_get_option('apepi_nc_main_title', 'FORMAÇÕES');

    // Opções do Customizer (Estatísticas / Números)
    $num_tag    = apepi_get_option('apepi_nc_numeros_tag', '🌿 APEPI ESCOLA EM NÚMEROS 🌿');
    $n1_big     = apepi_get_option('apepi_nc_num1_big', '14 anos');
    $n1_desc    = apepi_get_option('apepi_nc_num1_desc', 'de experiência na educação canábica');
    $n2_big     = apepi_get_option('apepi_nc_num2_big', '+1000');
    $n2_desc    = apepi_get_option('apepi_nc_num2_desc', 'alunos formados e preparados para fazer a diferença');
    $n3_big     = apepi_get_option('apepi_nc_num3_big', '+10h');
    $n3_sub     = apepi_get_option('apepi_nc_num3_sub', 'de conteúdo');
    $n3_desc    = apepi_get_option('apepi_nc_num3_desc', 'aulas online e ao vivo com especialistas referência na área');
    $n4_title   = apepi_get_option('apepi_nc_num4_title', 'Formação completa');
    $n4_desc    = apepi_get_option('apepi_nc_num4_desc', 'da teoria à prática, com segurança e responsabilidade');
    $n5_title   = apepi_get_option('apepi_nc_num5_title', 'E-books gratuitos');
    $n5_desc    = apepi_get_option('apepi_nc_num5_desc', 'materiais exclusivos para aprofundar seu conhecimento');

    // Opções do Customizer (Depoimentos)
    $dep_tag    = apepi_get_option('apepi_nc_dep_tag', '🌿 DEPOIMENTOS 🌿');
    $dep_title  = apepi_get_option('apepi_nc_dep_title', 'O que nossos alunos dizem');
    $dep_sub    = apepi_get_option('apepi_nc_dep_sub', 'Histórias reais de médicos, veterinários e profissionais que transformaram sua prática com o conhecimento em Cannabis Medicinal.');

    // Opções do Customizer (Banner E-books & Rodapé)
    $eb_title   = apepi_get_option('apepi_nc_ebook_title', 'Conhecimento que vai além da sala de aula');
    $eb_sub     = apepi_get_option('apepi_nc_ebook_sub', 'Acesse nossos e-books gratuitos e aprofunde ainda mais seus estudos sobre Cannabis Medicinal.');
    $eb_btn     = apepi_get_option('apepi_nc_ebook_btn', 'BAIXAR E-BOOKS GRATUITOS');
    $eb_url     = apepi_get_option('apepi_nc_ebook_url', '#ebooks');
    $foot_text  = apepi_get_option('apepi_nc_foot_text', 'APEPI Escola – Transformando conhecimento em cuidado e qualidade de vida. Junte-se a mais de 1000 alunos e faça parte dessa história.');

    // WP_Query Dinâmica para Cursos
    $args_cursos = array(
        'post_type'      => array('curso', 'cursos', 'jet-engine-curso'),
        'posts_per_page' => 4,
        'post_status'    => 'publish',
    );
    $query_cursos = new WP_Query($args_cursos);

    // Cursos Padrão (Fallback visual de paridade)
    $default_courses = array(
        array(
            'img'   => $assets_url . 'hero_doctor_medical_desk.png',
            'title' => 'Cannabis Medicinal na Rotina do Profissional De Saúde',
            'desc'  => 'Associação pioneira em Cannabis Medicinal no Brasil, lançou agora um curso exclusivo para veterinários.',
            'url'   => '/cursos/saude',
        ),
        array(
            'img'   => $assets_url . 'course_vet_dog.png',
            'title' => 'Uso Veterinário de Cannabis',
            'desc'  => 'Associação pioneira em Cannabis Medicinal no Brasil, lançou agora um curso exclusivo para veterinários.',
            'url'   => '/cursos/veterinaria',
        ),
        array(
            'img'   => $assets_url . 'course_family_farm.png',
            'title' => 'Cultivo & Extração - De Família para Família',
            'desc'  => 'Aprenda a cultivar na prática com carinho e segurança, com quem já testou e validou cada passo.',
            'url'   => '/fazenda',
        ),
        array(
            'img'   => $assets_url . 'course_farm_visit.png',
            'title' => 'Curso de Prescrição Medicinal de Cannabis',
            'desc'  => 'São 12 edições aprovadas e reconhecidas por médicos em todo o Brasil.',
            'url'   => '/cursos/prescricao',
        ),
    );

    // WP_Query Dinâmica para Depoimentos
    $args_dep = array(
        'post_type'      => array('depoimento', 'depoimentos', 'jet-engine-depoimento'),
        'posts_per_page' => 3,
        'post_status'    => 'publish',
    );
    $query_dep = new WP_Query($args_dep);

    $default_testimonials = array(
        array(
            'img'   => $assets_url . 'avatar_doctor_1.png',
            'text'  => 'O curso mudou completamente minha visão sobre o tratamento com Cannabis. Hoje me sinto seguro para prescrever e acompanhar meus pacientes com muito mais consciência e resultados.',
            'name'  => 'Dr. Rafael M.',
            'role'  => 'Médico',
        ),
        array(
            'img'   => $assets_url . 'avatar_vet_1.png',
            'text'  => 'Conteúdo completo, professores excelentes e uma didática que facilita o entendimento mesmo dos temas mais complexos. Recomendo de olhos fechados!',
            'name'  => 'Dra. Juliana T.',
            'role'  => 'Médica Veterinária',
        ),
        array(
            'img'   => $assets_url . 'avatar_doctor_2.png',
            'text'  => 'A parte prática e a visita à fazenda foram experiências incríveis que fizeram toda a diferença na minha formação. Um curso que vai muito além da teoria.',
            'name'  => 'Dr. Lucas P.',
            'role'  => 'Médico',
        ),
    );
    ?>
    <div class="ref-nc-wrapper">
      
      <!-- SEÇÃO FORMAÇÕES (CATÁLOGO + SLIDER ARROWS) -->
      <section class="ref-nc-formacoes-section">
        <div class="container">
          
          <div class="ref-nc-header-row">
            <div class="ref-nc-title-block">
              <span class="ref-nc-catalog-sub"><?php echo esc_html($catalog_sub); ?></span>
              <h1 class="ref-nc-main-title"><?php echo esc_html($main_title); ?></h1>
            </div>
            <div class="ref-nc-nav-arrows">
              <button class="ref-arrow-btn ref-arrow-prev" aria-label="Anterior"><i class="fa-solid fa-chevron-left"></i></button>
              <button class="ref-arrow-btn ref-arrow-next" aria-label="Próximo"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
          </div>

          <!-- GRID DE CARDS DE CURSOS -->
          <div class="ref-nc-formacoes-grid">
            <?php
            $rendered_count = 0;
            if ($query_cursos->have_posts()) :
              while ($query_cursos->have_posts()) : $query_cursos->the_post();
                $rendered_count++;
                $icone = apepi_get_course_meta(get_the_ID(), 'icone', 'fa-solid fa-cannabis');
                $thumb = apepi_get_course_thumb_image(get_the_ID());
                ?>
                <div class="ref-course-card">
                  <div class="ref-course-img-wrap">
                    <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>">
                    <div class="ref-course-leaf-badge"><i class="<?php echo esc_attr($icone); ?>"></i></div>
                  </div>
                  <div class="ref-course-body">
                    <h3><?php the_title(); ?></h3>
                    <p><?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?></p>
                    <a href="<?php the_permalink(); ?>" class="ref-course-link">SAIBA MAIS &rarr;</a>
                  </div>
                </div>
                <?php
              endwhile;
              wp_reset_postdata();
            endif;

            // Preenchimento com Fallback para Garantir a Grade Completa de 4 Cards
            if ($rendered_count < 4) {
              for ($i = $rendered_count; $i < 4; $i++) {
                $card = $default_courses[$i];
                ?>
                <div class="ref-course-card">
                  <div class="ref-course-img-wrap">
                    <img src="<?php echo esc_url($card['img']); ?>" alt="<?php echo esc_attr($card['title']); ?>">
                    <div class="ref-course-leaf-badge"><i class="fa-solid fa-cannabis"></i></div>
                  </div>
                  <div class="ref-course-body">
                    <h3><?php echo esc_html($card['title']); ?></h3>
                    <p><?php echo esc_html($card['desc']); ?></p>
                    <a href="<?php echo esc_url($card['url']); ?>" class="ref-course-link">SAIBA MAIS &rarr;</a>
                  </div>
                </div>
                <?php
              }
            }
            ?>
          </div>

          <!-- PROGRESS BAR SLIDER KNOB -->
          <div class="ref-nc-progress-bar">
            <div class="ref-nc-progress-track">
              <div class="ref-nc-progress-knob"></div>
            </div>
          </div>

        </div>
      </section>

      <!-- SEÇÃO APEPI ESCOLA EM NÚMEROS -->
      <section class="ref-nc-numeros-section">
        <div class="container">
          <div class="ref-nc-section-tag text-center">
            <span><?php echo esc_html($num_tag); ?></span>
          </div>
          <div class="ref-nc-numeros-grid">
            
            <div class="ref-num-item">
              <div class="ref-num-icon"><i class="fa-solid fa-award"></i></div>
              <h2 class="ref-num-big"><?php echo esc_html($n1_big); ?></h2>
              <p class="ref-num-desc"><?php echo esc_html($n1_desc); ?></p>
            </div>

            <div class="ref-num-item">
              <div class="ref-num-icon"><i class="fa-solid fa-users"></i></div>
              <h2 class="ref-num-big"><?php echo esc_html($n2_big); ?></h2>
              <p class="ref-num-desc"><?php echo esc_html($n2_desc); ?></p>
            </div>

            <div class="ref-num-item">
              <div class="ref-num-icon"><i class="fa-solid fa-circle-play"></i></div>
              <h2 class="ref-num-big"><?php echo esc_html($n3_big); ?></h2>
              <?php if (!empty($n3_sub)) : ?><p class="ref-num-sub-label"><?php echo esc_html($n3_sub); ?></p><?php endif; ?>
              <p class="ref-num-desc"><?php echo esc_html($n3_desc); ?></p>
            </div>

            <div class="ref-num-item">
              <div class="ref-num-icon"><i class="fa-solid fa-cannabis"></i></div>
              <h2 class="ref-num-title"><?php echo esc_html($n4_title); ?></h2>
              <p class="ref-num-desc"><?php echo esc_html($n4_desc); ?></p>
            </div>

            <div class="ref-num-item">
              <div class="ref-num-icon"><i class="fa-solid fa-download"></i></div>
              <h2 class="ref-num-title"><?php echo esc_html($n5_title); ?></h2>
              <p class="ref-num-desc"><?php echo esc_html($n5_desc); ?></p>
            </div>

          </div>
        </div>
      </section>

      <!-- SEÇÃO DEPOIMENTOS -->
      <section class="ref-nc-depoimentos-section">
        <div class="container">
          <div class="ref-nc-dep-header text-center">
            <span class="ref-nc-section-tag"><?php echo esc_html($dep_tag); ?></span>
            <h2 class="ref-nc-dep-title"><?php echo esc_html($dep_title); ?></h2>
            <p class="ref-nc-dep-sub"><?php echo esc_html($dep_sub); ?></p>
          </div>

          <div class="ref-nc-dep-grid">
            <?php
            $dep_rendered = 0;
            if ($query_dep->have_posts()) :
              while ($query_dep->have_posts()) : $query_dep->the_post();
                $dep_rendered++;
                $role = get_post_meta(get_the_ID(), 'cargo', true);
                if (empty($role)) $role = get_post_meta(get_the_ID(), 'role', true);
                if (empty($role)) $role = 'Aluno APEPI';
                $avatar = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                if (empty($avatar)) $avatar = $assets_url . 'avatar_doctor_1.png';
                ?>
                <div class="ref-dep-card">
                  <div class="ref-dep-quote">&ldquo;</div>
                  <p class="ref-dep-text"><?php echo get_the_content(); ?></p>
                  <div class="ref-dep-profile">
                    <img src="<?php echo esc_url($avatar); ?>" alt="<?php the_title_attribute(); ?>">
                    <div class="ref-dep-info">
                      <strong><?php the_title(); ?></strong>
                      <span><?php echo esc_html($role); ?></span>
                    </div>
                  </div>
                </div>
                <?php
              endwhile;
              wp_reset_postdata();
            endif;

            // Fallback para Depoimentos
            if ($dep_rendered < 3) {
              for ($j = $dep_rendered; $j < 3; $j++) {
                $dep = $default_testimonials[$j];
                ?>
                <div class="ref-dep-card">
                  <div class="ref-dep-quote">&ldquo;</div>
                  <p class="ref-dep-text"><?php echo esc_html($dep['text']); ?></p>
                  <div class="ref-dep-profile">
                    <img src="<?php echo esc_url($dep['img']); ?>" alt="<?php echo esc_attr($dep['name']); ?>">
                    <div class="ref-dep-info">
                      <strong><?php echo esc_html($dep['name']); ?></strong>
                      <span><?php echo esc_html($dep['role']); ?></span>
                    </div>
                  </div>
                </div>
                <?php
              }
            }
            ?>
          </div>

          <div class="ref-dep-nav-row text-right">
            <button class="ref-arrow-btn ref-arrow-prev" aria-label="Anterior"><i class="fa-solid fa-chevron-left"></i></button>
            <button class="ref-arrow-btn ref-arrow-next" aria-label="Próximo"><i class="fa-solid fa-chevron-right"></i></button>
          </div>

        </div>
      </section>

      <!-- BANNER E-BOOKS GRATUITOS -->
      <section class="ref-nc-ebook-banner-section">
        <div class="container">
          <div class="ref-nc-ebook-box">
            
            <div class="ref-nc-ebook-left">
              <img src="<?php echo esc_url($assets_url . 'ebook_cannabis_vida.png'); ?>" alt="E-books Cannabis e a Vida" class="ref-ebook-3d-img">
            </div>

            <div class="ref-nc-ebook-center">
              <h2><?php echo esc_html($eb_title); ?></h2>
              <p><?php echo esc_html($eb_sub); ?></p>
            </div>

            <div class="ref-nc-ebook-right">
              <a href="<?php echo esc_url($eb_url); ?>" class="ref-btn-download-green">
                <i class="fa-solid fa-download"></i> <?php echo esc_html($eb_btn); ?>
              </a>
              <span class="ref-ebook-guarantee"><i class="fa-solid fa-lock"></i> 100% gratuitos e seguros.</span>
            </div>

          </div>
        </div>
      </section>

      <!-- BANNER RODAPÉ INSTITUCIONAL -->
      <section class="ref-nc-footer-banner">
        <div class="container">
          <div class="ref-nc-foot-box">
            <div class="ref-foot-left">
              <img src="<?php echo esc_url($assets_url . 'logo_apepi_escola.png'); ?>" alt="APEPI Escola" class="ref-foot-logo">
              <p><?php echo esc_html($foot_text); ?></p>
            </div>
            <div class="ref-foot-right">
              <button class="ref-heart-btn" title="Favoritar"><i class="fa-regular fa-heart"></i></button>
            </div>
          </div>
        </div>
      </section>

    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('apepi_pagina_nossos_cursos', 'apepi_shortcode_pagina_nossos_cursos');
add_shortcode('apepi_shortcode_pagina_nossos_cursos', 'apepi_shortcode_pagina_nossos_cursos');
add_shortcode('apepi_nossos_cursos', 'apepi_shortcode_pagina_nossos_cursos');


// Shortcode: Template da Página "Contato" (100% Fiel à Imagem de Referência)
function apepi_shortcode_pagina_contato() {
    $assets_url  = get_template_directory_uri() . '/assets/';

    $hero_title  = apepi_get_option('apepi_contato_hero_title', 'Contato');
    $hero_sub    = apepi_get_option('apepi_contato_hero_sub', 'Fale com a APEPI Escola');
    $hero_desc   = apepi_get_option('apepi_contato_hero_desc', 'Nossa equipe está pronta para te atender e ajudar você a escolher o melhor caminho na formação em Cannabis Medicinal.');

    $c1_title    = apepi_get_option('apepi_contato_card1_title', 'Fale com nossa secretaria');
    $c1_desc     = apepi_get_option('apepi_contato_card1_desc', 'Dúvidas sobre cursos, parcerias, documentos e outros assuntos.');
    $c1_phone    = apepi_get_option('apepi_contato_card1_phone', '+55 21 97495-2236');

    $c2_title    = apepi_get_option('apepi_contato_card2_title', 'Inscrição de cursos pelo WhatsApp');
    $c2_desc     = apepi_get_option('apepi_contato_card2_desc', 'Entre em contato com um de nossos atendentes e garanta sua vaga!');
    $c2_p1       = apepi_get_option('apepi_contato_card2_phone1', '+55 21 96753-7633');
    $c2_p2       = apepi_get_option('apepi_contato_card2_phone2', '+55 21 99724-0283');

    $c3_title    = apepi_get_option('apepi_contato_card3_title', 'Acompanhe no Instagram');
    $c3_desc     = apepi_get_option('apepi_contato_card3_desc', 'Fique por dentro das novidades, conteúdos e bastidores da APEPI Escola.');
    $c3_handle   = apepi_get_option('apepi_contato_card3_handle', '@apepiescola');
    $c3_url      = apepi_get_option('apepi_contato_card3_url', 'https://instagram.com/apepiescola');

    $c4_title    = apepi_get_option('apepi_contato_card4_title', 'Envie um e-mail');
    $c4_desc     = apepi_get_option('apepi_contato_card4_desc', 'Entre em contato por e-mail.');
    $c4_email    = apepi_get_option('apepi_contato_card4_email', 'ead@apepi.org');

    $banner_text = apepi_get_option('apepi_contato_banner_text', 'Nosso compromisso é com a excelência na formação e no atendimento. Ficaremos felizes em te ajudar!');

    ob_start();
    ?>
    <div class="ref-contato-wrapper">
      
      <!-- HERO CONTATO -->
      <section class="ref-cnt-hero">
        <div class="container">
          <div class="ref-cnt-hero-grid">
            
            <!-- ESQUERDA: ATENDENTE -->
            <div class="ref-cnt-attendant-col">
              <div class="ref-cnt-attendant-wrap">
                <div class="ref-cnt-blob-bg"></div>
                <div class="ref-cnt-leaf-float">
                  <i class="fa-solid fa-cannabis"></i>
                </div>
                <img src="<?php echo esc_url($assets_url . 'contato_attendant.png'); ?>" alt="Atendimento APEPI Escola" class="ref-cnt-attendant-img">
              </div>
            </div>

            <!-- CENTRO: TÍTULOS E DESCRIÇÃO -->
            <div class="ref-cnt-center-col text-center">
              <h1 class="ref-cnt-title"><?php echo esc_html($hero_title); ?></h1>
              <h2 class="ref-cnt-subtitle"><?php echo esc_html($hero_sub); ?></h2>
              <p class="ref-cnt-desc"><?php echo esc_html($hero_desc); ?></p>
            </div>

            <!-- DIREITA: BALÃO DE DIÁLOGO E DESENHO FOLIAR -->
            <div class="ref-cnt-bubble-col">
              <div class="ref-cnt-speech-graphic-wrap">
                <div class="ref-speech-bubble-green">
                  <div class="ref-speech-inner-icons">
                    <i class="fa-solid fa-cannabis ref-speech-leaf"></i>
                    <i class="fa-solid fa-comments ref-speech-lines"></i>
                  </div>
                </div>
                <div class="ref-speech-leaf-drawing">
                  <i class="fa-solid fa-leaf"></i>
                </div>
              </div>
            </div>

          </div>
        </div>
      </section>

      <!-- GRID DE 4 CARDS LADO A LADO -->
      <section class="ref-cnt-cards-section">
        <div class="container">
          <div class="ref-cnt-cards-grid">
            
            <!-- CARD 1: SECRETARIA -->
            <div class="ref-cnt-card text-center">
              <div class="ref-cnt-icon-circle">
                <i class="fa-solid fa-headset"></i>
              </div>
              <h3><?php echo esc_html($c1_title); ?></h3>
              <p><?php echo esc_html($c1_desc); ?></p>
              <div class="ref-cnt-card-links">
                <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $c1_phone)); ?>" target="_blank" class="ref-cnt-link-green">
                  <i class="fa-brands fa-whatsapp"></i> <?php echo esc_html($c1_phone); ?>
                </a>
              </div>
            </div>

            <!-- CARD 2: WHATSAPP INSCRIÇÃO -->
            <div class="ref-cnt-card text-center">
              <div class="ref-cnt-icon-circle">
                <i class="fa-brands fa-whatsapp"></i>
              </div>
              <h3><?php echo esc_html($c2_title); ?></h3>
              <p><?php echo esc_html($c2_desc); ?></p>
              <div class="ref-cnt-card-links">
                <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $c2_p1)); ?>" target="_blank" class="ref-cnt-link-green">
                  <i class="fa-brands fa-whatsapp"></i> <?php echo esc_html($c2_p1); ?>
                </a>
                <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $c2_p2)); ?>" target="_blank" class="ref-cnt-link-green">
                  <i class="fa-brands fa-whatsapp"></i> <?php echo esc_html($c2_p2); ?>
                </a>
              </div>
            </div>

            <!-- CARD 3: INSTAGRAM -->
            <div class="ref-cnt-card text-center">
              <div class="ref-cnt-icon-circle">
                <i class="fa-brands fa-instagram"></i>
              </div>
              <h3><?php echo esc_html($c3_title); ?></h3>
              <p><?php echo esc_html($c3_desc); ?></p>
              <div class="ref-cnt-card-links">
                <a href="<?php echo esc_url($c3_url); ?>" target="_blank" class="ref-cnt-link-green">
                  <i class="fa-brands fa-instagram"></i> <?php echo esc_html($c3_handle); ?>
                </a>
              </div>
            </div>

            <!-- CARD 4: E-MAIL -->
            <div class="ref-cnt-card text-center">
              <div class="ref-cnt-icon-circle">
                <i class="fa-regular fa-envelope"></i>
              </div>
              <h3><?php echo esc_html($c4_title); ?></h3>
              <p><?php echo esc_html($c4_desc); ?></p>
              <div class="ref-cnt-card-links">
                <a href="mailto:<?php echo esc_attr($c4_email); ?>" class="ref-cnt-link-green">
                  <?php echo esc_html($c4_email); ?>
                </a>
              </div>
            </div>

          </div>
        </div>
      </section>

      <!-- BANNER COMPROMISSO -->
      <section class="ref-cnt-banner-section">
        <div class="container">
          <div class="ref-cnt-banner-box">
            <div class="ref-cnt-banner-left">
              <div class="ref-cnt-leaf-badge">
                <i class="fa-solid fa-cannabis"></i>
              </div>
              <p><?php echo esc_html($banner_text); ?></p>
            </div>
            <div class="ref-cnt-banner-divider"></div>
            <div class="ref-cnt-banner-right">
              <img src="<?php echo esc_url($assets_url . 'seedling_plant.png'); ?>" alt="Planter Sprout APEPI" class="ref-cnt-plant-img">
            </div>
          </div>
        </div>
      </section>

    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('apepi_pagina_contato', 'apepi_shortcode_pagina_contato');
add_shortcode('apepi_shortcode_pagina_contato', 'apepi_shortcode_pagina_contato');
add_shortcode('apepi_contato', 'apepi_shortcode_pagina_contato');

