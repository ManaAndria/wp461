<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'wp461');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', '');

/** Adresse de l’hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8mb4');

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '!bTjPvpR=8gie-hR=?ytC{LkhRb=KhYzd&1?cEysS~Gnfn=$5gF(v_lU.iMAq[hC');
define('SECURE_AUTH_KEY',  ')>(qXUPzS)YON*WKoFQ_=H=:Z=/{h3IZ;{J [^24s,:%X#s7Imb#$Yg#QhGg/7,N');
define('LOGGED_IN_KEY',    'rDsK$!F=+>OiN>u2zrJ!iPOobsP;!?1-Rj,8/7ml,1[Z(T$kanpQYqH5?x[CDizP');
define('NONCE_KEY',        'mGWv3f&!qf]s[tvY2u78K]*@E*y^d>[Iz1P19 mh_ u43kC/HTtO6F3aRt}m6R)b');
define('AUTH_SALT',        'Yc|AAbZG~Y7&s]iBc0HZ8zW+pWZ1nf55DD)<W|j!TY-}|08u947%Iae2j?k/.=QF');
define('SECURE_AUTH_SALT', '/:O!z{54{@BY0TGdX$,Qrk:]rYFN C4SfZA|/+:RNe`Wj6F-8{@:H|)W>:&W;qf!');
define('LOGGED_IN_SALT',   'UBC!@!DBM#KA?bG/z&>UGr]>s|833mD*|GR/v^n.TlEDLN93FP;l:>g7~y<b!WRh');
define('NONCE_SALT',       '4TKD?*]qG0@5GPc>3T{@)U3xno*e=A5[Lo%4Noxmo+$kgj5a5l)_Uwe.B0R#FI<L');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix  = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d'information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);

/* C’est tout, ne touchez pas à ce qui suit ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');