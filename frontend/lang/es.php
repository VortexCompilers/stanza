<?php
/**
 * Spanish (es).
 *
 * Keys and order mirror lang/enus.php, which is the base language.
 *
 * Neutral Latin American Spanish, matching the ES-419 option already offered
 * in settings.php. Written by the team, not by a native speaker — have it
 * reviewed before the presentation.
 *
 * See lang/enus.php for why the array is called $strings and for what is
 * deliberately left untranslated.
 */

$strings = [

    // ------------------------------------------------------------
    // Shared actions (buttons and links reused across screens)
    // ------------------------------------------------------------
    'action_save'            => 'Guardar',
    'action_cancel'          => 'Cancelar',
    'action_edit'            => 'Editar',
    'action_delete'          => 'Eliminar',
    'action_confirm'         => 'Confirmar',
    'action_close'           => 'Cerrar',
    'action_search'          => 'Buscar',
    'action_filter'          => 'Filtrar',
    'action_write'           => 'Escribir',

    // ------------------------------------------------------------
    // Navigation — nav.php
    // ------------------------------------------------------------
    'nav_create'             => '+ Crear',
    'nav_home'               => 'Inicio',
    'nav_explore'            => 'Explorar',
    'nav_profile'            => 'Mi perfil',
    'nav_settings'           => 'Configuración',

    // ------------------------------------------------------------
    // Landing page — landing.php
    // ------------------------------------------------------------
    'landing_hero_line1_accent'  => 'Crea',
    'landing_hero_line1_rest'    => 'textos',
    'landing_hero_line2_accent'  => 'Imagina',
    'landing_hero_line2_rest'    => 'más',
    'landing_hero_subtitle'      => 'Escribe historias, comparte ideas, da el siguiente paso',
    'landing_demo_label'         => 'Leyendo',
    'landing_demo_placeholder'   => 'Escribe el primer verso...',
    'landing_demo_label_focus'   => 'Escribiendo',
    'landing_cta_register'       => 'Crear cuenta',
    'landing_cta_login'          => 'Ya tengo acceso',
    'landing_explore_title'      => 'Explora, busca',
    'landing_search_label'       => 'Buscar',
    'landing_search_placeholder' => 'Busca por título, autor o tema',

    // ------------------------------------------------------------
    // Sign-in pop-up — partials/modal-login.php
    // ------------------------------------------------------------
    'auth_login_title'           => 'Conectar',
    'auth_login_section'         => 'Acceso',
    'auth_field_email_or_name'   => 'Correo/Nombre',
    'auth_field_password'        => 'Contraseña',
    'auth_forgot'                => 'Olvidé mi acceso',
    'auth_submit_login'          => 'Entrar',

    // ------------------------------------------------------------
    // Sign-up pop-up — partials/modal-register.php
    // ------------------------------------------------------------
    'auth_register_title'            => 'Crear cuenta',
    'auth_register_section_details'  => 'Tus datos',
    'auth_register_section_access'   => 'Acceso',
    'auth_field_name'                => 'Nombre',
    'auth_field_gender'              => 'Género',
    'auth_field_birthdate'           => 'Fecha de nacimiento',
    'auth_field_email'               => 'Correo electrónico',
    'auth_link_have_account'         => 'Ya tengo cuenta',
    'auth_submit_register'           => 'Completar registro',

    // Gender options
    'gender_select'          => 'Selecciona',
    'gender_male'            => 'Masculino',
    'gender_female'          => 'Femenino',
    'gender_other'           => 'Otro',

    // ------------------------------------------------------------
    // Verification screen — auth.php
    // %s is the e-mail address the code was sent to.
    // ------------------------------------------------------------
    'verify_title'           => 'Autenticar',
    'verify_code_label'      => 'Ingresa el código enviado a %s',
    'verify_terms'           => 'Acepto los términos y condiciones',
    'verify_submit'          => 'Confirmar',
    'verify_resend'          => 'Reenviar código',

    // ------------------------------------------------------------
    // Home — home.php
    // ------------------------------------------------------------
    'home_search_placeholder'   => 'Buscar..',
    'home_recently_viewed'      => 'Vistos recientemente',
    'home_explore_by'           => 'Explorar por',
    'home_card_books'           => 'Libros',
    'home_card_poetry'          => 'Poesía',
    'home_card_stories'         => 'Cuentos',
    'home_tops'                 => 'Tops',
    'home_most_viewed'          => 'Más vistos',
    'home_most_favorited'       => 'Más guardados en favoritos',
    'home_recently_published'   => 'Publicados recientemente',
    'home_saved_texts'          => 'Textos guardados',

    // ------------------------------------------------------------
    // Catalog — catalog.php
    // ------------------------------------------------------------
    'catalog_search_placeholder' => 'Buscar...',
    'catalog_filter_title'       => 'Filtrar',
    'catalog_sort_by'            => 'Ordenar por',
    'catalog_sort_recent'        => 'Recientes',
    'catalog_sort_most_saved'    => 'Más guardados',
    'catalog_sort_most_viewed'   => 'Más vistos',
    'catalog_category_label'     => 'Categoría',

    // ------------------------------------------------------------
    // Categories — shared by create.php, edit.php and catalog.php.
    // Values match the texts.category ENUM: book, poetry, story.
    // ------------------------------------------------------------
    'category_placeholder'   => 'Categoría',
    'category_book'          => 'Libro',
    'category_poetry'        => 'Poesía',
    'category_story'         => 'Cuento',

    // ------------------------------------------------------------
    // Editor — create.php, edit.php, read.php
    // ------------------------------------------------------------
    'editor_create_title'        => 'Crear',
    'editor_cover'               => 'Portada',
    'editor_current_cover_alt'   => 'Portada actual',
    'editor_title'               => 'Título',
    'editor_description'         => 'Descripción',
    'editor_category'            => 'Categoría',
    'editor_language'            => 'Idioma',
    'editor_language_placeholder' => 'Idioma',
    'editor_visibility'          => 'Visibilidad',
    'editor_visibility_warning'  => 'Todos los usuarios podrán ver tu texto, incluso incompleto',
    'editor_font_size'           => 'Tamaño de fuente',
    'editor_font_size_inline'    => 'Tamaño de fuente:',
    'editor_words'               => 'palabras',
    'editor_characters'          => 'caracteres',
    'editor_body_label'          => 'Escribir',
    'editor_submit_create'       => 'Escribir',
    'editor_confirm_delete'      => '¿Eliminar este texto? Esta acción no se puede deshacer.',

    // Visibility options — match the texts.visibility ENUM
    'visibility_public'      => 'Público',
    'visibility_private'     => 'Privado',

    // ------------------------------------------------------------
    // Profile — profile.php
    // %s is the month and year the account was created.
    // ------------------------------------------------------------
    'profile_joined'         => 'Se unió en %s',
    'profile_views'          => 'visualizaciones',
    'profile_texts_written'  => 'textos escritos',
    'profile_texts_saved'    => 'textos guardados',

    // ------------------------------------------------------------
    // Settings — settings.php
    // ------------------------------------------------------------
    'settings_general'           => 'General',
    'settings_theme'             => 'Tema',
    'settings_theme_light'       => 'Claro',
    'settings_theme_dark'        => 'Oscuro',
    'settings_default_font_size' => 'Tamaño de fuente predeterminado',
    'settings_language'          => 'Idioma',
    'settings_profile'           => 'Perfil',
    'settings_profile_picture'   => 'Foto de perfil',
    'settings_username'          => 'Nombre de usuario',
    'settings_email'             => 'Correo electrónico',
    'settings_password'          => 'Contraseña',
    'settings_delete_account'    => 'Eliminar cuenta',
    'settings_logout'            => 'Salir',

    // ------------------------------------------------------------
    // Shared units
    // ------------------------------------------------------------
    'views'                  => 'visualizaciones',
    'favorites'              => 'favoritos',

    // ------------------------------------------------------------
    // Feedback messages.
    // Keys mirror the ?erro= / ?msg= values the backend redirects with.
    // ------------------------------------------------------------
    'error_empty_fields'         => 'Completa todos los campos.',
    'error_invalid_credentials'  => 'Correo/nombre o contraseña incorrectos.',
    'error_email_taken'          => 'Este correo ya está registrado.',
    'error_upload_failed'        => 'No se pudo subir la imagen. Inténtalo de nuevo.',
    'error_invalid_format'       => 'Formato de imagen no admitido. Usa JPG, PNG o WEBP.',
    'error_internal'             => 'Algo salió mal de nuestro lado. Inténtalo de nuevo.',
    'error_no_permission'        => 'No tienes permiso para acceder a este texto.',
    'error_text_not_found'       => 'Texto no encontrado.',
    'error_generic'              => 'Ocurrió un error. Inténtalo de nuevo.',

    'success_text_deleted'       => 'Texto eliminado.',

];
