<?php
/**
 * multiGuestbook - Config File
 * @author m[dot]lorch[at]it-kult[dot]de Markus Lorch
 * @package redaxo4
 * @version 0.9
 */

//REDAXO CONFIG
$mypage = "multiguestbook";
$REX['ADDON']['page'][$mypage] = $mypage;
$REX['ADDON']['name'][$mypage] = 'multiGuestbook';
$REX['ADDON']['rxid'][$mypage] = '761';
$REX['ADDON']['version'][$mypage] = '0.9.2';
$REX['ADDON']['author'][$mypage] = 'Markus Lorch / it.kult';
$REX['ADDON']['supportpage'][$mypage] = 'www.it-kult.de';

$REX['ADDON']['dir'][$mypage] = dirname(__FILE__);

require $REX['ADDON']['dir'][$mypage].'/classes/class.mGB.inc.php';
require $REX['ADDON']['dir'][$mypage].'/classes/class.mGB_Book.inc.php';
require $REX['ADDON']['dir'][$mypage].'/classes/class.mGB_Entry.inc.php';

require $REX['ADDON']['dir'][$mypage].'/functions/function.mGB_Form.inc.php';


// INCLUDE IN BACKEND
if ($REX['REDAXO'])
{
$REX['ADDON'][$mypage]['SUBPAGES'] = array(array('&bid='.rex_request('bid','int').'', 'Eintr&auml;ge verwalten'), array('manage_gbooks', 'G&auml;steb&uuml;cher verwalten'));
}
?>
