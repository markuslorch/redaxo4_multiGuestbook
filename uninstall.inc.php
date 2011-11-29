<?php

//Datenbank entfernen
$db = new rex_sql();
$db->setQuery('DROP TABLE `'.$REX['TABLE_PREFIX'].'761_mGB_Entries`');
$db->setQuery('DROP TABLE `'.$REX['TABLE_PREFIX'].'761_mGB_Books`');

if ($db->getError()) {
  $REX['ADDON']['installmsg']['multiguestbook'] = 'Failed to drop the database.<br>Mysql says:'.$db->getError();
}

$REX['ADDON']['install']['multiguestbook'] = 0;
?>
