<?php
/**
 * multiGuestbook - manage_entries.inc.php
 * @author m[dot]lorch[at]it-kult[dot]de Markus Lorch
 * @package redaxo4
 * @version v2010-1.B
 */

$sql = new rex_sql;

//Erste Ausgabe starten
$out = '<div class="rex-addon-output-v2">';

$sql->setQuery('SELECT bid FROM `'.$REX['TABLE_PREFIX'].'761_mGB_Books` ORDER BY name LIMIT 1');
if($sql->getRows() > 0)
{
  if(empty($mBG_bid))
    $mBG_bid = $sql->getValue('bid');

  $out .= '<table class="rex-table" style="margin-bottom:10px;"><caption>Folgendes G&auml;stebuch verwalten:</caption><colgroup><col width="*"></colgroup><thead><tr><th><form action="index.php" method="GET"><fieldset>';
  $out .= '<input type="hidden" name="page" value="multiguestbook" />Eintr&auml;ge aus:&nbsp;'.mGB_buildGBDropDown('bid', $mBG_bid, 'onchange="this.form.submit();" style="width:250px;"').'<noscript><input type="submit" value="Verwalten" /></noscript>';
  $out .= '</fieldset></form></th></tr></thead></table>';
}

if($func == 'update')
{
  if(rex_request('action','int') == 1)
  {
    $sql->setTable($REX['TABLE_PREFIX'].'761_mGB_Entries');
    $sql->setValue('entry_name', rex_post('entry_name', 'string'));
    $sql->setValue('entry_email', rex_post('entry_email', 'string'));
    $sql->setValue('entry_city', rex_post('entry_city', 'string'));
    $sql->setValue('entry_website', rex_post('entry_website', 'string'));
    $sql->setValue('entry_message', rex_post('entry_message', 'string'));
    $sql->setValue('entry_reply', rex_post('entry_reply', 'string'));
    
    $sql->setValue('clang', rex_post('entry_clang', 'int'));
    $sql->setValue('updatedate', time());
    $sql->setValue('updateuser', '');
  
    $sql->setWhere('eid='.$mBG_eid);
    $sql->update();

    echo rex_info("Die &Auml;nderungen wurden &uuml;bernommen.");  
  }
  
  $sql->setQuery('SELECT * FROM `'.$REX['TABLE_PREFIX'].'761_mGB_Entries` WHERE (eid='.$mBG_eid.') LIMIT 1');
  
  $out .= '<div class="rex-form" style="margin-bottom:10px;"><form action="index.php?page=multiguestbook&subpage=&func=update&action=1&eid='.$mBG_eid.'&bid='.$mBG_bid.'" method="post" enctype="multipart/form-data" id="REX_FORM">';
  $out .= '<fieldset class="rex-form-col-a"><legend><span>Einstellungen:</span></legend><div class="rex-form-wrapper">';
  $out .= '<div class="rex-form-row"><p class="rex-form-text"><label for="entry_createdate">Datum:</label><input class="rex-form-text" type="text" name="entry_clang" value="'.date("Y-m-d H:i", $sql->getValue('createdate')).'" disabled="disabled"/></p></div>';
  $out .= '<div class="rex-form-row"><p class="rex-form-text"><label for="entry_clang">Sprache:</label><input class="rex-form-text" type="text" name="entry_clang" value="'.$sql->getValue('clang').'" /></p></div>';
  $out .= '<div class="rex-clearer"></div></div></fieldset>';

  $out .= '<fieldset class="rex-form-col-a"><legend><span>Bearbeiten:</span></legend><div class="rex-form-wrapper">';
  $out .= '<div class="rex-form-row"><p class="rex-form-text"><label for="entry_name">Name:</label><input class="rex-form-text" type="text" name="entry_name" value="'.$sql->getValue('entry_name').'" /></p></div>';
  $out .= '<div class="rex-form-row"><p class="rex-form-text"><label for="entry_email">eMail:</label><input class="rex-form-text" type="text" name="entry_email" value="'.$sql->getValue('entry_email').'" /></p></div>';
  $out .= '<div class="rex-form-row"><p class="rex-form-text"><label for="entry_city">Wohnort:</label><input class="rex-form-text" type="text" name="entry_city" value="'.$sql->getValue('entry_city').'" /></p></div>';
  $out .= '<div class="rex-form-row"><p class="rex-form-text"><label for="entry_website">Website:</label><input class="rex-form-text" type="text" name="entry_website" value="'.$sql->getValue('entry_website').'" /></p></div>';
  $out .= '<div class="rex-form-row"><p class="rex-form-text"><label for="entry_message">Nachricht:</label><textarea class="rex-form-textarea" cols="50" rows="6" name="entry_message">'.$sql->getValue('entry_message').'</textarea></p></div>';
  $out .= '<div class="rex-clearer"></div></div></fieldset>';
  
  $out .= '<fieldset class="rex-form-col-a"><legend><span>Antworten:</span></legend><div class="rex-form-wrapper">';
  $out .= '<div class="rex-form-row"><p class="rex-form-text"><label for="entry_website">Nachricht:</label><textarea class="rex-form-textarea" cols="50" rows="6" name="entry_reply">'.$sql->getValue('entry_reply').'</textarea></p></div>';
  $out .= '<div class="rex-form-row"><p class="rex-form-col-a rex-form-submit"><input class="rex-form-submit" type="submit" value="Alles speichern" accesskey="s" title="Alles speichern"/></p></div>';
  $out .= '<div class="rex-clearer"></div></div></fieldset>';
  $out .= '</form></div>';
}
else
{
  if($func == 'del' && !empty($mBG_eid))
  {
    $sql->setTable($REX['TABLE_PREFIX'].'761_mGB_Entries');
    $sql->setWhere('eid = '.$mBG_eid.'');  
    $sql->delete(); 
    
    echo rex_warning("Das G&auml;stebucheintrag wurde gel&ouml;scht!"); 
  }
  elseif($func == 'status' && !empty($mBG_eid))
  {
    $sql->setTable($REX['TABLE_PREFIX'].'761_mGB_Entries');
    $sql->setValue('offline', rex_get('value', 'int'));
    $sql->setWhere('eid = '.$mBG_eid.'');
    $sql->update();    
  }

  $out .= '<table class="rex-table" style="margin-bottom:10px;"><caption>Liste der Eintr&auml;ge</caption>';
  $out .= '<colgroup><col width="120"><col width="*"><col width="60"><col width="*"><col width="*"></colgroup>';
  $out .= '<thead><tr><th>Zeit</th><th>Eintrag</th><th>Sprache</th><th colspan="3">Status/Funktion</th></tr></thead>';
  $out .= '<tbody>';

  $gbook = new mGB_Book($mBG_bid, FALSE, TRUE, 'DESC');

  if($gbook->countEntries() > 0)
  {
    foreach($gbook->getEntries() as $entry)
    {
      $out .= '<tr>';
      $out .= '<td>'. date("Y-m-d H:i", $entry->getValue('createdate')) .'</td>';
      $out .= '<td><h2><b>'. $entry->getValue('entry_name') .'</b> schrieb:</h2><p>'. $entry->getValue('entry_message') .'</p></td>';
      $out .= '<td>'. $entry->getValue('clang') .'</td>';
      $out .= '<td><a href="index.php?page=multiguestbook&func=update&eid='.$entry->_id.'&bid='.$entry->getValue('bid').'">&auml;ndern</a></td>';
      $out .= '<td><a href="index.php?page=multiguestbook&func=del&eid='.$entry->_id.'&bid='.$entry->getValue('bid').'" onclick="return confirm(\'Achtung: Das G&auml;stebucheintrag wird dadurch unwiederbringlich gel&ouml;scht!\')">L&ouml;schen</a></td>';
      if($entry->getValue('offline') == 1)
        $out .= '<td><a href="index.php?page=multiguestbook&func=status&value=0&eid='.$entry->_id.'&bid='.$entry->getValue('bid').'" class="rex-offline">offline</a></td>';
      else
        $out .= '<td><a href="index.php?page=multiguestbook&func=status&value=1&eid='.$entry->_id.'&bid='.$entry->getValue('bid').'" class="rex-online">online</a></td>';
      $out .= '</tr>';
    }
  }
  else
  {
    $out .= '<tr><td colspan="4">Es wurden noch keine Eintr&auml;ge verfasst.</td></tr>';
  }

$out .= '</tbody></table>';
}


$out .= '</div>';

echo $out;
?>
