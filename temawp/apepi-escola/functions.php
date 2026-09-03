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
            'apepi_footer_copyright'
        );

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $val = ($field === 'apepi_hero_title' || $field === 'apepi_hero_desc') ? sanitize_textarea_field($_POST[$field]) : sanitize_text_field($_POST[$field]);
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
    $hero_bg    = apepi_get_option('apepi_hero_bg_image', get_template_directory_uri() . '/assets/hero_lab_clean.png');

    $stat_years  = apepi_get_option('apepi_stat_exp_years', '10 anos');
    $stat_profs  = apepi_get_option('apepi_stat_professors', '120+');
    $stat_stud   = apepi_get_option('apepi_stat_students', '6.500+');
    $stat_states = apepi_get_option('apepi_stat_states', '26');
    $stat_hours  = apepi_get_option('apepi_stat_hours', '2.400+');
    $stat_cases  = apepi_get_option('apepi_stat_cases', '1.500+');
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
        'default'           => get_template_directory_uri() . '/assets/hero_lab_clean.png',
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

    $wp_customize->add_setting('apepi_stat_cases', array(
        'default'           => '1.500+',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'theme_mod',
    ));
    $wp_customize->add_control('apepi_stat_cases', array(
        'label'    => __('Casos Clínicos Discutidos', 'apepi-escola'),
        'section'  => 'apepi_stats_section',
        'type'     => 'text',
    ));
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
          <h1 class="font-serif course-title-p2"><?php echo esc_html(get_the_title($post_id)); ?></h1>
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
            <?php if (!empty($atts['title'])) : ?><h2 class="section-main-title font-serif"><?php echo esc_html($atts['title']); ?></h2><?php endif; ?>
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
                    <h3 class="font-serif"><?php the_title(); ?></h3>
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
                  <h3 class="font-serif">Prescrição Médica</h3>
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
                  <h3 class="font-serif">Prescrição Veterinária</h3>
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
                  <h3 class="font-serif">Cannabis na Rotina Profissional</h3>
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
            <?php if (!empty($atts['title'])) : ?><h2 class="font-serif"><?php echo esc_html($atts['title']); ?></h2><?php endif; ?>
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

// 6. Shortcode Página Quem Somos Completa
function apepi_shortcode_pagina_quem_somos() {
    ob_start();
    ?>
    <div class="quem-somos-full-page-wrapper">
      
      <!-- HERO BANNER REFINADO -->
      <section class="quem-somos-hero-banner">
        <div class="container" style="max-width: 850px; margin: 0 auto;">
          <span class="qs-banner-badge"><i class="fa-solid fa-leaf"></i> SOBRE NÓS</span>
          <h2 class="font-serif">APEPI Escola</h2>
          <p class="qs-banner-desc">Conheça o pilar educacional da associação pioneira em cannabis medicinal no Brasil.</p>
          
          <div class="qs-pills-row">
            <span class="qs-pill-item"><i class="fa-solid fa-graduation-cap"></i> Pilar Educacional</span>
            <span class="qs-pill-item"><i class="fa-solid fa-seedling"></i> Associação Pioneira</span>
            <span class="qs-pill-item"><i class="fa-solid fa-microscope"></i> Ensino Baseado em Evidências</span>
          </div>

          <a href="#nossos-cursos" class="btn-hero-action">
            Conheça Nossos Cursos <i class="fa-solid fa-arrow-down"></i>
          </a>
        </div>
      </section>

      <!-- 3 PILARES PRINCIPAIS -->
      <section class="diferenciais-section-home" style="margin-bottom: 4rem;">
        <div class="container">
          <div class="diferenciais-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.75rem;">
            
            <div class="diferencial-card" style="background: var(--surface, #ffffff); border-radius: 12px; padding: 2rem 1.5rem; border: 1px solid var(--border-color, #EAE3D8); box-shadow: 0 4px 12px rgba(0,0,0,0.05); text-align: center;">
              <div class="dif-icon-holder" style="width: 54px; height: 54px; border-radius: 12px; background: rgba(76, 154, 42, 0.12); color: var(--secondary, #4C9A2A); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; margin: 0 auto 1.25rem;">
                <i class="fa-solid fa-star"></i>
              </div>
              <h3 style="font-size: 1.25rem; color: var(--primary, #003E19); margin-bottom: 0.75rem;" class="font-serif">Metodologia Prática</h3>
              <p style="font-size: 0.925rem; color: var(--text-secondary, #3D5244); line-height: 1.6; margin: 0;">Ensino focado em casos clínicos reais, estudos científicos e vivência prática na prescrição de cannabis medicinal.</p>
            </div>

            <div class="diferencial-card" style="background: var(--surface, #ffffff); border-radius: 12px; padding: 2rem 1.5rem; border: 1px solid var(--border-color, #EAE3D8); box-shadow: 0 4px 12px rgba(0,0,0,0.05); text-align: center;">
              <div class="dif-icon-holder" style="width: 54px; height: 54px; border-radius: 12px; background: rgba(76, 154, 42, 0.12); color: var(--secondary, #4C9A2A); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; margin: 0 auto 1.25rem;">
                <i class="fa-solid fa-seedling"></i>
              </div>
              <h3 style="font-size: 1.25rem; color: var(--primary, #003E19); margin-bottom: 0.75rem;" class="font-serif">Fazenda APEPI</h3>
              <p style="font-size: 0.925rem; color: var(--text-secondary, #3D5244); line-height: 1.6; margin: 0;">Imersão técnica com visitas guiadas à maior fazenda de cultivo e pesquisa de cannabis do Brasil.</p>
            </div>

            <div class="diferencial-card" style="background: var(--surface, #ffffff); border-radius: 12px; padding: 2rem 1.5rem; border: 1px solid var(--border-color, #EAE3D8); box-shadow: 0 4px 12px rgba(0,0,0,0.05); text-align: center;">
              <div class="dif-icon-holder" style="width: 54px; height: 54px; border-radius: 12px; background: rgba(76, 154, 42, 0.12); color: var(--secondary, #4C9A2A); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; margin: 0 auto 1.25rem;">
                <i class="fa-solid fa-award"></i>
              </div>
              <h3 style="font-size: 1.25rem; color: var(--primary, #003E19); margin-bottom: 0.75rem;" class="font-serif">Pioneirismo</h3>
              <p style="font-size: 0.925rem; color: var(--text-secondary, #3D5244); line-height: 1.6; margin: 0;">Tradição e reputação de uma associação que mudou a história do acesso à cannabis no país.</p>
            </div>

          </div>
        </div>
      </section>

      <!-- EDUCAÇÃO COMO FERRAMENTA SOCIAL -->
      <section class="fazenda-section-home" style="margin-bottom: 4rem;">
        <div class="container fazenda-home-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 3rem; align-items: center;">
          
          <div class="fazenda-text-card" style="background: var(--surface, #ffffff); padding: 2.5rem; border-radius: 16px; border: 1px solid var(--border-color, #EAE3D8); box-shadow: 0 6px 20px rgba(0,0,0,0.06);">
            <div class="section-badge" style="color: var(--secondary, #4C9A2A); font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase; font-size: 0.85rem; margin-bottom: 0.75rem;">PROPÓSITO SOCIAL</div>
            <h2 class="font-serif" style="font-size: 2.2rem; color: var(--primary, #003E19); margin-bottom: 1.25rem;">Educação como ferramenta social</h2>
            <p style="color: var(--text-secondary, #3D5244); line-height: 1.7; font-size: 1.05rem; margin-bottom: 1rem;">
              A <strong>APEPI Escola</strong> nasceu para difundir o conhecimento técnico e científico sobre o uso medicinal da cannabis. Mais do que oferecer cursos, temos o compromisso ético de democratizar a compreensão sobre o uso seguro e responsável da planta.
            </p>
            <p style="color: var(--text-secondary, #3D5244); line-height: 1.7; font-size: 1rem; margin-bottom: 2rem;">
              Oferecemos cursos especializados sobre cannabis medicinal, capacitando profissionais da saúde, veterinários e pacientes com conhecimento científico e prático.
            </p>
            <a href="#nossos-cursos" class="btn btn-primary" style="background: var(--primary, #003E19); color: #ffffff; padding: 0.85rem 1.75rem; border-radius: 50px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
              Conheça Nossos Cursos <i class="fa-solid fa-arrow-down"></i>
            </a>
          </div>

          <div class="fazenda-img-box" style="border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.12);">
            <img src="https://apepiescola.org/wp-content/uploads/2026/07/Pedro-aula-scaled.jpg" alt="Aula APEPI Escola" style="width: 100%; height: 100%; object-fit: cover; display: block; min-height: 380px;">
          </div>

        </div>
      </section>

      <!-- METODOLOGIA 360 -->
      <section class="fazenda-section-home" style="margin-bottom: 4rem;">
        <div class="container fazenda-home-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 3rem; align-items: center;">
          
          <div class="fazenda-img-box" style="border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.12);">
            <img src="https://apepiescola.org/wp-content/uploads/2026/07/Metodologia-APEPI-Escola-scaled.jpeg" alt="Metodologia APEPI Escola" style="width: 100%; height: 100%; object-fit: cover; display: block; min-height: 380px;">
          </div>

          <div class="fazenda-text-card" style="background: var(--surface, #ffffff); padding: 2.5rem; border-radius: 16px; border: 1px solid var(--border-color, #EAE3D8); box-shadow: 0 6px 20px rgba(0,0,0,0.06);">
            <div class="section-badge" style="color: var(--secondary, #4C9A2A); font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase; font-size: 0.85rem; margin-bottom: 0.75rem;">NOSSA ABORDAGEM</div>
            <h2 class="font-serif" style="font-size: 2.2rem; color: var(--primary, #003E19); margin-bottom: 1.25rem;">Metodologia 360</h2>
            <p style="color: var(--text-secondary, #3D5244); line-height: 1.7; font-size: 1rem; margin-bottom: 1rem;">
              A metodologia da APEPI Escola nasce da intersecção entre pesquisa científica de ponta e a experiência acumulada pela associação que ajudou a mudar a história da cannabis no Brasil. Cada conteúdo é desenvolvido com especialistas, revisado por evidências e estruturado para transformar conhecimento complexo em prática acessível.
            </p>
            <p style="color: var(--text-secondary, #3D5244); line-height: 1.7; font-size: 1rem; margin-bottom: 2rem;">
              Cada programa parte das histórias reais de pacientes, passa pelo rigor da ciência e chega à prática clínica que transforma vidas. Somente a APEPI Escola oferece visitas técnicas à maior fazenda de cannabis do Brasil.
            </p>
            <a href="https://apepiescola.org/fazenda-sofia-langenbach/" class="btn btn-primary" style="background: var(--secondary, #4C9A2A); color: #ffffff; padding: 0.85rem 1.75rem; border-radius: 50px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
              Conheça a Fazenda APEPI <i class="fa-solid fa-arrow-right"></i>
            </a>
          </div>

        </div>
      </section>

      <!-- FILOSOFIA: MISSÃO, VISÃO E VALORES -->
      <section style="background: var(--bg-secondary, #F3EFE9); padding: 4rem 1.5rem; border-radius: 16px; margin-bottom: 4rem;">
        <div class="container" style="max-width: 1100px; margin: 0 auto;">
          <div style="text-align: center; margin-bottom: 3rem;">
            <span class="section-badge" style="color: var(--secondary, #4C9A2A); font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase; font-size: 0.85rem;">NOSSOS PILARES</span>
            <h2 class="font-serif" style="font-size: 2.4rem; color: var(--primary, #003E19); margin-top: 0.5rem;">Filosofia APEPI Escola</h2>
          </div>

          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            
            <div style="background: var(--surface, #ffffff); padding: 2.25rem 1.75rem; border-radius: 14px; border: 1px solid var(--border-color, #EAE3D8); box-shadow: 0 4px 15px rgba(0,0,0,0.04);">
              <div style="width: 48px; height: 48px; border-radius: 10px; background: rgba(0, 62, 25, 0.1); color: var(--primary, #003E19); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; margin-bottom: 1.25rem;">
                <i class="fa-solid fa-bullseye"></i>
              </div>
              <h3 class="font-serif" style="font-size: 1.4rem; color: var(--primary, #003E19); margin-bottom: 0.85rem;">Missão</h3>
              <p style="color: var(--text-secondary, #3D5244); line-height: 1.6; font-size: 0.95rem; margin: 0;">
                Desenvolver ações educacionais sobre o uso seguro e eficaz da cannabis medicinal, promovendo o acesso ao conhecimento científico, com foco na formação de profissionais e na conscientização da sociedade.
              </p>
            </div>

            <div style="background: var(--surface, #ffffff); padding: 2.25rem 1.75rem; border-radius: 14px; border: 1px solid var(--border-color, #EAE3D8); box-shadow: 0 4px 15px rgba(0,0,0,0.04);">
              <div style="width: 48px; height: 48px; border-radius: 10px; background: rgba(76, 154, 42, 0.12); color: var(--secondary, #4C9A2A); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; margin-bottom: 1.25rem;">
                <i class="fa-solid fa-eye"></i>
              </div>
              <h3 class="font-serif" style="font-size: 1.4rem; color: var(--primary, #003E19); margin-bottom: 0.85rem;">Visão</h3>
              <p style="color: var(--text-secondary, #3D5244); line-height: 1.6; font-size: 0.95rem; margin: 0;">
                Contribuir para a construção de um cenário legal e regulado no Brasil, no qual o uso terapêutico seja amplamente compreendido e aplicado de forma segura e ética, promovendo o bem-estar e a qualidade de vida.
              </p>
            </div>

            <div style="background: var(--surface, #ffffff); padding: 2.25rem 1.75rem; border-radius: 14px; border: 1px solid var(--border-color, #EAE3D8); box-shadow: 0 4px 15px rgba(0,0,0,0.04);">
              <div style="width: 48px; height: 48px; border-radius: 10px; background: rgba(0, 62, 25, 0.1); color: var(--primary, #003E19); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; margin-bottom: 1.25rem;">
                <i class="fa-solid fa-heart-pulse"></i>
              </div>
              <h3 class="font-serif" style="font-size: 1.4rem; color: var(--primary, #003E19); margin-bottom: 0.85rem;">Valores</h3>
              <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.5rem; color: var(--text-secondary, #3D5244); font-size: 0.95rem;">
                <li style="display: flex; align-items: center; gap: 0.5rem;"><i class="fa-solid fa-check" style="color: var(--secondary, #4C9A2A);"></i> Cuidado com a vida</li>
                <li style="display: flex; align-items: center; gap: 0.5rem;"><i class="fa-solid fa-check" style="color: var(--secondary, #4C9A2A);"></i> Acesso ao conhecimento</li>
                <li style="display: flex; align-items: center; gap: 0.5rem;"><i class="fa-solid fa-check" style="color: var(--secondary, #4C9A2A);"></i> Consciência e responsabilidade social</li>
                <li style="display: flex; align-items: center; gap: 0.5rem;"><i class="fa-solid fa-check" style="color: var(--secondary, #4C9A2A);"></i> Empatia e respeito</li>
                <li style="display: flex; align-items: center; gap: 0.5rem;"><i class="fa-solid fa-check" style="color: var(--secondary, #4C9A2A);"></i> Transformação social</li>
              </ul>
            </div>

          </div>
        </div>
      </section>

      <!-- CORPO DOCENTE (SHORTCODE DINÂMICO) -->
      <section style="margin-bottom: 4rem;">
        <?php echo do_shortcode('[apepi_lista_professores title="Nosso Corpo Docente" badge="ESPECIALISTAS DEDICADOS"]'); ?>
      </section>

      <!-- CATÁLOGO DE CURSOS (SHORTCODE DINÂMICO) -->
      <section id="nossos-cursos" style="margin-bottom: 4rem;">
        <?php echo do_shortcode('[apepi_lista_cursos title="Formações APEPI Escola" badge="CONHEÇA NOSSOS CURSOS"]'); ?>
      </section>

    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('apepi_pagina_quem_somos', 'apepi_shortcode_pagina_quem_somos');

// 7. Shortcode Página Fazenda Sofia Langenbach Completa (Fidelidade Absoluta page_4.png)
function apepi_shortcode_pagina_fazenda() {
    ob_start();
    $wa_num = apepi_get_option('apepi_whatsapp_number', '5521979570000');
    ?>
    <div class="fazenda-full-page-wrapper">
      
      <!-- Breadcrumb -->
      <div class="breadcrumb-container" style="margin-bottom: 1.5rem;">
        <div class="container">
          <p class="breadcrumb">Início &gt; Fazenda de Cannabis &gt; Visita à Fazenda Sofia Langenbach</p>
        </div>
      </div>

      <!-- Hero Section (Fidelidade page_4.png / fazenda-hero-section) -->
      <section class="fazenda-hero-section">
        <div class="container fazenda-hero-grid">
          <div class="fazenda-hero-left">
            <h1 class="font-serif">Visita à<br>Fazenda Sofia Langenbach</h1>
            <h2 class="sub-hero font-serif">Aprendizado que nasce na prática</h2>
            <p class="fazenda-hero-desc">
              Um marco da cannabis para fins medicinais no Brasil. Acompanhe de perto todo o processo de produção dos nossos óleos — desde a germinação até a extração dos compostos da Cannabis.
            </p>
            <p class="fazenda-hero-sub-desc">
              A Fazenda Sofia Langenbach nasce do sonho de Marcos Langenbach e Margarete Brito, fundadores da APEPI, de tornar o tratamento medicinal mais acessível. Uma experiência imersiva, guiada por especialistas, para quem busca conhecimento com ciência, segurança e responsabilidade.
            </p>

            <div class="hero-quick-badges">
              <div class="hq-badge">
                <i class="fa-solid fa-user-doctor"></i>
                <span>Para médicos, veterinários e profissionais da saúde</span>
              </div>
              <div class="hq-badge">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Imersão prática e conteúdo científico</span>
              </div>
              <div class="hq-badge">
                <i class="fa-solid fa-seedling"></i>
                <span>Conexão entre teoria e prática com excelência</span>
              </div>
            </div>

            <!-- Green Callout Card -->
            <div class="green-callout-card">
              <div class="gcc-icon"><i class="fa-solid fa-users"></i></div>
              <div class="gcc-content">
                <p>Nossa equipe de professores e técnicos especializados estará com você durante toda a experiência, garantindo aprendizado com clareza, segurança e troca de conhecimento.</p>
                <div class="gcc-meta"><i class="fa-solid fa-calendar-day"></i> O dia de imersão para conhecer do cultivo até a produção dos óleos.</div>
              </div>
            </div>
          </div>

          <div class="fazenda-hero-right">
            <img src="https://apepiescola.org/wp-content/uploads/2026/07/fazenda.jpg" alt="Visita guiada à fazenda Sofia Langenbach da APEPI" class="fazenda-main-hero-img">
          </div>
        </div>
      </section>

      <!-- Destaques da Experiência (Exact page_4.png Grid) -->
      <section class="destaques-section">
        <div class="container">
          <h2 class="destaques-main-title font-serif">DESTAQUES DA EXPERIÊNCIA</h2>
          <div class="destaques-grid">
            
            <!-- Card 1: Plantando Sonhos -->
            <div class="destaque-card">
              <div class="dest-photo-header">
                <img src="https://apepiescola.org/wp-content/uploads/2026/06/Curso-Basico-Cultivo-e-Extracao-de-Cannabis.png" alt="Plantando sonhos">
              </div>
              <div class="dest-body-content">
                <div class="dest-icon-holder"><i class="fa-solid fa-seedling"></i></div>
                <h3>Plantando sonhos</h3>
                <p>Origem da fazenda e o Curso Básico de Cultivo e Extração "De Família para Família".</p>
              </div>
            </div>

            <!-- Card 2: Saúde da Natureza -->
            <div class="destaque-card">
              <div class="dest-photo-header">
                <img src="https://apepiescola.org/wp-content/uploads/2026/07/fazenda.jpg" alt="Saúde que vem da natureza">
              </div>
              <div class="dest-body-content">
                <div class="dest-icon-holder"><i class="fa-solid fa-tree"></i></div>
                <h3>Saúde da natureza</h3>
                <p>Cultivo agroecológico com 2.300 árvores nativas da Mata Atlântica e 115 placas solares.</p>
              </div>
            </div>

            <!-- Card 3: Tecnologia e Cuidado -->
            <div class="destaque-card">
              <div class="dest-photo-header">
                <img src="https://apepiescola.org/wp-content/uploads/2026/07/Lab-2-scaled.jpg" alt="Tecnologia e Cuidado">
              </div>
              <div class="dest-body-content">
                <div class="dest-icon-holder"><i class="fa-solid fa-flask-vial"></i></div>
                <h3>Tecnologia e Cuidado</h3>
                <p>Controle, rastreabilidade, maquinário de ponta e Certificado de Análise (COA) Anvisa.</p>
              </div>
            </div>

            <!-- Card 4: Estrutura Exclusiva -->
            <div class="destaque-card">
              <div class="dest-photo-header">
                <img src="https://apepiescola.org/wp-content/uploads/2026/07/fazenda.jpg" alt="Estrutura exclusiva">
              </div>
              <div class="dest-body-content">
                <div class="dest-icon-holder"><i class="fa-solid fa-house-chimney-medical"></i></div>
                <h3>Estrutura exclusiva</h3>
                <p>Fazenda integrada com tecnologia, segurança e boas práticas de cultivo e produção.</p>
              </div>
            </div>

            <!-- Card 5: Aprenda na Maior -->
            <div class="destaque-card">
              <div class="dest-photo-header">
                <img src="https://apepiescola.org/wp-content/uploads/2026/07/WhatsApp-Image-2023-10-03-at-14.17.15-e1783691657301.jpeg" alt="Aprenda na maior do Brasil">
              </div>
              <div class="dest-body-content">
                <div class="dest-icon-holder"><i class="fa-solid fa-graduation-cap"></i></div>
                <h3>Aprenda na Maior</h3>
                <p>Módulo especial com visita técnica e vivências reais da semente ao paciente.</p>
              </div>
            </div>

          </div>
        </div>
      </section>

      <!-- Programação do Dia Flowchart (Exact page_4.png Proof) -->
      <section class="programacao-section">
        <div class="container">
          <h2 class="programacao-main-title font-serif">PROGRAMAÇÃO DO DIA</h2>
          
          <!-- Flowchart Row 1 -->
          <div class="flowchart-row">
            <!-- Step 1 -->
            <div class="flow-step-card">
              <div class="flow-step-icon"><i class="fa-solid fa-bus"></i></div>
              <strong>06h30 – 07h | Embarque (Rio)</strong>
              <ul>
                <li>Encontro na sede da APEPI</li>
                <li>Check-in e entrega de crachás</li>
                <li>Saída às 07h em ponto (não será possível aguardar atrasos)</li>
              </ul>
            </div>

            <!-- Step 2 -->
            <div class="flow-step-card">
              <div class="flow-step-icon"><i class="fa-solid fa-location-dot"></i></div>
              <strong>09h | Encontro em Miguel Pereira</strong>
              <ul>
                <li>Chegada na rodoviária</li>
                <li>Deslocamento conjunto até a fazenda</li>
              </ul>
              <div class="carro-gold-pill"><i class="fa-solid fa-car"></i> Para quem for de carro: encontro às 09h (pontualidade é essencial)</div>
            </div>

            <!-- Step 3 -->
            <div class="flow-step-card">
              <div class="flow-step-icon"><i class="fa-solid fa-house"></i></div>
              <strong>09h30 – 10h | Chegada</strong>
              <ul>
                <li>Recepção na Fazenda Sofia Langenbach</li>
                <li>Café da manhã de boas-vindas</li>
              </ul>
            </div>

            <!-- Step 4 -->
            <div class="flow-step-card">
              <div class="flow-step-icon"><i class="fa-solid fa-seedling"></i></div>
              <strong>10h – 13h | Cultivo</strong>
              <ul>
                <li>Visita às áreas de:</li>
                <li>Matrizeiro</li>
                <li>Berçário</li>
                <li>Cultivo</li>
                <li>Beneficiamento</li>
              </ul>
            </div>

            <!-- Step 5 -->
            <div class="flow-step-card">
              <div class="flow-step-icon"><i class="fa-solid fa-utensils"></i></div>
              <strong>13h – 14h | Almoço</strong>
              <ul>
                <li>Almoço servido na fazenda</li>
              </ul>
            </div>
          </div>

          <!-- Flowchart Row 2 (Bottom) -->
          <div class="flowchart-row-bottom">
            <!-- Step 6 -->
            <div class="flow-step-card">
              <div class="flow-step-icon"><i class="fa-solid fa-flask"></i></div>
              <strong>14h – 16h | Laboratório</strong>
              <ul>
                <li>Visita ao laboratório</li>
                <li>Roda de conversa com médico(a) coordenador(a)</li>
              </ul>
            </div>

            <!-- Step 7 -->
            <div class="flow-step-card">
              <div class="flow-step-icon"><i class="fa-solid fa-mug-hot"></i></div>
              <strong>16h – 17h | Encerramento</strong>
              <ul>
                <li>Lanche da tarde</li>
                <li>Entrega de kit (óleos + pomada APEPI)</li>
                <li>Retorno para o Rio</li>
              </ul>
            </div>

            <!-- Step 8 -->
            <div class="flow-step-card">
              <div class="flow-step-icon"><i class="fa-solid fa-bus"></i></div>
              <strong>Previsão de chegada: 20h</strong>
            </div>
          </div>

        </div>
      </section>

      <!-- Serviços Inclusos -->
      <section class="servicos-inclusos-section">
        <div class="container services-grid">
          <div class="service-inc-card">
            <i class="fa-solid fa-bus"></i>
            <h3>Transporte (ida e volta)</h3>
            <p>Transporte confortável e seguro, com saída do Rio.</p>
          </div>
          <div class="service-inc-card">
            <i class="fa-solid fa-utensils"></i>
            <h3>Alimentação completa</h3>
            <p>Café da manhã, almoço e lanche da tarde na fazenda.</p>
          </div>
          <div class="service-inc-card">
            <i class="fa-solid fa-shield-halved"></i>
            <h3>Equipamentos de proteção (EPI)</h3>
            <p>Fornecidos para sua segurança durante toda a visita.</p>
          </div>
        </div>
      </section>

      <!-- Photo Gallery -->
      <section class="fazenda-gallery-section">
        <div class="container gallery-grid">
          <img src="https://apepiescola.org/wp-content/uploads/2026/07/fazenda.jpg" alt="Estufas e cultivo da Fazenda">
          <img src="https://apepiescola.org/wp-content/uploads/2026/06/Curso-Basico-Cultivo-e-Extracao-de-Cannabis.png" alt="Plantações em ambiente protegido">
          <img src="https://apepiescola.org/wp-content/uploads/2026/07/WhatsApp-Image-2023-10-03-at-14.17.15-e1783691657301.jpeg" alt="Visita Prática na Fazenda">
          <img src="https://apepiescola.org/wp-content/uploads/2026/07/Lab-2-scaled.jpg" alt="Laboratório de extração dos óleos">
        </div>
      </section>

      <!-- Bottom CTA Banner -->
      <section class="bottom-cta-banner">
        <div class="container cta-banner-container">
          <div class="cta-banner-content">
            <div class="cta-icon-holder"><i class="fa-solid fa-seedling"></i></div>
            <p class="cta-text font-serif">
              Viva uma experiência única e transforme seu conhecimento em prática responsável.
            </p>
            <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $wa_num)); ?>" target="_blank" class="btn btn-primary btn-lg cta-btn-right">QUERO PARTICIPAR DA VISITA</a>
          </div>
          <span class="vagas-limitadas">Vagas limitadas</span>
        </div>
      </section>

      <!-- PERGUNTAS FREQUENTES (FAQ ACCORDION) -->
      <section class="p2-programa-section" style="margin: 4rem 0;">
        <div class="container" style="max-width: 900px; margin: 0 auto;">
          <div class="text-center" style="margin-bottom: 2.5rem;">
            <span class="section-badge" style="color: var(--secondary, #4C9A2A); font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase; font-size: 0.85rem;">TIRE SUAS DÚVIDAS</span>
            <h2 class="font-serif" style="font-size: 2.4rem; color: var(--primary, #003E19); margin-top: 0.5rem;">Perguntas Frequentes</h2>
          </div>

          <div class="p2-accordion-container">
            
            <div class="p2-accordion-item">
              <button class="p2-accordion-header accordion-trigger" type="button">
                <span class="p2-acc-title">Quanto custa cada frasco de óleo?</span>
                <i class="fa-solid fa-chevron-down p2-acc-arrow"></i>
              </button>
              <div class="p2-accordion-content accordion-panel">
                <div class="p2-acc-inner">
                  <p>Cada frasco custa R$180,00. Você pode solicitar o envio com frete para todo o Brasil ou retirar em nossa sede em Botafogo, na cidade do Rio de Janeiro (RJ). Lembrando que para ter acesso aos óleos é necessário se associar à APEPI e ter receita médica válida.</p>
                </div>
              </div>
            </div>

            <div class="p2-accordion-item">
              <button class="p2-accordion-header accordion-trigger" type="button">
                <span class="p2-acc-title">Em quanto tempo começo a sentir os efeitos?</span>
                <i class="fa-solid fa-chevron-down p2-acc-arrow"></i>
              </button>
              <div class="p2-accordion-content accordion-panel">
                <div class="p2-acc-inner">
                  <p>O tratamento é individualizado e varia de pessoa para pessoa. O tempo para surtir efeito também é variável, podendo levar algumas semanas ou meses, como ocorre com a maioria dos medicamentos farmacêuticos.</p>
                </div>
              </div>
            </div>

            <div class="p2-accordion-item">
              <button class="p2-accordion-header accordion-trigger" type="button">
                <span class="p2-acc-title">Preciso de receita médica para comprar os óleos?</span>
                <i class="fa-solid fa-chevron-down p2-acc-arrow"></i>
              </button>
              <div class="p2-accordion-content accordion-panel">
                <div class="p2-acc-inner">
                  <p>Sim, os óleos são dispensados somente mediante receita médica. Mas, não se preocupe, temos médicos vinculados com experiência em tratamento com cannabis.</p>
                </div>
              </div>
            </div>

            <div class="p2-accordion-item">
              <button class="p2-accordion-header accordion-trigger" type="button">
                <span class="p2-acc-title">Qual é o valor da consulta?</span>
                <i class="fa-solid fa-chevron-down p2-acc-arrow"></i>
              </button>
              <div class="p2-accordion-content accordion-panel">
                <div class="p2-acc-inner">
                  <p>Para acompanhar nossos associados desde o início, indicamos a consulta com nossos médicos vinculados que irão analisar as possibilidades do seu tratamento. A consulta é 100% online e custa R$290,00, podendo parcelar em até 6x sem juros no cartão de crédito. Lembrando que para ter acesso aos óleos é necessário passar pela consulta médica e ter receita válida.</p>
                </div>
              </div>
            </div>

            <div class="p2-accordion-item">
              <button class="p2-accordion-header accordion-trigger" type="button">
                <span class="p2-acc-title">A consulta de retorno é o mesmo valor?</span>
                <i class="fa-solid fa-chevron-down p2-acc-arrow"></i>
              </button>
              <div class="p2-accordion-content accordion-panel">
                <div class="p2-acc-inner">
                  <p>Após a sua primeira consulta, você tem direito a retornar em um prazo de 1 mês pelo valor de R$170 para o acompanhamento do seu tratamento. Após esse período, a consulta volta ao valor normal de R$290. Você pode conversar com o seu médico de confiança para que ele faça a sua prescrição. Se ele ainda não for prescritor de cannabis medicinal, converse com ele sobre a APEPI. Ficaremos felizes em conhecê-lo.</p>
                </div>
              </div>
            </div>

            <div class="p2-accordion-item">
              <button class="p2-accordion-header accordion-trigger" type="button">
                <span class="p2-acc-title">Já tenho receita. Posso me associar?</span>
                <i class="fa-solid fa-chevron-down p2-acc-arrow"></i>
              </button>
              <div class="p2-accordion-content accordion-panel">
                <div class="p2-acc-inner">
                  <p>Sim! Se você já possui uma receita, pode se associar imediatamente. Aceitamos tanto a receita branca (simples) quanto, em um primeiro momento, a receita azul, desde que a prescrição esteja de acordo com as concentrações dos óleos disponíveis em nossa associação. A receita deve ser emitida por um profissional com registro ativo nos conselhos competentes (CRM, CRO ou CRMV). Caso sua receita não siga esse padrão, nossa equipe de acolhimento está à disposição para orientar você.</p>
                </div>
              </div>
            </div>

            <div class="p2-accordion-item">
              <button class="p2-accordion-header accordion-trigger" type="button">
                <span class="p2-acc-title">Ainda não tenho receita. Posso me associar?</span>
                <i class="fa-solid fa-chevron-down p2-acc-arrow"></i>
              </button>
              <div class="p2-accordion-content accordion-panel">
                <div class="p2-acc-inner">
                  <p>Sim! Você também pode se associar mesmo sem receita. Ao se tornar associado, poderá agendar uma consulta com um dos nossos médicos especializados em medicina canabinoide ou com um profissional parceiro da nossa rede. Assim, você terá a orientação adequada para obter sua prescrição de forma segura e legal.</p>
                </div>
              </div>
            </div>

            <div class="p2-accordion-item">
              <button class="p2-accordion-header accordion-trigger" type="button">
                <span class="p2-acc-title">Não tenho cartão de crédito, consigo me associar mesmo assim?</span>
                <i class="fa-solid fa-chevron-down p2-acc-arrow"></i>
              </button>
              <div class="p2-accordion-content accordion-panel">
                <div class="p2-acc-inner">
                  <p>Sim, porém para PIX ou boleto é válido apenas a contribuição anual. Entre em contato com nosso acolhimento que eles irão te auxiliar.</p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </section>

      <!-- CATÁLOGO DE CURSOS -->
      <section id="nossos-cursos" style="margin-bottom: 4rem;">
        <?php echo do_shortcode('[apepi_lista_cursos title="Formações com Imersão na Fazenda" badge="AULAS PRÁTICAS"]'); ?>
      </section>

    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('apepi_pagina_fazenda', 'apepi_shortcode_pagina_fazenda');



/* ============================================================
   NOSSOS CURSOS PAGE — SHORTCODES + CUSTOMIZER
   ============================================================ */

/**
 * Shortcode: Números APEPI Escola em Números (Nossos Cursos page)
 */
function apepi_shortcode_escola_numeros($atts) {
    $atts = shortcode_atts(array(
        'badge' => 'APEPI ESCOLA EM NÚMEROS',
    ), $atts);

    $stats = array(
        array(
            'icon'  => apepi_get_option('apepi_nc_num1_icon',  'fa-solid fa-award'),
            'value' => apepi_get_option('apepi_nc_num1_value', '14 anos'),
            'label' => apepi_get_option('apepi_nc_num1_label', 'de experiência na educação canábica'),
        ),
        array(
            'icon'  => apepi_get_option('apepi_nc_num2_icon',  'fa-solid fa-users'),
            'value' => apepi_get_option('apepi_nc_num2_value', '+1000'),
            'label' => apepi_get_option('apepi_nc_num2_label', 'alunos formados e preparados para fazer a diferença'),
        ),
        array(
            'icon'  => apepi_get_option('apepi_nc_num3_icon',  'fa-solid fa-play-circle'),
            'value' => apepi_get_option('apepi_nc_num3_value', '+10h'),
            'label' => apepi_get_option('apepi_nc_num3_label', 'de conteúdo — aulas online e ao vivo com especialistas referência na área'),
        ),
        array(
            'icon'  => apepi_get_option('apepi_nc_num4_icon',  'fa-solid fa-graduation-cap'),
            'value' => apepi_get_option('apepi_nc_num4_value', 'Formação completa'),
            'label' => apepi_get_option('apepi_nc_num4_label', 'da teoria à prática, com segurança e responsabilidade'),
        ),
        array(
            'icon'  => apepi_get_option('apepi_nc_num5_icon',  'fa-solid fa-book-open'),
            'value' => apepi_get_option('apepi_nc_num5_value', 'E-books gratuitos'),
            'label' => apepi_get_option('apepi_nc_num5_label', 'materiais exclusivos para aprofundar seu conhecimento'),
        ),
    );

    ob_start();
    ?>
    <section class="nc-numeros-section">
      <div class="container">
        <div class="nc-numeros-header">
          <div class="nc-numeros-badge">
            <i class="fa-solid fa-leaf"></i>
            <?php echo esc_html($atts['badge']); ?>
            <i class="fa-solid fa-leaf"></i>
          </div>
        </div>
        <div class="nc-numeros-grid">
          <?php foreach ($stats as $s) : ?>
          <div class="nc-numero-item">
            <div class="nc-numero-icon"><i class="<?php echo esc_attr($s['icon']); ?>"></i></div>
            <div class="nc-numero-value"><?php echo esc_html($s['value']); ?></div>
            <div class="nc-numero-label"><?php echo esc_html($s['label']); ?></div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('apepi_escola_numeros', 'apepi_shortcode_escola_numeros');

/**
 * Shortcode: Depoimentos (Nossos Cursos page)
 */
function apepi_shortcode_depoimentos_nc($atts) {
    $atts = shortcode_atts(array(
        'limit' => 6,
    ), $atts);

    $badge    = apepi_get_option('apepi_nc_dep_badge',    'DEPOIMENTOS');
    $title    = apepi_get_option('apepi_nc_dep_title',    'O que nossos alunos dizem');
    $subtitle = apepi_get_option('apepi_nc_dep_subtitle', 'Histórias reais de médicos, veterinários e profissionais que transformaram sua prática com o conhecimento em Cannabis Medicinal.');

    // Try to pull from CPT depoimento first
    $args = array(
        'post_type'      => 'depoimento',
        'posts_per_page' => intval($atts['limit']),
        'post_status'    => 'publish',
    );
    $query = new WP_Query($args);

    $fallback_deps = array(
        array(
            'text'   => apepi_get_option('apepi_nc_dep1_text', 'O curso mudou completamente minha visão sobre o tratamento com Cannabis. Hoje me sinto seguro para prescrever e acompanhar meus pacientes com muito mais consciência e resultados.'),
            'name'   => apepi_get_option('apepi_nc_dep1_name', 'Dr. Rafael M.'),
            'role'   => apepi_get_option('apepi_nc_dep1_role', 'Médico'),
            'avatar' => apepi_get_option('apepi_nc_dep1_avatar', 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=200&q=80'),
        ),
        array(
            'text'   => apepi_get_option('apepi_nc_dep2_text', 'Conteúdo completo, professores excelentes e uma didática que facilita o entendimento mesmo dos temas mais complexos. Recomendo de olhos fechados!'),
            'name'   => apepi_get_option('apepi_nc_dep2_name', 'Dra. Juliana T.'),
            'role'   => apepi_get_option('apepi_nc_dep2_role', 'Médica Veterinária'),
            'avatar' => apepi_get_option('apepi_nc_dep2_avatar', 'https://images.unsplash.com/photo-1651008376811-b90baee60c1f?auto=format&fit=crop&w=200&q=80'),
        ),
        array(
            'text'   => apepi_get_option('apepi_nc_dep3_text', 'A parte prática e a visita à fazenda foram experiências incríveis que fizeram toda a diferença na minha formação. Um curso que vai muito além da teoria.'),
            'name'   => apepi_get_option('apepi_nc_dep3_name', 'Dr. Lucas P.'),
            'role'   => apepi_get_option('apepi_nc_dep3_role', 'Médico'),
            'avatar' => apepi_get_option('apepi_nc_dep3_avatar', 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=200&q=80'),
        ),
    );

    ob_start();
    ?>
    <section class="nc-depoimentos-section">
      <div class="container">
        <div class="nc-depoimentos-header">
          <div class="nc-depoimentos-badge">
            <i class="fa-solid fa-leaf"></i>
            <?php echo esc_html($badge); ?>
            <i class="fa-solid fa-leaf"></i>
          </div>
          <h2 class="font-serif"><?php echo esc_html($title); ?></h2>
          <p><?php echo esc_html($subtitle); ?></p>
        </div>

        <div class="nc-depoimentos-carousel-wrapper" id="nc-dep-carousel">
          <div class="nc-depoimentos-grid" id="nc-dep-grid">
            <?php if ($query->have_posts()) :
              while ($query->have_posts()) : $query->the_post();
                $cargo   = get_post_meta(get_the_ID(), '_depoimento_cargo', true);
                $avatar  = apepi_get_professor_image_url(get_the_ID());
            ?>
            <div class="nc-depoimento-card">
              <div class="nc-dep-quote-icon"><i class="fa-solid fa-quote-left"></i></div>
              <p class="nc-dep-text"><?php echo wp_kses_post(get_the_excerpt()); ?></p>
              <div class="nc-dep-author">
                <img src="<?php echo esc_url($avatar); ?>" alt="<?php the_title_attribute(); ?>" class="nc-dep-avatar">
                <div>
                  <p class="nc-dep-name"><?php the_title(); ?></p>
                  <?php if ($cargo) : ?><p class="nc-dep-role"><?php echo esc_html($cargo); ?></p><?php endif; ?>
                </div>
              </div>
            </div>
            <?php
              endwhile;
              wp_reset_postdata();
            else :
              foreach ($fallback_deps as $dep) : ?>
            <div class="nc-depoimento-card">
              <div class="nc-dep-quote-icon"><i class="fa-solid fa-quote-left"></i></div>
              <p class="nc-dep-text"><?php echo esc_html($dep['text']); ?></p>
              <div class="nc-dep-author">
                <img src="<?php echo esc_url($dep['avatar']); ?>" alt="<?php echo esc_attr($dep['name']); ?>" class="nc-dep-avatar">
                <div>
                  <p class="nc-dep-name"><?php echo esc_html($dep['name']); ?></p>
                  <p class="nc-dep-role"><?php echo esc_html($dep['role']); ?></p>
                </div>
              </div>
            </div>
            <?php endforeach;
            endif; ?>
          </div>
        </div>

        <div class="nc-carousel-arrows">
          <button class="arrow-btn" id="nc-dep-prev" aria-label="Anterior"><i class="fa-solid fa-chevron-left"></i></button>
          <button class="arrow-btn" id="nc-dep-next" aria-label="Próximo"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
      </div>
    </section>
    <script>
    (function(){
      var grid = document.getElementById('nc-dep-grid');
      if (!grid) return;
      var cards = Array.from(grid.children);
      var perPage = window.innerWidth < 768 ? 1 : window.innerWidth < 1024 ? 2 : 3;
      var current = 0;
      var total = cards.length;
      function show(idx) {
        current = ((idx % total) + total) % total;
        cards.forEach(function(c, i) {
          c.style.display = (i >= current && i < current + perPage) ? '' : 'none';
        });
      }
      show(0);
      document.getElementById('nc-dep-prev').addEventListener('click', function(){ show(current - 1); });
      document.getElementById('nc-dep-next').addEventListener('click', function(){ show(current + 1); });
      window.addEventListener('resize', function(){
        perPage = window.innerWidth < 768 ? 1 : window.innerWidth < 1024 ? 2 : 3;
        show(current);
      });
    })();
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('apepi_depoimentos', 'apepi_shortcode_depoimentos_nc');
add_shortcode('apepi_depoimentos_nc', 'apepi_shortcode_depoimentos_nc');

/**
 * Shortcode: Banner E-books (Nossos Cursos page)
 */
function apepi_shortcode_banner_ebooks($atts) {
    $title     = apepi_get_option('apepi_nc_ebook_title',   'Conhecimento que vai além da sala de aula');
    $subtitle  = apepi_get_option('apepi_nc_ebook_subtitle','Acesse nossos e-books gratuitos e aprofunde ainda mais seus estudos sobre Cannabis Medicinal.');
    $btn_text  = apepi_get_option('apepi_nc_ebook_btn',     'BAIXAR E-BOOKS GRATUITOS');
    $btn_url   = apepi_get_option('apepi_nc_ebook_url',     '#ebooks');
    $cover_img = apepi_get_option('apepi_nc_ebook_cover',   '');

    $default_cover = 'https://images.unsplash.com/photo-1532012197267-da84d127e765?auto=format&fit=crop&w=300&q=80';
    if (empty($cover_img)) $cover_img = $default_cover;

    ob_start();
    ?>
    <section class="nc-ebook-banner-section">
      <div class="container">
        <div class="nc-ebook-banner-inner">
          <div class="nc-ebook-img-wrap">
            <img src="<?php echo esc_url($cover_img); ?>" alt="E-books APEPI Escola">
          </div>
          <div class="nc-ebook-text">
            <h3 class="font-serif"><?php echo esc_html($title); ?></h3>
            <p><?php echo esc_html($subtitle); ?></p>
          </div>
          <div class="nc-ebook-cta">
            <a href="<?php echo esc_url($btn_url); ?>" class="nc-ebook-btn">
              <i class="fa-solid fa-download"></i>
              <?php echo esc_html($btn_text); ?>
            </a>
            <span class="nc-ebook-secure"><i class="fa-solid fa-lock"></i> 100% gratuitos e seguros.</span>
          </div>
        </div>
      </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('apepi_banner_ebooks', 'apepi_shortcode_banner_ebooks');

/**
 * Master Shortcode: Página Nossos Cursos Completa
 */
function apepi_shortcode_pagina_nossos_cursos($atts) {
    $atts = shortcode_atts(array(), $atts);
    ob_start();
    echo do_shortcode('[apepi_lista_cursos title="FORMAÇÕES" badge="NOSSO CATÁLOGO" limit="8"]');
    echo do_shortcode('[apepi_escola_numeros]');
    echo do_shortcode('[apepi_depoimentos]');
    echo do_shortcode('[apepi_banner_ebooks]');
    return ob_get_clean();
}
add_shortcode('apepi_pagina_nossos_cursos', 'apepi_shortcode_pagina_nossos_cursos');

/**
 * Admin options — Nossos Cursos page
 */
add_action('admin_menu', 'apepi_nc_add_admin_submenu');
function apepi_nc_add_admin_submenu() {
    add_submenu_page(
        'apepi-escola-options',
        'Nossos Cursos — Conteúdo',
        'Nossos Cursos',
        'manage_options',
        'apepi-nc-options',
        'apepi_nc_admin_page_callback'
    );
}

function apepi_nc_admin_page_callback() {
    if (isset($_POST['apepi_nc_save']) && check_admin_referer('apepi_nc_nonce_action', 'apepi_nc_nonce')) {
        $fields = array(
            // Números
            'apepi_nc_num1_icon','apepi_nc_num1_value','apepi_nc_num1_label',
            'apepi_nc_num2_icon','apepi_nc_num2_value','apepi_nc_num2_label',
            'apepi_nc_num3_icon','apepi_nc_num3_value','apepi_nc_num3_label',
            'apepi_nc_num4_icon','apepi_nc_num4_value','apepi_nc_num4_label',
            'apepi_nc_num5_icon','apepi_nc_num5_value','apepi_nc_num5_label',
            // Depoimentos
            'apepi_nc_dep_badge','apepi_nc_dep_title','apepi_nc_dep_subtitle',
            'apepi_nc_dep1_text','apepi_nc_dep1_name','apepi_nc_dep1_role','apepi_nc_dep1_avatar',
            'apepi_nc_dep2_text','apepi_nc_dep2_name','apepi_nc_dep2_role','apepi_nc_dep2_avatar',
            'apepi_nc_dep3_text','apepi_nc_dep3_name','apepi_nc_dep3_role','apepi_nc_dep3_avatar',
            // E-books
            'apepi_nc_ebook_title','apepi_nc_ebook_subtitle','apepi_nc_ebook_btn','apepi_nc_ebook_url','apepi_nc_ebook_cover',
        );
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $val = in_array($field, array('apepi_nc_dep1_text','apepi_nc_dep2_text','apepi_nc_dep3_text','apepi_nc_dep_subtitle','apepi_nc_ebook_subtitle'))
                    ? sanitize_textarea_field($_POST[$field])
                    : sanitize_text_field($_POST[$field]);
                update_option($field, $val);
                set_theme_mod($field, $val);
            }
        }
        echo '<div class="notice notice-success is-dismissible" style="margin-top:12px;"><p><strong>Configurações da página Nossos Cursos salvas com sucesso!</strong></p></div>';
    }

    // Load values
    $v = function($key, $default = '') { return apepi_get_option($key, $default); };
    ?>
    <div class="wrap">
        <h1 style="font-size:24px;font-weight:700;color:#003E19;">APEPI Escola — Nossos Cursos (Conteúdo da Página)</h1>
        <p style="color:#555;font-size:14px;">Edite os textos, números, depoimentos e configurações do banner de e-books.</p>
        <hr style="margin-bottom:20px;">

        <form method="post" action="">
            <?php wp_nonce_field('apepi_nc_nonce_action', 'apepi_nc_nonce'); ?>
            <style>
            .apepi-admin-card { background:#fff; border:1px solid #ccd0d4; border-radius:8px; padding:20px 24px; margin-bottom:20px; }
            .apepi-admin-card h2 { margin-top:0; padding-bottom:10px; border-bottom:1px solid #eee; color:#003E19; font-size:17px; }
            .nc-grid-row { display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; margin-bottom:10px; }
            .nc-dep-group { border:1px solid #e8e8e8; border-radius:6px; padding:14px; margin-bottom:12px; background:#fafafa; }
            .nc-dep-group h4 { margin:0 0 10px; color:#444; font-size:14px; }
            </style>

            <!-- 1. APEPI em Números -->
            <div class="apepi-admin-card">
                <h2>1. Seção "APEPI Escola em Números" (5 itens)</h2>
                <?php
                $nums = array(
                    1 => array('Ícone FA', '14 anos', 'de experiência na educação canábica', 'fa-solid fa-award'),
                    2 => array('Ícone FA', '+1000', 'alunos formados e preparados para fazer a diferença', 'fa-solid fa-users'),
                    3 => array('Ícone FA', '+10h', 'de conteúdo — aulas online e ao vivo', 'fa-solid fa-play-circle'),
                    4 => array('Ícone FA', 'Formação completa', 'da teoria à prática, com segurança', 'fa-solid fa-graduation-cap'),
                    5 => array('Ícone FA', 'E-books gratuitos', 'materiais exclusivos para aprofundar', 'fa-solid fa-book-open'),
                );
                foreach ($nums as $n => $def) : ?>
                <div class="nc-grid-row">
                    <div>
                        <label style="font-size:12px;font-weight:600;display:block;margin-bottom:3px;">Item <?php echo $n; ?> — Ícone FontAwesome</label>
                        <input type="text" name="apepi_nc_num<?php echo $n; ?>_icon" value="<?php echo esc_attr($v("apepi_nc_num{$n}_icon", $def[3])); ?>" class="regular-text" placeholder="<?php echo esc_attr($def[3]); ?>">
                    </div>
                    <div>
                        <label style="font-size:12px;font-weight:600;display:block;margin-bottom:3px;">Valor / Número</label>
                        <input type="text" name="apepi_nc_num<?php echo $n; ?>_value" value="<?php echo esc_attr($v("apepi_nc_num{$n}_value", $def[1])); ?>" class="regular-text">
                    </div>
                    <div>
                        <label style="font-size:12px;font-weight:600;display:block;margin-bottom:3px;">Legenda / Descrição</label>
                        <input type="text" name="apepi_nc_num<?php echo $n; ?>_label" value="<?php echo esc_attr($v("apepi_nc_num{$n}_label", $def[2])); ?>" class="regular-text">
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- 2. Depoimentos -->
            <div class="apepi-admin-card">
                <h2>2. Seção "Depoimentos" — Textos e Cabeçalho</h2>
                <table class="form-table">
                    <tr>
                        <th><label for="apepi_nc_dep_badge">Badge (ex: DEPOIMENTOS)</label></th>
                        <td><input type="text" id="apepi_nc_dep_badge" name="apepi_nc_dep_badge" value="<?php echo esc_attr($v('apepi_nc_dep_badge','DEPOIMENTOS')); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th><label for="apepi_nc_dep_title">Título Principal</label></th>
                        <td><input type="text" id="apepi_nc_dep_title" name="apepi_nc_dep_title" value="<?php echo esc_attr($v('apepi_nc_dep_title','O que nossos alunos dizem')); ?>" class="large-text"></td>
                    </tr>
                    <tr>
                        <th><label for="apepi_nc_dep_subtitle">Subtítulo / Descrição</label></th>
                        <td><textarea id="apepi_nc_dep_subtitle" name="apepi_nc_dep_subtitle" rows="2" class="large-text"><?php echo esc_textarea($v('apepi_nc_dep_subtitle','Histórias reais...')); ?></textarea></td>
                    </tr>
                </table>

                <p style="margin-top:16px;font-size:13px;color:#555;">⚠️ Os depoimentos abaixo são usados como <strong>fallback</strong> quando não há posts do tipo "Depoimento" cadastrados no WordPress.</p>

                <?php $dep_defaults = array(
                    1 => array(
                        'text' => 'O curso mudou completamente minha visão sobre o tratamento com Cannabis. Hoje me sinto seguro para prescrever e acompanhar meus pacientes.',
                        'name' => 'Dr. Rafael M.',
                        'role' => 'Médico',
                        'avatar' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=200&q=80',
                    ),
                    2 => array(
                        'text' => 'Conteúdo completo, professores excelentes e uma didática que facilita o entendimento mesmo dos temas mais complexos. Recomendo!',
                        'name' => 'Dra. Juliana T.',
                        'role' => 'Médica Veterinária',
                        'avatar' => 'https://images.unsplash.com/photo-1651008376811-b90baee60c1f?auto=format&fit=crop&w=200&q=80',
                    ),
                    3 => array(
                        'text' => 'A parte prática e a visita à fazenda foram experiências incríveis que fizeram toda a diferença na minha formação.',
                        'name' => 'Dr. Lucas P.',
                        'role' => 'Médico',
                        'avatar' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=200&q=80',
                    ),
                );
                foreach ($dep_defaults as $d => $dd) : ?>
                <div class="nc-dep-group">
                    <h4>Depoimento <?php echo $d; ?></h4>
                    <table class="form-table" style="margin:0;">
                        <tr>
                            <th style="width:130px;"><label>Texto</label></th>
                            <td><textarea name="apepi_nc_dep<?php echo $d; ?>_text" rows="2" class="large-text"><?php echo esc_textarea($v("apepi_nc_dep{$d}_text", $dd['text'])); ?></textarea></td>
                        </tr>
                        <tr>
                            <th><label>Nome</label></th>
                            <td><input type="text" name="apepi_nc_dep<?php echo $d; ?>_name" value="<?php echo esc_attr($v("apepi_nc_dep{$d}_name", $dd['name'])); ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th><label>Cargo / Profissão</label></th>
                            <td><input type="text" name="apepi_nc_dep<?php echo $d; ?>_role" value="<?php echo esc_attr($v("apepi_nc_dep{$d}_role", $dd['role'])); ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th><label>URL da Foto</label></th>
                            <td><input type="text" name="apepi_nc_dep<?php echo $d; ?>_avatar" value="<?php echo esc_attr($v("apepi_nc_dep{$d}_avatar", $dd['avatar'])); ?>" class="large-text" placeholder="https://..."></td>
                        </tr>
                    </table>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- 3. Banner E-books -->
            <div class="apepi-admin-card">
                <h2>3. Banner "E-books Gratuitos" (rodapé da página Nossos Cursos)</h2>
                <table class="form-table">
                    <tr>
                        <th><label for="apepi_nc_ebook_title">Título</label></th>
                        <td><input type="text" id="apepi_nc_ebook_title" name="apepi_nc_ebook_title" value="<?php echo esc_attr($v('apepi_nc_ebook_title','Conhecimento que vai além da sala de aula')); ?>" class="large-text"></td>
                    </tr>
                    <tr>
                        <th><label for="apepi_nc_ebook_subtitle">Subtítulo / Descrição</label></th>
                        <td><textarea id="apepi_nc_ebook_subtitle" name="apepi_nc_ebook_subtitle" rows="2" class="large-text"><?php echo esc_textarea($v('apepi_nc_ebook_subtitle','Acesse nossos e-books gratuitos...')); ?></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="apepi_nc_ebook_btn">Texto do Botão</label></th>
                        <td><input type="text" id="apepi_nc_ebook_btn" name="apepi_nc_ebook_btn" value="<?php echo esc_attr($v('apepi_nc_ebook_btn','BAIXAR E-BOOKS GRATUITOS')); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th><label for="apepi_nc_ebook_url">Link do Botão</label></th>
                        <td><input type="text" id="apepi_nc_ebook_url" name="apepi_nc_ebook_url" value="<?php echo esc_attr($v('apepi_nc_ebook_url','#ebooks')); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th><label for="apepi_nc_ebook_cover">URL da Capa do E-book (imagem)</label></th>
                        <td>
                            <div style="display:flex;gap:10px;align-items:center;">
                                <input type="text" id="apepi_nc_ebook_cover" name="apepi_nc_ebook_cover" value="<?php echo esc_attr($v('apepi_nc_ebook_cover','')); ?>" class="large-text" placeholder="https://...">
                                <button type="button" class="button apepi-upload-btn">Selecionar</button>
                            </div>
                            <?php $cover = $v('apepi_nc_ebook_cover',''); if ($cover) : ?>
                            <img src="<?php echo esc_url($cover); ?>" style="max-height:70px;margin-top:8px;border:1px solid #ddd;border-radius:4px;" alt="E-book cover preview">
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>

            <p class="submit">
                <input type="submit" name="apepi_nc_save" class="button button-primary button-hero" value="Salvar Configurações da Página Nossos Cursos">
            </p>
        </form>
    </div>
    <script>
    jQuery(document).ready(function($){
        $('.apepi-upload-btn').off('click').on('click', function(e) {
            e.preventDefault();
            var btn = $(this);
            var targetInput = btn.prev('input');
            wp.media({ title: 'Selecionar Imagem', button: { text: 'Usar esta Imagem' }, multiple: false })
              .on('select', function() {
                  var att = this.state().get('selection').first().toJSON();
                  targetInput.val(att.url);
              }.bind(this)).open();
        });
    });
    </script>
    <?php
}
