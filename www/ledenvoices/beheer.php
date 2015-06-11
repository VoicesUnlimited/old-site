<?php

header('Cache-Control: no-cache');
header('Expires: -1');

/*
// just for debug purposes...
ini_set('display_errors', 1);
error_reporting(E_ALL|E_STRICT);#
*/

/*

   Program:       htprotector
   Version:       1.5
   Author:        Manuel Hoppe (m.hoppe@hyperspeed.de)
   Contributions: Lutz "ilLUTZminator" (enhanced features)
                  Gerard Bronner (french translation)
                  Hanns Proenen (hanns@data-defenders.de, enhanced features) 
   Homepage:      http://www.hyperspeed.de
   Copyright:     GPL, see http://www.fsf.org/licenses/licenses.html#GPL
   Description:   Protects simply your web directories with a web based
                  front end. Highly configureable.

   Required server settings:
   Apache: Set "AllowOverride AuthConfig" directive for target directory
           (see also http://httpd.apache.org/docs/howto/htaccess.html)
   PHP:    Write access to target directory.
   -> ask your webspace provider for details!

   Please note the defines below. You can edit them to change the
   appearance of various texts (eg. translate it to another language).
   But please be honest to yourself: if you have no clue at all what
   "defines", "strings", etc are: don't change anything. You may break
   this script.

*/

/*
 * If HTP_ADMIN is NOT set, everyone can add, modify and delete user.
 * So it's strongly recommended to define at least one (existing) user.
 * IMPORTANT: If the name is not an existing user, you cannot log in!
 * Example 1: define ( "HTP_ADMIN", "admin" );
 * Example 2: define ( "HTP_ADMIN", "admin,jim,bob" );
 */
define ( "HTP_ADMIN", "beheer" );
/*
 * If HTP_NO_USER_ACCESS is defined, only users as defined in HTP_ADMIN
 * specified are allowed to log in.
 */
define ( "HTP_NO_USER_ACCESS", "yes" );
/*
 * Requires user(s), prevents accidently removal of users.
 * One or more user names are valid. Seperate the names with "," only.
 * Example 1: define ( "HTP_NO_DEL_USER", "admin" );
 * Example 2: define ( "HTP_NO_DEL_USER", "admin,jim,bob" );
 */
define ( "HTP_NO_DEL_USER", "beheer" );
/*
 * Set a favicon. You should specify the whole URL.
 */
//define ( "HTP_FAVICON", "http://www.example.com/favicon.ico" );
//define ( "HTP_FAVICON", "http://htprotector.sourceforge.net/favicon.ico" );
define ( "HTP_FAVICON", $_SERVER['SCRIPT_NAME'].'?ico=i.png' ); // This is IN this script

/*
 * Simply provide a URL to your CSS file to brand htprotector.
 */
//define ( "HTP_STYLESHEET", "http://www.example.com/style.css" );
//define ( "HTP_STYLESHEET", "http://htprotector.sourceforge.net/style.css" );
define ( "HTP_STYLESHEET", $_SERVER['SCRIPT_NAME'].'?css=1' ); // This is IN this script
/*
 * HTP_HTML_INTRO and HTP_HTML_EXTRO override HTP_FAVICON and HTP_STYLESHEET.
 * Specify complete new HTML document. Only the user data fields will
 * be displayed as before, anything else could be inserted as you wish.
 * If this setting is ignored, then then htProtector was unable to read
 * your files -> check for permissions and correct path!
 * HINT: point HTP_HTML_INTRO and HTP_HTML_EXTRO to empty files, and include
 * htprotector itself into a existing script to use it seamless in your
 * own application.
 */
//define ( "HTP_HTML_INTRO", "header.html" );
//define ( "HTP_HTML_EXTRO", "footer.html" );
/*
 * Set the language on one language. Else, htprotector tries to read the
 * language setting of the browser. If this fails, HTP_LANG_BACKUP is used.
 * Example: define ( "HTP_LANG", "en" ); // english
 *          define ( "HTP_LANG", "de" ); // german
 *          define ( "HTP_LANG", "fr" ); // french
 */
//define ( "HTP_LANG", "en" );
define ( "HTP_LANG_BACKUP", "en" );
/*
 * Use HTP_PREDEFINED_PASSWORD if you don't want to use randomly generated
 * passwords. Change eg. $lang['en']['predefined_password'] and other
 * language strings to your needs.
 * Defaults:
 * en = ChangeMePlease
 * de = AendereMich
 * fr = ChangezMoi
 */
//define ( "HTP_PREDEFINED_PASSWORD", "yes" );
/*
 * Default generated password is HTP_PASSWORD_LENGTH long.
 */
define ( "HTP_PASSWORD_LENGTH", "8" );
/*
 * Keep the .htaccess and .htpasswd files, no matter if users
 * exists or not.
 */
//define ( "HTP_KEEP", "yes" );
/*
 * Check for new version. If you have a dial in internet connection
 * or DNS resolving issues, you may want to disable this.
 */
define ( "HTP_CHECK_VERSION", "yes" );
/*
 * Optional sender and reply to address of notification mails.
 * If not set, $_SERVER["SERVER_ADMIN"] is used.
 */
//define ( "HTP_ADMIN_EMAIL", "webmaster@example.com" );
/*
 * Path for .htaccess and .htpasswd files.
 * Default: location of this script.
 */
define ( "HT_PATH", dirname ( $_SERVER['SCRIPT_FILENAME'] ) );
/*
   Location and name of .htaccess file.
   Default: location of this script and file name ".htaccess"
*/ 
define ( "HTACCESS", HT_PATH.DIRECTORY_SEPARATOR.".htaccess" );
/*
   Location and name of .htpasswd file.
   Default: location of this script and file name ".htpasswd"
*/ 
define ( "HTPASSWD", HT_PATH.DIRECTORY_SEPARATOR.".htpasswd" );

/*
 * If you need to add networks or other special things, this is
 * what you looking for. Don't change it, if you're not 100% sure
 * which effects this could cause.
 */
define ( "HTACCESS_CONTENT", "AuthName \"HTTITLE\"\nAuthType Basic\nAuthUserFile ".HTPASSWD."\nRequire valid-user\n" );


/*
 * Language settings
 *
 * If you translated those texts into your language or corrected
 * any typos, then send this to me and/ or open a request:
 * https://sourceforge.net/tracker/?group_id=112890&atid=683439
 *
 * Thanks!
 *
 */
$lang = array('en','de','fr');
$lang['en']['title'] = "Protected Area";
$lang['en']['predefined_password'] = "ChangeMe";
$lang['en']['html_title'] = "Access List Administration";
$lang['en']['html_username'] = "Username";
$lang['en']['html_password'] = "Password";
$lang['en']['html_password_repeat'] = "repeat";
$lang['en']['html_email'] = "EMail";
$lang['en']['html_submit_admin'] = "Create User/ Reset Password";
$lang['en']['html_submit_user'] = "Reset Password";
$lang['en']['html_userlist'] = "Userlist";
$lang['en']['html_delete'] = "delete user";
$lang['en']['html_is_admin'] = "Administrator";
$lang['en']['html_version_warning'] = "A newer version of HTprotector is available. <a href=\"http://sourceforge.net/projects/htprotector/\">Please update your script</a>";
$lang['en']['html_password_not_equal'] = "Given password are not equal. No changes are saved.";
$lang['en']['email_subject'] = "Password for ".$lang['en']['title'];
$lang['en']['email_intro'] =
	"Hello!\n\nHere are your authentication details for the page "
	."http://".$_SERVER['SERVER_NAME'].substr
	(
		$_SERVER['PHP_SELF'],
		0,
		strlen ( $_SERVER['PHP_SELF'] ) - strlen ( basename( $_SERVER['PHP_SELF'] ) )
	)
	." : \n\n";
$lang['en']['email_extro'] = "\n\n--\n\nAutomated mail send by htprotector 1.4 by Manuel Hoppe\nVisit http://sourceforge.net/projects/htprotector/ for more information.\n\n"
;
$lang['en']['html_deny'] = 
	"<p>Please enter the valid login ID and password to access the\n"
	."Protector access manager.</p>\n"
	."<p>If you are the webmaster of this site and don't know why\n"
	."you get this error message, edit the file\n"
	."\"".$_SERVER['PHP_SELF']."\" and <b>carefully</b> read the comment above\n"
	."the HTP_ADMIN define.</p>\n";
$lang['en']['html_error_write_file'] = 'ERROR: unable to write file (file permissions?)';
$lang['en']['html_footer_by'] = 'by';
$lang['en']['html_footer_before_link'] = 'Visit';
$lang['en']['html_footer_after_link'] = 'for more informations and updates.';

$lang['de']['title'] = "Gesch&uuml;tzter Bereich";
$lang['de']['predefined_password'] = "AendereMich";
$lang['de']['html_title'] = "Zugriffsverwaltung";
$lang['de']['html_username'] = "Benutzername";
$lang['de']['html_password'] = "Passwort";
$lang['de']['html_password_repeat'] = "Wiederholung";
$lang['de']['html_email'] = "EMail";
$lang['de']['html_submit_admin'] = "Benutzer anlegen/ Passwort neu setzen";
$lang['de']['html_submit_user'] = "Passwort neu setzen";
$lang['de']['html_userlist'] = "Benutzerliste";
$lang['de']['html_delete'] = "Benutzer l&ouml;schen";
$lang['de']['html_is_admin'] = "Verwalter";
$lang['de']['html_version_warning'] = "Eine neue Version des HTprotector ist verf&uuml;gbar. <a href=\"http://sourceforge.net/projects/htprotector/\">Bitte aktualisieren Sie dieses Skript.</a>";
$lang['de']['html_password_not_equal'] = "Die angegebenen Passworte waren nicht gleich. Es wurden keine &Auml;nderungen durchgef&uuml;hrt.";
$lang['de']['email_subject'] = "Passwort f&uuml;r ".$lang['de']['title'];
$lang['de']['email_intro'] =
	"Sehr geehrte Damen und Herren,\n\nhiermit erhalten Sie die Zugangsdaten für die Seite "
	."http://".$_SERVER['SERVER_NAME'].substr
	(
		$_SERVER['PHP_SELF'],
		0,
		strlen ( $_SERVER['PHP_SELF'] ) - strlen ( basename( $_SERVER['PHP_SELF'] ) )
	)
	." : \n\n";
$lang['de']['email_extro'] = "\n\n--\n\nAutomatisierte Mail gesendet von htprotector 1.4 (Autor: Manuel Hoppe)\nN&auml;here Informationen unter http://sourceforge.net/projects/htprotector/.\n\n"
;
$lang['de']['html_deny'] = 
	"<p>Bitte geben Sie einen g&uml;ltige Benutzername und Passwort für den geschützen Bereich.</p>\n"
	."<p>Wenn Sie der Verwalter dieser Seite sind und nicht wissen warum diese Meldung kommt, dann\n"
	."schauen Sie bitte in die Datei\n"
	."\"".$_SERVER['PHP_SELF']."\" und lesen aufmerksam den Kommentar über der HTP_ADMIN Definition.</p>\n";
$lang['de']['html_error_write_file'] = 'FEHLER: Kann Datei nicht schreiben (Dateirechte?)';
$lang['de']['html_footer_by'] = 'von';
$lang['de']['html_footer_before_link'] = 'Unter';
$lang['de']['html_footer_after_link'] = 'gibt es mehr Informationen und Aktualisierungen.';

// Thanks to Gerard Bronner
$lang['fr']['title'] = "Espace partenaires";
$lang['fr']['predefined_password'] = "ChangezMoi";
$lang['fr']['html_title'] = "Administration des acc&egrave;s";
$lang['fr']['html_username'] = "Identifiant ";
$lang['fr']['html_password'] = "Mot de passe ";
$lang['fr']['html_password_repeat'] = "r&eacute;p&eacute;tition";
$lang['fr']['html_email'] = "Courriel ";
$lang['fr']['html_submit_admin'] = "Cr&eacute;er l'identifiant/Changer le mot de passe";
$lang['fr']['html_submit_user'] = "Changer le mot de passe";
$lang['fr']['html_userlist'] = "Liste des identifiants";
$lang['fr']['html_delete'] = "Supprimer";
$lang['fr']['html_is_admin'] = "Administrateur";
$lang['fr']['html_version_warning'] = "Une version plus r&eacute;cente de HTprotector est disponible. <a href=\"http://sourceforge.net/projects/htprotector/\">T&eacute;l&eacute;chargement (en anglais).</a>";
$lang['fr']['html_password_not_equal'] = "Given password are not equal. No changes are saved.";
$lang['fr']['email_subject'] = "Votre mot de passe : ".$lang['fr']['title'];
$lang['fr']['email_intro'] =
	"Bonjour\n\nVoici les informations indispensables pour vous rendre sur la page "
	."http://".$_SERVER['SERVER_NAME'].substr
	(
		$_SERVER['PHP_SELF'],
		0,
		strlen ( $_SERVER['PHP_SELF'] ) - strlen ( basename( $_SERVER['PHP_SELF'] ) )
	)
	." : \n\n";
$lang['fr']['email_extro'] = "\n\n--\n\nCourriel automatique transmis par HTprotector 1.4\nAuteur : Manuel Hoppe\nRendez vous sur http://sourceforge.net/projects/htprotector/ pour plus d'informations.\n\n"
;
$lang['fr']['html_deny'] = 
	"<p>Veuillez entrer un identifiant et un mot de passe corrects\n"
	."pour acc&eacute;der &agrave; cette page.</p>\n"
	."<p>Si vous &ecirc;tes le webmaster de ce site et que vous ignorez\n"
	."pourquoi vous obtenez ce message, &eacute;ditez le fichier\n"
	."\"".$_SERVER['PHP_SELF']."\" et lisez les instructions qui se\n"
	."trouvent au dessus de la d&eacute;finition de HTP_ADMIN.</p>\n";
$lang['fr']['html_error_write_file'] = 'ERROR: unable to write file (file permissions?)';
$lang['fr']['html_footer_by'] = 'by';
$lang['fr']['html_footer_before_link'] = 'Visit';
$lang['fr']['html_footer_after_link'] = 'for more informations and updates.';


/*
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 *
 *
 *
 *              NO CHANGES NEEDED BEYOND THIS POINT!
 *
 *
 *
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 */

if ( isset($_REQUEST['ico']) ) {
	header('Content-Type: image/png');
	echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAAXNSR0IArs4c6QAAAAZiS0dEAP8A/wD/oL2nkwAAAk1JREFUOMt9k09I02EYxz+/bWDOk5rDITpFInbZLosJwhpIF2OHthlis4OReJj4j0266M9bhwRBytAKTDqoUIcJCTEbRW6NUQ1qdhBEkloiKohoIXs6zCkr1xeew/O8L5/nfb4vDxxrfn7e7nK5PuVyVVUJhUKWArWPnKHBaDSaMRqNMWAYCLrdHonF3ubVPB6P9Pb2Sg6oA3C73V9rakwXNzaq8DxbsfMoZKesmEzmN62ty4rHM24H7ADb23t4vdWyuroqZWVlTlRVJR6PW/z+W1JbuyuQEWbSAoMC6hkxJAsLX6S8vDyW936j0Rjt7NzOAv4LuSM+n1fC4bAdQJMD1NfXLzocjwElG+0GmOkDDvIa+f1Wtrb2aWpqep8H8Hq9RF7GoDFXKQTRsbu7c5KdAPR6PYcaDRyMg+P/kEwm8+8fVlRUROfmlgWGBMcDwSECuTj1xGwelba267K0tGTPA3R03BSzefTUrIKQgMzOvhMgqKoqWlVVOTo6Gm5puXp5cvKnAtoscX0fTCtgugTrx+O8KIEZK5ULHzhffXhlampqRBuJRLBarZG1NYuSSu3lz1UAEr+xyYitSr6l08UagKKiomRz8y+pqysB/jLozSYwkTVWEUBhzljNxPS0EggEnmsBUqnUQ53u3DWT6Ufl2FgPev0BicR3suMosL7DBVearkYLXd335MnT+0p/f58lmUzmL9Wxs0Gfr126u2/L4uJnCQZfSSIRyQwM9IjBYIg6nc67uUU6U7mDcDhsLy0tfW2z2aShoaHAbfgD+CMj16ttJqoAAAAASUVORK5CYII=');
	die();
}

if ( isset($_REQUEST['css']) ) {
	header('Content-Type: text/css');
	echo '
/* Common/ Allgemeines */
body
{
  font-family : arial, sans-serif;
  font-size:    12px;
  color:        #000000;
  align:        left;
  text-align:   left;
}

p     { font-family : arial, sans-serif; font-size: 12px }
br    { font-family : arial, sans-serif; font-size: 12px }
table { font-family : arial, sans-serif; font-size: 12px }
td    { font-family : arial, sans-serif; font-size: 12px }
tr    { font-family : arial, sans-serif; font-size: 12px }
form  { font-family : arial, sans-serif; font-size: 12px }
input { font-family : arial, sans-serif; font-size: 12px }

/* Links */
a:link    { color: #000000; font-weight:bold; text-decoration:none }
a:visited { color: #000000; font-weight:bold; text-decoration:none }
a:active  { color: #000000; font-weight:bold; text-decoration:none }
a:hover   { color: #000000; background-color: #ffe3e3 }
a:focus   { color: #000000; font-weight:bold; text-decoration:none }

/* Required fields/ Erforderlichen Felder */
input.required { background-color:#ffe3e3; font-weight:bold }
div.required   { font-weight:bold }

/* Version warning/ Versionshinweis */
div.warning    { font:italic; font-weight:bold }
';
	die();
}

$authenticated_user = '';
if ( isset($_SERVER['PHP_AUTH_USER']) ) {
	if ( strlen($_SERVER['PHP_AUTH_USER'])>0 ) {
		$authenticated_user = $_SERVER['PHP_AUTH_USER'];
	}
}
if ( strlen($authenticated_user)==0 && isset($_SERVER['REMOTE_USER']) ) {
	if ( strlen($_SERVER['REMOTE_USER'])>0 ) {
		$authenticated_user = $_SERVER['REMOTE_USER'];
	}
}

//if ( !defined ( 'HTP_LANG' ) && strlen ( $lang[HTP_LANG]['html_title'] ) == 0 )
if ( !defined ( 'HTP_LANG' ) )
{
	$browser_lang = explode ( ";", $_SERVER["HTTP_ACCEPT_LANGUAGE"] );
	$lang_setting = 0;
	for
	(
		$i = 0;
		$i < count ( $browser_lang ) && !$lang_setting;
		$i++
	)
	{
		unset ( $browser_lang_sub );
		$browser_lang_sub = explode ( ",", $browser_lang[$i] );
		for
		(
			$j = 0;
			$j < count ( $browser_lang_sub ) && !$lang_setting;
			$j++
		)
		{
			// oppertunistic search, should work in all cases
			$browser_lang_sub_str =
				substr ( $browser_lang_sub[$j], 0, 2 );
			if
			(
				strlen
				(
					$lang[$browser_lang_sub_str]['html_title']
				)
				> 0
			)
			{
				$lang_setting = $browser_lang_sub_str;
			}
		}
	}
	if ( !$lang_setting )
	{
		$use_lang_backup = TRUE;
	}
	else
	{
		define ( "HTP_LANG", $lang_setting );
	}
}
else
{
	$use_lang_backup = TRUE;
}

if ( isset($use_lang_backup) && !defined("HTP_LANG") )
{
	if ( strlen ( $lang[HTP_LANG_BACKUP]['html_title'] ) == 0 )
	{
		// This is the very last backup language setting...
		define ( "HTP_LANG", "en" );
	}
	else
	{
		define ( "HTP_LANG", HTP_LANG_BACKUP );
	}
}

// hack, to fix a already defined string...
define
(
	"HTACCESS_CONTENT_WORKAROUND",
	str_replace
	(
		"HTTITLE",
		html_entity_decode ( $lang[HTP_LANG]['title'] ),
		HTACCESS_CONTENT
	)
);
define ( "HTTITLE", $lang[HTP_LANG]['title'] );
define ( "HTML_TITLE", $lang[HTP_LANG]['html_title'] );
define ( "HTML_USERNAME", $lang[HTP_LANG]['html_username'] );
define ( "HTML_PASSWORD", $lang[HTP_LANG]['html_password'] );
define ( "HTML_PASSWORD_REPEAT", $lang[HTP_LANG]['html_password_repeat'] );
define ( "HTML_EMAIL", $lang[HTP_LANG]['html_email'] );
define ( "HTML_SUBMIT_ADMIN", $lang[HTP_LANG]['html_submit_admin'] );
define ( "HTML_SUBMIT_USER", $lang[HTP_LANG]['html_submit_user'] );
define ( "HTML_USERLIST", $lang[HTP_LANG]['html_userlist'] );
define ( "HTML_DELETE", $lang[HTP_LANG]['html_delete'] );
define ( "HTML_IS_ADMIN", $lang[HTP_LANG]['html_is_admin'] );
define ( "EMAIL_SUBJECT", $lang[HTP_LANG]['email_subject'] );
define ( "EMAIL_INTRO",	$lang[HTP_LANG]['email_intro'] );
define ( "EMAIL_EXTRO", $lang[HTP_LANG]['email_extro'] );
define ( "HTDENY", $lang[HTP_LANG]['html_deny'] );

define ( "HTP_VERSION", "1.5" );

// if default password length is invalid, make it valid.
if ( (int) HTP_PASSWORD_LENGTH == 0 )
{
	define ( "HTP_PASSWORD_LENGTH", "8" );
}

function generate_password ( $length = 8 )
{
        $valid_pool = "abcdefghkmnpqrstuvwxyzABCDEFGHKLMNPQRSTUVWXYZ123456789";
	$password='';
        mt_srand( ( double ) microtime () * 1000000 );
        for ( $i = 0; $i < $length; $i++ )
        {
                $value = mt_rand ( 0, ( strlen ( $valid_pool ) - 1 ) );
                $password = $password.$valid_pool[$value];
        }
        return $password;
}

function get_userlist ()
{
	if ( is_readable ( HTPASSWD ) )
	{
		$userlist = array();
		$handle = fopen ( HTPASSWD, "r" );
		$buffer = '';
		while ( !feof ( $handle ) )
		{
			$buffer = $buffer.fgets( $handle, 8 );
		}
		$tmp = explode ( "\n", $buffer );
		for ( $i = 0; $i < count ( $tmp ); $i++ )
		{
			$exploded = explode ( ":", $tmp[$i] );
			if ( strlen ( $exploded[0] ) > 0 && strlen ( $exploded[1] ) > 0 )
			{
				$userlist[$i]["name"] = $exploded[0];
				$userlist[$i]["crypted"] = $exploded[1];
			}
		}
		fclose ( $handle );
		return $userlist;
	}
	else
	{
		return FALSE;
	}
}

function rewrite_htpasswd ( $userlist )
{
	if ( count ( $userlist ) == 0 && strlen ( HTP_KEEP ) > 0 )
	{
		if ( is_file(HTACCESS) ) {
			unlink ( HTACCESS );
		}
		if ( is_file(HTPASSWD) ) {
			unlink ( HTPASSWD );
		}
	}
	else
	{
		$handle = fopen ( HTPASSWD, "w+" );
		if ( !$handle ) {
			echo $GLOBALS['lang'][HTP_LANG]['html_error_write_file'].' -> '.HTPASSWD."\n";
			die();
		}
		for ( $i = 0; $i < count ( $userlist ); $i++ )
		{
			fwrite ( $handle, $userlist[$i]["name"].":".$userlist[$i]["crypted"]."\n" );
		}
		fclose ( $handle );
	}
}

function is_in_userlist ( $username, $userlist )
{
	$result = FALSE;
	if ( strlen ( $userlist ) > 0 && strlen ( $username ) > 0 )
	{
		$userlist = explode ( ",", $userlist );
		for ( $i = 0; $i < count ( $userlist ) && !$result; $i++ )
		{
			if ( $username == trim ( $userlist[$i] ) )
			{
				$result = TRUE;
			}
		}
	}
	return $result;
}

function is_admin ()
{
	// initial setup...
	if ( !is_readable ( HTACCESS ) )
	{
		return TRUE;
	}
	if ( !defined ( "HTP_ADMIN" ) )
	{
		return TRUE;
	}
	if ( strlen(HTP_ADMIN)==0 ) {
		return TRUE;
	}
	if
	(
		defined ( "HTP_ADMIN" )
		&& is_in_userlist ( $GLOBALS['authenticated_user'], HTP_ADMIN )
	)
	{
		return TRUE;
	}
	return FALSE;
}

if ( !is_admin () && defined ( "HTP_NO_USER_ACCESS" ) )
{
	Header( "WWW-Authenticate: Basic realm=\"".HTTITLE."\"");
	Header( "HTTP/1.0 401 Unauthorized");
	echo ( "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n" );
	echo ( "<html>\n" );
	echo ( "<head>\n" );
	echo ( "<title>\n" );
	echo ( HTML_TITLE."\n" );
	echo ( "</title>\n" );
	if ( defined ( "HTP_FAVICON" ) )
	{
		echo ( "<link rel=\"shortcut icon\" href=\"".HTP_FAVICON."\" />\n" );
	}
	if ( defined ( "HTP_STYLESHEET" ) )
	{
		echo ( "<link rel=\"stylesheet\" href=\"".HTP_STYLESHEET."\" />\n" );
	}
	echo ( "</head>\n" );
	echo ( "<body>\n" );
	echo ( "<h1>\n" );
	echo ( HTML_TITLE."\n" );
	echo ( "</h1>\n" );
	echo ( HTDENY );
	die ();
}

$action = '';
$username = '';
$password = '';
$email = '';

if ( isset($_REQUEST['action']) ) {
	$action = $_REQUEST['action'];
}
if ( isset($_REQUEST['username']) ) {
	$username = $_REQUEST['username'];
}
if ( isset($_REQUEST['password']) ) {
	$password = $_REQUEST['password'];
}
if ( isset($_REQUEST['password2']) ) {
	$password2 = $_REQUEST['password2'];
}
if ( isset($_REQUEST['email']) ) {
	$email = $_REQUEST['email'];
}

/*
 * If user is not an admin, then don't let them change other user
 */
if
(
/*
	defined ( "HTP_ADMIN" )
	&& !is_in_userlist ( $_SERVER['PHP_AUTH_USER'], HTP_ADMIN )
	&& is_readable ( HTPASSWD )
*/
	!is_admin ()
)
{
	if ( isset($_SERVER['PHP_AUTH_USER']) || isset($_SERVER['REMOTE_USER']) ) {
		$username = $authenticated_user;
	}
}

/*
   If $action is "edit", create or edit a new authentication
*/
if ( $action == "edit" && $password == $password2 )
{
	if ( strlen ( $password ) == 0 )
	{
		if ( defined ( "HTP_PREDEFINED_PASSWORD" ) )
		{
			$password = $lang[HTP_LANG]['predefined_password'];
		}
		else
		{
			$password = generate_password ( HTP_PASSWORD_LENGTH );
		}
	}
	if ( is_readable ( HTPASSWD ) )
	{
		/*
		   Search for existing user
		*/
		$searchlist = get_userlist ();
		$edited = FALSE;
		for ( $i = 0; $i < count ( $searchlist ); $i++ )
		{
			if ( $searchlist[$i]["name"] == $username )
			{
				$edited = TRUE;
				$searchlist[$i]["crypted"] = crypt ( $password );
			}
		}
		/*
		   Create new user
		*/
		if ( !$edited )
		{
			$searchlist[$i]["name"] = $username;
			$searchlist[$i]["crypted"] = crypt ( $password );
		}
	}
	else
	{
		/*
		   Create new user in new file
		*/
		$searchlist[0]["name"] = $username;
		$searchlist[0]["crypted"] = crypt ( $password );
	}
	rewrite_htpasswd ( $searchlist );
	/*
	   Send notification if $email is set
	*/
	if ( strlen ( $email ) > 0 )
	{
		$message = EMAIL_INTRO
			.HTML_USERNAME.": ".$username."\n"
			.HTML_PASSWORD.": ".$password."\n"
			.EMAIL_EXTRO;
		unset ( $header );
		if ( defined ( "HTP_ADMIN_EMAIL" ) )
		{
			$adm_email = HTP_ADMIN_EMAIL;
		}
		else
		{
			$adm_email = $_SERVER["SERVER_ADMIN"];
		}
		$header = "From:".$adm_email."\r\n"
			."Reply-To: ".$adm_email."\r\n"
			."X-Mailer: htprotector ".HTP_VERSION."\r\n"
			."X-Remote-IP: ".$_SERVER["REMOTE_ADDR"]."\r\n"
			."X-Create-User: ".$authenticated_user;
		mail
		(
			$email,
			html_entity_decode ( EMAIL_SUBJECT ),
			html_entity_decode ( $message ),
			$header
		);
	}
}
if ( $action == "edit" && $password != $password2 )
{
	$error_password_not_equal = TRUE;
}

if
(
	$action == "delete"
	&& strlen ( $username ) > 0
	&& !is_in_userlist ( $username, HTP_NO_DEL_USER )
	&& strlen(HTP_NO_DEL_USER)>0
)
{
	$searchlist = get_userlist ();
	$j = 0;
	for ( $i = 0; $i < count ( $searchlist ); $i++ )
	{
		if ( $searchlist[$i]["name"] != $username )
		{
			$newlist[$j]["name"] = $searchlist[$i]["name"];
			$newlist[$j]["crypted"] = $searchlist[$i]["crypted"];
			$j++;
		}
	}
	rewrite_htpasswd ( $newlist );
}

$action = '';
$username = '';
$password = '';
$email = '';

/*
   If exists, open .htpasswd and read all usernames
*/
if ( is_readable ( HTPASSWD ) )
{
	if ( ! is_readable ( HTACCESS ) )
	{
		unset ( $tmp );
		$tmp = fopen ( HTACCESS, "a" );
		if ( !$tmp ) {
			echo $GLOBALS['lang'][HTP_LANG]['html_error_write_file'].' -> '.HTACCESS."\n";
			die();
		}
		fwrite ( $tmp, HTACCESS_CONTENT_WORKAROUND );
		unset ( $tmp );
	}
	$userlist = get_userlist ();
}

//if ( strlen ( $password ) == 0 && is_admin () )
if ( is_admin () )
{
	if ( defined ( "HTP_PREDEFINED_PASSWORD" ) )
	{
		$password = $lang[HTP_LANG]['predefined_password'];
	}
	else
	{
		$password = generate_password ( HTP_PASSWORD_LENGTH );
	}
}

if ( defined ( "HTP_HTML_INTRO" ) && is_readable ( HTP_HTML_INTRO ) )
{
	include ( HTP_HTML_INTRO );
}
else
{
	echo ( "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n" );
	echo ( "<html>\n" );
	echo ( "<head>\n" );
	echo ( "<title>\n" );
	echo ( HTML_TITLE."\n" );
	echo ( "</title>\n" );
	if ( defined ( "HTP_FAVICON" ) )
	{
		echo ( "<link rel=\"shortcut icon\" href=\"".HTP_FAVICON."\" />\n" );
	}
	if ( defined ( "HTP_STYLESHEET" ) )
	{
		echo ( "<link rel=\"stylesheet\" href=\"".HTP_STYLESHEET."\" />\n" );
	}
	echo ( "</head>\n" );
	echo ( "<body>\n" );
	echo ( "<h1>\n" );
	echo ( HTML_TITLE."\n" );
	echo ( "</h1>\n" );
}
if ( HTP_CHECK_VERSION == "yes" && is_admin () )
{
	$recent_version = trim
	(
		@file_get_contents
		(
			"http://htprotector.sourceforge.net/stable-version.txt"
		)
	);
	if ( $recent_version != HTP_VERSION && $recent_version != "" )
	{
		echo ( "<p>\n" );
		echo ( "<ul>\n" );
		echo ( "<div class=\"warning\">\n" );
		echo ( $lang[HTP_LANG]['html_version_warning']."\n" );
		echo ( "</div>\n" );
		echo ( "</ul>\n" );
		echo ( "</p>\n" );
	}
}
if ( isset($error_password_not_equal) )
{
	echo ( "<p>\n" );
	echo ( "<hr size=\"1\">\n" );
	echo ( $lang[HTP_LANG]['html_password_not_equal']."\n" );
	echo ( "<hr size=\"1\">\n" );
	echo ( "</p>\n" );
}
echo ( "<p>\n" );
echo ( "<form method=\"post\">\n" );
echo ( "<input name=\"action\" type=\"hidden\" value=\"edit\" />\n" );
echo ( "<table>\n" );
echo ( "<tr>\n" );
echo ( "<td><div class=\"required\">".HTML_USERNAME.":</div></td>\n" );
echo ( "<td>" );
if ( is_admin () )
{
	echo ( "<input class=\"required\" name=\"username\" type=\"text\" size=\"16\" maxlength=\"16\" />" );
}
else
{
	echo ( $authenticated_user."<input name=\"username\" type=\"hidden\" value=\"".$authenticated_user."\" />" );
}
echo ( "</td>\n" );
echo ( "</tr>\n" );
echo ( "<tr>\n" );
echo ( "<td><div class=\"required\">".HTML_PASSWORD.":</div></td>\n" );
echo ( "<td><input class=\"required\" name=\"password\" type=\"password\" size=\"16\" maxlength=\"16\" value=\"".$password."\" /></td>\n" );
echo ( "</tr>\n" );
echo ( "<tr>\n" );
echo ( "<td><div class=\"required\">".HTML_PASSWORD.":</div></td>\n" );
echo ( "<td><input class=\"required\" name=\"password2\" type=\"password\" size=\"16\" maxlength=\"16\" value=\"".$password."\" /> (".HTML_PASSWORD_REPEAT.")</td>\n" );
echo ( "</tr>\n" );
if ( is_admin () )
{
	echo ( "<tr>\n" );
	echo ( "<td>".HTML_EMAIL.":</td>\n" );
	echo ( "<td><input name=\"email\" type=\"text\" size=\"32\" maxlength=\"32\" /></td>\n" );
	echo ( "</tr>\n" );
}
echo ( "</table>") ;
echo ( "<input type=\"submit\" value=\" " );
if ( is_admin () )
{
	echo HTML_SUBMIT_ADMIN;
}
else
{
	echo HTML_SUBMIT_USER;
}
echo ( " &gt;&gt; \">\n" );
echo ( "</form>\n" );
echo ( "</p>\n" );
if ( is_admin () )
{
	echo ( "<br />\n" );
	echo ( "<p>\n" );
	echo ( HTML_USERLIST.":<br />\n" );
	echo ( "<ul>\n" );
	if ( !isset($userlist) ) {
		$userlist = FALSE;
	}
	if ( $userlist && count ( $userlist ) > 0 ) {
		for ( $i = 0; $i < count ( $userlist ); $i++ )
		{
			echo ( "<li>\n" );
			echo ( $userlist[$i]["name"] );
			if ( !is_in_userlist ( $userlist[$i]["name"], HTP_NO_DEL_USER ) )
			{
				echo ( " (<a href=\"".$_SERVER['SCRIPT_NAME']."?action=delete&username=".$userlist[$i]["name"]."\">".HTML_DELETE."</a>)" );
			}
			if ( is_in_userlist ( $userlist[$i]["name"], HTP_ADMIN ) && strlen(HTP_ADMIN)>0 )
			{
				echo ( " (".HTML_IS_ADMIN.")" );
			}
			echo ( "\n" );
			echo ( "</li>\n" );
		}
	} else {
		echo ( "<li>\n" );
		echo ( "-\n" );
		echo ( "</li>\n" );
	}
	echo ( "</ul>\n" );
	echo ( "</p>\n" );
}
if ( defined ( "HTP_HTML_EXTRO" ) && is_readable ( HTP_HTML_EXTRO ) )
{
	include ( HTP_HTML_EXTRO );
}
else
{
	echo ( "<p>\n" );
	echo ( "<div align=\"right\">\n" );
	echo ( "<small>" );
	echo ( "htprotector ".HTP_VERSION." ".$lang[HTP_LANG]['html_footer_by']." <a href=\"mailto:m.hoppe@hyperspeed.de\">Manuel Hoppe</a><br />" );
	echo ( $lang[HTP_LANG]['html_footer_before_link']." <a href=\"http://sourceforge.net/projects/htprotector/\">http://sourceforge.net/projects/htprotector/</a> ".$lang[HTP_LANG]['html_footer_after_link']."<br />" );
	echo ( "</small>" );
	echo ( "</div>\n" );
	echo ( "</p>\n" );
	echo ( "</body>\n" );
	echo ( "</html>\n" );
}

