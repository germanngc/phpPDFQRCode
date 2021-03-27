<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/home4/prozoico/public_html/wp-content/plugins/wp-super-cache/' );
define( 'DB_NAME', 'prozoico_prozo1' );

/** MySQL database username */
define( 'DB_USER', 'prozoico_adProzo1' );

/** MySQL database password */
define( 'DB_PASSWORD', 'V(i*B50vCq]r' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'U~/]xV3/3+sj^yG7KUPFpTShp|p=wZ2e2[gs{Df53QFON3x`X,*)?.malqJ1cwWA' );
define( 'SECURE_AUTH_KEY',  'q@1 9&&=K%(nA=L_Z*UbgQ~-s-.:Dho_spk#HbjcC5-`[d+Wd@S}mN+Ws^~BL%`]' );
define( 'LOGGED_IN_KEY',    '%`efuM%Y!gNVV?)!4_hME=qhA`HeuFldFf=Yui+KkG;z6TJDJI?icN~JsmdhZ!qC' );
define( 'NONCE_KEY',        'ZP[TUN9vs}v&&~-h2TH:xlOq8]mN$qI};8JE^0]$$X_Ya_g}DW8[b7R~*dF6X/my' );
define( 'AUTH_SALT',        'rU/&.{?G{Cf.?ZD[h:^VsY.-JJYpn:x8f>F1Lv;zXi&zIlO_d^].at{(wx/0qnB4' );
define( 'SECURE_AUTH_SALT', '6f/b3^h}6r8R9`(R>RO6@bBUON:1;^JR!9RjgglcH-!MGC]>W SHov=S>cDjc.:Q' );
define( 'LOGGED_IN_SALT',   '.MET!kBv(Mqh>wG0n3!qgQM3:kO-DCsVD7rnu.vNtT+c4kInp@s<?4B35`Pc%ggt' );
define( 'NONCE_SALT',       ',!t{i^0xJ-12:ZRB_^r5RSm./5De At#1=6Ho!mmdJc =LtPMX#W((4d5Y{}aP&3' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'pr0zoi_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
