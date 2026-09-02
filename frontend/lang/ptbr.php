<?php
/**
 * Brazilian Portuguese (pt-BR).
 *
 * Keys and order mirror lang/enus.php, which is the base language. Where the
 * interface already had Portuguese copy, that wording was kept verbatim so the
 * screens read exactly as they do today.
 *
 * See lang/enus.php for why the array is called $strings and for what is
 * deliberately left untranslated.
 */

$strings = [

    // ------------------------------------------------------------
    // Shared actions (buttons and links reused across screens)
    // ------------------------------------------------------------
    'action_save'            => 'Salvar',
    'action_cancel'          => 'Cancelar',
    'action_edit'            => 'Editar',
    'action_delete'          => 'Excluir',
    'action_confirm'         => 'Confirmar',
    'action_close'           => 'Fechar',
    'action_search'          => 'Pesquisar',
    'action_filter'          => 'Filtrar',
    'action_write'           => 'Escrever',

    // ------------------------------------------------------------
    // Navigation — nav.php
    // ------------------------------------------------------------
    'nav_create'             => '+ Criar',
    'nav_home'               => 'Página Inicial',
    'nav_explore'            => 'Explorar',
    'nav_profile'            => 'Meu Perfil',
    'nav_settings'           => 'Configurações',

    // ------------------------------------------------------------
    // Landing page — landing.php
    // ------------------------------------------------------------
    'landing_hero_line1_accent'  => 'Crie',
    'landing_hero_line1_rest'    => 'textos',
    'landing_hero_line2_accent'  => 'Imagine',
    'landing_hero_line2_rest'    => 'mais',
    'landing_hero_subtitle'      => 'Escreva histórias, compartilhe ideias, dê o próximo passo',
    'landing_demo_label'         => 'Lendo',
    'landing_demo_placeholder'   => 'Escreva o primeiro verso...',
    'landing_cta_register'       => 'Criar conta',
    'landing_cta_login'          => 'Já tenho acesso',
    'landing_explore_title'      => 'Explore, busque',
    'landing_search_label'       => 'Procurar',
    'landing_search_placeholder' => 'Busque por título, autor ou tema',

    // ------------------------------------------------------------
    // Sign-in pop-up — partials/modal-login.php
    // ------------------------------------------------------------
    'auth_login_title'           => 'Conectar',
    'auth_login_section'         => 'Acesso',
    'auth_field_email_or_name'   => 'E-mail/Nome',
    'auth_field_password'        => 'Senha',
    'auth_forgot'                => 'Esqueci meu acesso',
    'auth_submit_login'          => 'Entrar',

    // ------------------------------------------------------------
    // Sign-up pop-up — partials/modal-register.php
    // ------------------------------------------------------------
    'auth_register_title'            => 'Criar conta',
    'auth_register_section_details'  => 'Seus dados',
    'auth_register_section_access'   => 'Acesso',
    'auth_field_name'                => 'Nome',
    'auth_field_gender'              => 'Gênero',
    'auth_field_birthdate'           => 'Data de nascimento',
    'auth_field_email'               => 'E-mail',
    'auth_link_have_account'         => 'Já tenho conta',
    'auth_submit_register'           => 'Concluir cadastro',

    // Gender options
    'gender_select'          => 'Selecione',
    'gender_male'            => 'Masculino',
    'gender_female'          => 'Feminino',
    'gender_other'           => 'Outro',

    // ------------------------------------------------------------
    // Verification screen — auth.php
    // %s is the e-mail address the code was sent to.
    // ------------------------------------------------------------
    'verify_title'           => 'Autenticar',
    'verify_code_label'      => 'Insira o código enviado para %s',
    'verify_terms'           => 'Eu concordo com os termos e condições',
    'verify_submit'          => 'Confirmar',
    'verify_resend'          => 'Reenviar código',

    // ------------------------------------------------------------
    // Home — home.php
    // ------------------------------------------------------------
    'home_search_placeholder'   => 'Pesquisar..',
    'home_recently_viewed'      => 'Vistos recentemente',
    'home_explore_by'           => 'Explorar por',
    'home_card_books'           => 'Livros',
    'home_card_poetry'          => 'Poesia',
    'home_card_stories'         => 'Contos',
    'home_tops'                 => 'Tops',
    'home_most_viewed'          => 'Mais vistos',
    'home_most_favorited'       => 'Mais favoritados',
    'home_recently_published'   => 'Publicados recentemente',
    'home_saved_texts'          => 'Textos salvos',

    // ------------------------------------------------------------
    // Catalog — catalog.php
    // ------------------------------------------------------------
    'catalog_search_placeholder' => 'Pesquisar...',
    'catalog_filter_title'       => 'Filtrar',
    'catalog_sort_by'            => 'Ordenar por',
    'catalog_sort_recent'        => 'Recentes',
    'catalog_sort_most_saved'    => 'Mais salvos',
    'catalog_sort_most_viewed'   => 'Mais vistos',
    'catalog_category_label'     => 'Categoria',

    // ------------------------------------------------------------
    // Categories — shared by create.php, edit.php and catalog.php.
    // Values match the texts.category ENUM: book, poetry, story.
    // ------------------------------------------------------------
    'category_placeholder'   => 'Categoria',
    'category_book'          => 'Livro',
    'category_poetry'        => 'Poesia',
    'category_story'         => 'Conto',

    // ------------------------------------------------------------
    // Editor — create.php, edit.php, read.php
    // ------------------------------------------------------------
    'editor_create_title'        => 'Criar',
    'editor_cover'               => 'Capa',
    'editor_current_cover_alt'   => 'Capa atual',
    'editor_title'               => 'Título',
    'editor_description'         => 'Descrição',
    'editor_category'            => 'Categoria',
    'editor_language'            => 'Idioma',
    'editor_language_placeholder' => 'Idioma',
    'editor_visibility'          => 'Visibilidade',
    'editor_visibility_warning'  => 'Todos os usuários poderão ver seu texto, mesmo incompleto',
    'editor_font_size'           => 'Tamanho da fonte',
    'editor_font_size_inline'    => 'Tamanho da fonte:',
    'editor_words'               => 'palavras',
    'editor_characters'          => 'caracteres',
    'editor_body_label'          => 'Escrever',
    'editor_submit_create'       => 'Escrever',
    'editor_confirm_delete'      => 'Apagar este texto? Esta ação não pode ser desfeita.',

    // Visibility options — match the texts.visibility ENUM
    'visibility_public'      => 'Público',
    'visibility_private'     => 'Privado',

    // ------------------------------------------------------------
    // Profile — profile.php
    // %s is the month and year the account was created.
    // ------------------------------------------------------------
    'profile_joined'         => 'Ingressou em %s',
    'profile_views'          => 'visualizações',
    'profile_texts_written'  => 'textos escritos',
    'profile_texts_saved'    => 'textos salvos',

    // ------------------------------------------------------------
    // Settings — settings.php
    // ------------------------------------------------------------
    'settings_general'           => 'Geral',
    'settings_theme'             => 'Tema',
    'settings_theme_light'       => 'Claro',
    'settings_theme_dark'        => 'Escuro',
    'settings_default_font_size' => 'Tamanho de fonte padrão',
    'settings_language'          => 'Idioma',
    'settings_profile'           => 'Perfil',
    'settings_profile_picture'   => 'Foto de Perfil',
    'settings_username'          => 'Nome de usuário',
    'settings_email'             => 'E-mail',
    'settings_password'          => 'Senha',
    'settings_delete_account'    => 'Deletar conta',
    'settings_logout'            => 'Sair',

    // ------------------------------------------------------------
    // Shared units
    // ------------------------------------------------------------
    'views'                  => 'visualizações',

    // ------------------------------------------------------------
    // Feedback messages.
    // Keys mirror the ?erro= / ?msg= values the backend redirects with.
    // ------------------------------------------------------------
    'error_empty_fields'         => 'Preencha todos os campos.',
    'error_invalid_credentials'  => 'E-mail/nome ou senha incorretos.',
    'error_email_taken'          => 'Este e-mail já está cadastrado.',
    'error_upload_failed'        => 'Não foi possível enviar a imagem. Tente novamente.',
    'error_invalid_format'       => 'Formato de imagem não suportado. Use JPG, PNG ou WEBP.',
    'error_internal'             => 'Algo deu errado do nosso lado. Tente novamente.',
    'error_no_permission'        => 'Você não tem permissão para acessar este texto.',
    'error_text_not_found'       => 'Texto não encontrado.',
    'error_generic'              => 'Ocorreu um erro. Tente novamente.',

    'success_text_deleted'       => 'Texto apagado.',

];
