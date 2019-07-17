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
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/Applications/MAMP/htdocs/kassim/wp-content/plugins/wp-super-cache/' );
define( 'DB_NAME', 'lumoo' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', 'root' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost:8889' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         ': ;QzO(c?$1ayZ|^u%]L9TewBJhx2:daCn6:e|HyU{=1H[Pw8*~C[ @ry(mFD<n%' );
define( 'SECURE_AUTH_KEY',  'tTj_|V|~1w?^,zEOYk_wwEm[YjZX&Mana_DX#tZHYYo)M@VU?5B$, vK7p2$^>i]' );
define( 'LOGGED_IN_KEY',    'EjQF<M)uF#Wa::{3.]&P]<j1*@eAAZ^A=ii+bhB7:nn@._@(g`@v:UZ~S&@NfQ5[' );
define( 'NONCE_KEY',        'Wuj<{T$V&2+F8WoEt~bq`Xl 8|6pD|-H8tUhKmorVqE6UIFa|=<$k)|1JtS4l7N%' );
define( 'AUTH_SALT',        'FW,rbX]% c&i/CM>zW:@Mf2usJjRKD1Dx[#{M2.[E*A[66Fy^5@l}Ic7Sw5]h5`n' );
define( 'SECURE_AUTH_SALT', '7:`yjcR4zn.;~TTL_DoOrN aa/cZ:a<sKiSpok&Dlg,^ 8}&uFs=O<fQg3XxDdc/' );
define( 'LOGGED_IN_SALT',   '$$[ZJ~[LmVrlFBir6_Q2/ozC9MYc|i`,%;+ravW.o2it+P:iQc?n K`5d^v5t=yT' );
define( 'NONCE_SALT',       '8h?6rd+Xzp{?(i6H70|I}G.g5*SFOU6*<O#v jYC5@r> IVnHjMGIB*9XR2$=3^,' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'lum_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
