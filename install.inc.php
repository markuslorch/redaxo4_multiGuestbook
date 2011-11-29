<?php
if(OOAddon::isAvailable('xform') == 1)
{
  // Create database
  $sql = new rex_sql();
  $sql->setQuery('CREATE TABLE IF NOT EXISTS `rex_761_mGB_Entries` (
  `eid` int(10) unsigned NOT NULL auto_increment,
  `bid` int(11) NOT NULL,
  `clang` int(11) NOT NULL,
  `createdate` int(11) NOT NULL,
  `updatedate` int(11) NOT NULL,
  `updateuser` varchar(255) NOT NULL,
  `createuser` varchar(255) NOT NULL,
  `offline` tinyint(1) NOT NULL,
  `entry_name` varchar(255) NOT NULL,
  `entry_email` varchar(255) NOT NULL,
  `entry_website` varchar(255) NOT NULL,
  `entry_city` varchar(255) NOT NULL,
  `entry_message` text NOT NULL,
  `entry_reply` text NOT NULL,
  PRIMARY KEY  (`eid`)
) ENGINE=MyISAM;');

  $sql->setQuery('CREATE TABLE IF NOT EXISTS `rex_761_mGB_Books` (
  `bid` int(10) NOT NULL auto_increment,
  `createdate` int(11) default NULL,
  `createuser` varchar(255) NOT NULL,
  `updatedate` int(11) default NULL,
  `updateuser` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`bid`)
) ENGINE=MyISAM;');

  if ($sql->getError()) {
    $REX['ADDON']['installmsg']['multiguestbook'] = 'Failed to create the database.<br>Mysql says:'.$sql->getError();
    exit;
  }
  
$sql->setTable('rex_module');
$sql->setValue('eingabe', addslashes('<h2>Eintrag in folgendes G&auml;stebuch:</h2><?php echo mGB_buildGBDropDown(\'VALUE[1]\', "REX_VALUE[1]", \'style="width:250px;"\'); ?><h2>Formularfelder (xForm)</h2><textarea name="VALUE[2]" style="width:400px; height:300px;">REX_VALUE[2]</textarea>'));
$sql->setValue('ausgabe',addslashes('<?php
  $form_data = "\n"."ip|createuser";
  $form_data .= "\n"."timestamp|createdate";
  $form_data .= "\n"."hidden|bid|REX_VALUE[1]";
  $form_data .= "\n";
  
  $form_data .= trim(str_replace("<br />","",rex_xform::unhtmlentities(\'REX_VALUE[2]\')));
  
  $xform = new rex_xform;
	$xform->setObjectparams("main_table",$REX[\'TABLE_PREFIX\']."761_mGB_Entries");
  $xform->objparams["actions"][] = array("type" => "db","elements" => array("action","db",$REX[\'TABLE_PREFIX\']."761_mGB_Entries"),);
  
  $xform->setFormData($form_data);
  $xform->setRedaxoVars(REX_ARTICLE_ID,REX_CLANG_ID); 
	echo $xform->getForm();
  ?>'));
$sql->setValue('name',addslashes('multiGuestbook - Formular'));
$sql->addGlobalCreateFields();

if (!$sql->insert() )
{
  $REX['ADDON']['installmsg']['multiguestbook'] = 'Fehler beim schreiben in Datenbank / Error while writing in Database';
}  
}
else
{
$REX['ADDON']['installmsg']['multiguestbook'] = 'Bitte installieren Sie zuerst das xForm AddOn / Pleas install xForm AddOn first.';
}
$REX['ADDON']['install']['multiguestbook'] = 1;
?>