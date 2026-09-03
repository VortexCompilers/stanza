<?php
/**
 * English (en-US) — base language.
 *
 * This file is the reference dictionary: every other language file must carry
 * exactly these keys, in this order. When a key is missing from another
 * language, the loader falls back to the value defined here.
 *
 * The array is named $strings, NOT $text: backend/edit.php, backend/read.php
 * and backend/update.php already use $text for the text row fetched from the
 * database, and the two would overwrite each other.
 *
 * Not translated on purpose:
 *   - "Stanza" (brand name)
 *   - language names in the pickers (English / Português / Español) — each
 *     language is always written in its own language, so a reader can find
 *     their own no matter which UI language is active.
 */

$strings = [

    // ------------------------------------------------------------
    // Shared actions (buttons and links reused across screens)
    // ------------------------------------------------------------
    'action_save'            => 'Save',
    'action_cancel'          => 'Cancel',
    'action_edit'            => 'Edit',
    'action_delete'          => 'Delete',
    'action_confirm'         => 'Confirm',
    'action_close'           => 'Close',
    'action_search'          => 'Search',
    'action_filter'          => 'Filter',
    'action_write'           => 'Write',

    // ------------------------------------------------------------
    // Navigation — nav.php
    // ------------------------------------------------------------
    'nav_create'             => '+ Create',
    'nav_home'               => 'Home',
    'nav_explore'            => 'Explore',
    'nav_profile'            => 'My profile',
    'nav_settings'           => 'Settings',

    // ------------------------------------------------------------
    // Landing page — landing.php
    // The hero headings are split in two because the first word is
    // styled with an accent colour: <h1><span>ACCENT</span> REST</h1>.
    // Both halves are separate keys so word order can change per language.
    // ------------------------------------------------------------
    'landing_hero_line1_accent'  => 'Create',
    'landing_hero_line1_rest'    => 'texts',
    'landing_hero_line2_accent'  => 'Imagine',
    'landing_hero_line2_rest'    => 'more',
    'landing_hero_subtitle'      => 'Write stories, share ideas, take the next step',
    'landing_demo_label'         => 'Reading',
    'landing_demo_placeholder'   => 'Write the first verse...',
    'landing_cta_register'       => 'Create account',
    'landing_cta_login'          => 'I already have access',
    'landing_explore_title'      => 'Explore, search',
    'landing_search_label'       => 'Search',
    'landing_search_placeholder' => 'Search by title, author or theme',

    // ------------------------------------------------------------
    // Sign-in pop-up — partials/modal-login.php
    // ------------------------------------------------------------
    'auth_login_title'           => 'Sign in',
    'auth_login_section'         => 'Access',
    'auth_field_email_or_name'   => 'E-mail/Name',
    'auth_field_password'        => 'Password',
    'auth_forgot'                => 'I forgot my access',
    'auth_submit_login'          => 'Sign in',

    // ------------------------------------------------------------
    // Sign-up pop-up — partials/modal-register.php
    // ------------------------------------------------------------
    'auth_register_title'            => 'Create account',
    'auth_register_section_details'  => 'Your details',
    'auth_register_section_access'   => 'Access',
    'auth_field_name'                => 'Name',
    'auth_field_gender'              => 'Gender',
    'auth_field_birthdate'           => 'Date of birth',
    'auth_field_email'               => 'E-mail',
    'auth_link_have_account'         => 'I already have an account',
    'auth_submit_register'           => 'Complete registration',

    // Gender options
    'gender_select'          => 'Select',
    'gender_male'            => 'Male',
    'gender_female'          => 'Female',
    'gender_other'           => 'Other',

    // ------------------------------------------------------------
    // Verification screen — auth.php
    // (screen is not wired to the backend yet; keys are here so the
    //  page is covered when it is)
    // %s is the e-mail address the code was sent to.
    // ------------------------------------------------------------
    'verify_title'           => 'Authenticate',
    'verify_code_label'      => 'Enter the code sent to %s',
    'verify_terms'           => 'I agree to the terms and conditions',
    'verify_submit'          => 'Confirm',
    'verify_resend'          => 'Resend code',

    // ------------------------------------------------------------
    // Home — home.php
    // ------------------------------------------------------------
    'home_search_placeholder'   => 'Search..',
    'home_recently_viewed'      => 'Recently viewed',
    'home_explore_by'           => 'Explore by',
    'home_card_books'           => 'Books',
    'home_card_poetry'          => 'Poetry',
    'home_card_stories'         => 'Stories',
    'home_tops'                 => 'Tops',
    'home_most_viewed'          => 'Most viewed',
    'home_most_favorited'       => 'Most favourited',
    'home_recently_published'   => 'Recently published',
    'home_saved_texts'          => 'Saved texts',

    // ------------------------------------------------------------
    // Catalog — catalog.php
    // ------------------------------------------------------------
    'catalog_search_placeholder' => 'Search...',
    'catalog_filter_title'       => 'Filter',
    'catalog_sort_by'            => 'Sort by',
    'catalog_sort_recent'        => 'Recent',
    'catalog_sort_most_saved'    => 'Most saved',
    'catalog_sort_most_viewed'   => 'Most viewed',
    'catalog_category_label'     => 'Category',

    // ------------------------------------------------------------
    // Categories — shared by create.php, edit.php and catalog.php.
    // Values match the texts.category ENUM: book, poetry, story.
    // ------------------------------------------------------------
    'category_placeholder'   => 'Category',
    'category_book'          => 'Book',
    'category_poetry'        => 'Poetry',
    'category_story'         => 'Short story',

    // ------------------------------------------------------------
    // Editor — create.php, edit.php, read.php
    // ------------------------------------------------------------
    'editor_create_title'        => 'Create',
    'editor_cover'               => 'Cover',
    'editor_current_cover_alt'   => 'Current cover',
    'editor_title'               => 'Title',
    'editor_description'         => 'Description',
    'editor_category'            => 'Category',
    'editor_language'            => 'Language',
    'editor_language_placeholder' => 'Language',
    'editor_visibility'          => 'Visibility',
    'editor_visibility_warning'  => 'Every user will be able to see your text, even unfinished',
    'editor_font_size'           => 'Font size',
    'editor_font_size_inline'    => 'Font size:',
    'editor_words'               => 'words',
    'editor_characters'          => 'characters',
    'editor_body_label'          => 'Write',
    'editor_submit_create'       => 'Write',
    'editor_confirm_delete'      => 'Delete this text? This action cannot be undone.',

    // Visibility options — match the texts.visibility ENUM
    'visibility_public'      => 'Public',
    'visibility_private'     => 'Private',

    // ------------------------------------------------------------
    // Profile — profile.php
    // %s is the month and year the account was created.
    // ------------------------------------------------------------
    'profile_joined'         => 'Joined in %s',
    'profile_views'          => 'views',
    'profile_texts_written'  => 'texts written',
    'profile_texts_saved'    => 'saved texts',

    // ------------------------------------------------------------
    // Settings — settings.php
    // ------------------------------------------------------------
    'settings_general'           => 'General',
    'settings_theme'             => 'Theme',
    'settings_theme_light'       => 'Light',
    'settings_theme_dark'        => 'Dark',
    'settings_default_font_size' => 'Default font size',
    'settings_language'          => 'Language',
    'settings_profile'           => 'Profile',
    'settings_profile_picture'   => 'Profile picture',
    'settings_username'          => 'Username',
    'settings_email'             => 'E-mail',
    'settings_password'          => 'Password',
    'settings_delete_account'    => 'Delete account',
    'settings_logout'            => 'Log out',

    // ------------------------------------------------------------
    // Shared units
    // ------------------------------------------------------------
    'views'                  => 'views',
    'favorites'              => 'favourites',

    // ------------------------------------------------------------
    // Feedback messages.
    // Keys mirror the ?erro= / ?msg= values the backend redirects with,
    // so a screen can map them straight to a message.
    // ------------------------------------------------------------
    'error_empty_fields'         => 'Fill in all the fields.',
    'error_invalid_credentials'  => 'Incorrect e-mail/name or password.',
    'error_email_taken'          => 'This e-mail is already registered.',
    'error_upload_failed'        => 'The image could not be uploaded. Try again.',
    'error_invalid_format'       => 'Unsupported image format. Use JPG, PNG or WEBP.',
    'error_internal'             => 'Something went wrong on our side. Try again.',
    'error_no_permission'        => 'You do not have permission to access this text.',
    'error_text_not_found'       => 'Text not found.',
    'error_generic'              => 'An error occurred. Try again.',

    'success_text_deleted'       => 'Text deleted.',

];
