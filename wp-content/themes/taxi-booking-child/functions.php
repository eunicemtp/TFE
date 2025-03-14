<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'bootstrap-css','fontawesome-css','owl-carousel-css' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );

// END ENQUEUE PARENT ACTION

if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        list($key, $value) = explode('=', $line, 2);
        $_ENV[$key] = trim($value);
    }
}

// function supprimer_tous_google_maps() {
//     global $wp_scripts;

//     foreach ($wp_scripts->registered as $handle => $script) {
//         if (strpos($script->src, 'maps.googleapis.com') !== false) {
//             wp_dequeue_script($handle);
//             wp_deregister_script($handle);
//         }
//     }

//     // Empêcher `e-cab taxi` de recharger Google Maps
//     remove_action('wp_enqueue_scripts', 'ecab_taxi_load_maps', 10);
//     remove_action('wp_print_scripts', 'ecab_taxi_load_maps', 10);
// }
// add_action('wp_enqueue_scripts', 'supprimer_tous_google_maps', 99);



function bouton_sos_shortcode() {
    return '<button id="sos-btn">🚨 SOS</button>';
}
add_shortcode('bouton_sos', 'bouton_sos_shortcode');


function envoyer_sos_sms() {
    header('Content-Type: application/json');

    // Vérifier si l'utilisateur est connecté
    if (!is_user_logged_in()) {
        echo json_encode(["message" => "🚨 Erreur : Vous devez être connecté pour envoyer une alerte SOS."]);
        wp_die();
    }

    // Récupérer l'ID utilisateur et son numéro de téléphone
    $user_id = get_current_user_id();
    // $user_phone = get_user_meta($user_id, 'billing_phone', true); // Récupération du téléphone (WooCommerce)

    if (empty($user_phone)) {
        echo json_encode(["message" => "🚨 Erreur : Aucun numéro de téléphone enregistré dans votre compte."]);
        wp_die();
    }

    // Récupérer la localisation envoyée par AJAX
    $latitude = isset($_POST['latitude']) ? sanitize_text_field($_POST['latitude']) : null;
    $longitude = isset($_POST['longitude']) ? sanitize_text_field($_POST['longitude']) : null;

    if (!$latitude || !$longitude) {
        echo json_encode(["message" => "🚨 Erreur : WordPress n’a pas reçu la localisation.", "debug" => $_POST]);
        wp_die();
    }

    // Clé API SMSBOX
    $apikey = $_ENV['SMSBOX_API_KEY'];

    // Construire le message avec la localisation GPS
    $locationLink = "http://maps.google.com/?q=$latitude,$longitude";
    $message = "🚨 ALERTE SOS ! Je suis en danger. Localisation : $locationLink";

    // Envoyer le SMS via SMSBOX
    $response = sendsms($apikey, $user_phone, $message);

    // Vérifier la réponse de SMSBOX
    if ($response && isset($response['status']) && $response['status'] == 'success') {
        echo json_encode(["message" => "🚨 Alerte envoyée avec succès !", "response" => $response]);
    } else {
        echo json_encode(["message" => "❌ Erreur lors de l'envoi du SMS.", "debug" => $response]);
    }

    wp_die();
}



// Fonction pour envoyer un SMS via SMSBOX
function sendsms($apikey, $mobile, $message) {
    $data = [
        "mobile" => $mobile,
        "message" => $message
    ];

    $response = sendToHost($apikey, "https://core.smsbox.be/api/v2/message/send", json_encode($data));
    return json_decode($response, true);
}

// Fonction pour envoyer les données via cURL
function sendToHost($apikey, $url, $data) {
    $headers = [
        "X-Api-Key: " . $apikey,
        "Content-Type: application/json"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_HEADER, 0); // Enlève les headers pour un retour propre

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

// Ajouter l'Ajax pour les utilisateurs connectés et non connectés
add_action('wp_ajax_send_sos_sms', 'envoyer_sos_sms');
add_action('wp_ajax_nopriv_send_sos_sms', 'envoyer_sos_sms');




function charger_script_sos() {
    wp_enqueue_script('sos-js', get_stylesheet_directory_uri() . '/js/sos.js', [], null, true);
    echo '<script>var wp_ajax_url = "' . admin_url('admin-ajax.php') . '";</script>';
}
add_action('wp_enqueue_scripts', 'charger_script_sos');



// Ajouter l'Ajax pour les utilisateurs connectés et non connectés
add_action('wp_ajax_send_sos_sms', 'envoyer_sos_sms');
add_action('wp_ajax_nopriv_send_sos_sms', 'envoyer_sos_sms');


//FORMULAIRE LOGIN FR

function custom_login_text_translations( $translated_text, $text, $domain ) {
    switch ( $text ) {
        case 'Username or email address':
            return 'Nom d’utilisateur ou adresse e-mail';
        case 'Email address':
            return 'Adresse e-mail';
        case 'Password':
            return 'Mot de passe';
        case 'Log in':
            return 'Se connecter';
        case 'Login':
            return 'Se connecter';
        case 'Remember me':
            return 'Se souvenir de moi';
        case 'Lost your password?':
            return 'Mot de passe oublié ?';
        case 'Register':
            return 'S’inscrire';
        case 'Lost Password':
            return 'Mot de passe oublié';
        case 'Get New Password':
            return 'Obtenir un nouveau mot de passe';
        case 'Confirm new password':
            return 'Confirmer le nouveau mot de passe';
        case 'Save Password':
            return 'Enregistrer le mot de passe';
        case 'Registration confirmation will be emailed to you.':
            return 'Une confirmation d’inscription vous sera envoyée par e-mail.';
        case 'A link to set a new password will be sent to your email address.':
            return 'Un lien pour définir un nouveau mot de passe sera envoyé à votre adresse électronique.';
        case 'Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our':
            return "Vos données personnelles seront utilisées pour faciliter votre expérience sur ce site web, pour gérer l'accès à votre compte et pour d'autres raisons décrites dans notre";
    }
    return $translated_text;
}
add_filter( 'gettext', 'custom_login_text_translations', 20, 3 );

function custom_add_phone_field_registration() {
    ?>
    <p class="form-row form-row-wide">
        <label for="reg_billing_phone"><?php _e( 'Numéro de téléphone', 'woocommerce' ); ?> <span class="required">*</span></label>
        <input type="tel" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php if ( ! empty( $_POST['billing_phone'] ) ) echo esc_attr( wp_unslash( $_POST['billing_phone'] ) ); ?>" required />
    </p>
    <?php
}
add_action( 'woocommerce_register_form', 'custom_add_phone_field_registration' );

function custom_validate_phone_field_registration( $errors, $username, $email ) {
    if ( empty( $_POST['billing_phone'] ) ) {
        $errors->add( 'billing_phone_error', __( '<strong>Erreur</strong>: Veuillez entrer un numéro de téléphone.', 'woocommerce' ) );
    }
    return $errors;
}
add_filter( 'woocommerce_registration_errors', 'custom_validate_phone_field_registration', 10, 3 );

function custom_save_phone_field_registration( $customer_id ) {
    if ( isset( $_POST['billing_phone'] ) ) {
        update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
    }
}
add_action( 'woocommerce_created_customer', 'custom_save_phone_field_registration' );

function custom_add_phone_field_edit_account( $user ) {
    ?>
    <p class="form-row form-row-wide">
        <label for="billing_phone"><?php _e( 'Numéro de téléphone', 'woocommerce' ); ?></label>
        <input type="tel" class="input-text" name="billing_phone" id="billing_phone" value="<?php echo esc_attr( get_user_meta( $user->ID, 'billing_phone', true ) ); ?>" />
    </p>
    <?php
}
add_action( 'woocommerce_edit_account_form', 'custom_add_phone_field_edit_account' );

function custom_save_phone_field_edit_account( $user_id ) {
    if ( isset( $_POST['billing_phone'] ) ) {
        update_user_meta( $user_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
    }
}
add_action( 'woocommerce_save_account_details', 'custom_save_phone_field_edit_account' );


function verifier_numero_telephone() {
    header('Content-Type: application/json');

    if (!is_user_logged_in()) {
        echo json_encode(["message" => "Erreur : Vous devez être connecté."]);
        wp_die();
    }

    $user_id = get_current_user_id();
    $user_phone = get_user_meta($user_id, 'billing_phone', true); // Récupère le numéro WooCommerce

    if (empty($user_phone)) {
        echo json_encode(["message" => "Aucun numéro de téléphone enregistré."]);
    } else {
        echo json_encode(["message" => "Numéro trouvé ✅", "numero" => $user_phone]);
    }

    wp_die();
}

add_action('wp_ajax_verifier_numero_telephone', 'verifier_numero_telephone');
add_action('wp_ajax_nopriv_verifier_numero_telephone', 'verifier_numero_telephone'); // (optionnel, pour tester sans connexion)
