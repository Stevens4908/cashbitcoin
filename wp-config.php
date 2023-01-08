<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'bitcoinstereo' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'FUE<.?.]tE~G^bj#;=:`W9Cb3R3Yu){2:2MIvJh-/KgGv@_j.lx-*(ICJM[#Mo4e');
define('SECURE_AUTH_KEY',  'Pq,$&|J>,aC,e)f#?L!G83YV^g+R|Y)G7h3Nl[Q)E2G|jkl-$91Ldbg.(&cXa6{2');
define('LOGGED_IN_KEY',    'd1-6;eNP1jd<Ez~$z|lM5Z3!E`=bKD[NG*Z*-02wC_rUt(=Q+nuPyS/#_3J7alnW');
define('NONCE_KEY',        '*d<ln+&=t~^a{=r3ScOusQp+QyXI fcZO|t8@Gh{ofSbB=Bmm*Unlb{P}U/1ttpd');
define('AUTH_SALT',        '1sscukK-ikv5,+Sep92r3.|G=I+w0$$+.Tr4:~/]:p1AJKMpS!;lR|NQfR_Z]j+T');
define('SECURE_AUTH_SALT', 'P:+>T8[*{_ 7_-`-A&Y3sap-Y+?C%~_3>M5JWnK-@Q#}##VKOf#X0uQ! 6k K;IJ');
define('LOGGED_IN_SALT',   'CFW@>y32|jF,;8[n]-N[G:y<`b|0{V0zR;C3/{<Jr0#}axr<uk]:VExKy <DG$Px');
define('NONCE_SALT',       '(L]ka_.}4m:!*enbb$P5s=<|pi.]Gj)EH`.zw||~UL$EH,dq<<n3&JIv9>3GXUhc');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
