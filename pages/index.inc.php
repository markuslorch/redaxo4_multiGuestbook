<?php
/**
 * multiGuestbook - index.inc.php
 * @author m[dot]lorch[at]it-kult[dot]de Markus Lorch
 * @package redaxo4
 * @version v2010-1.B
 */
 
// Parameter
$Basedir = dirname(__FILE__);

$page = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$func = rex_request('func', 'string');

$mBG_bid = rex_request('bid', 'int');
$mBG_eid = rex_request('eid', 'int');

// Include Header and Navigation
include $REX['INCLUDE_PATH'].'/layout/top.php';

rex_title('multiGuestebook AddOn', $REX['ADDON'][$page]['SUBPAGES']);

// Include Current Page
switch($subpage)
{
    case 'documentation':
        require $Basedir .'/documentation.inc.php';
    break;
    case 'entrie':
        require $Basedir .'/entrie.inc.php';
    break;
    case 'manage_gbooks':
        require $Basedir .'/manage_gbooks.inc.php';
    break;
    default:
        require $Basedir .'/manage_entries.inc.php';
}

// Include Footer 
include $REX['INCLUDE_PATH'].'/layout/bottom.php';
?>
