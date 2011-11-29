<?php
/**
 * multiGuestbook - manage_gbooks.inc.php
 * @author m[dot]lorch[at]it-kult[dot]de Markus Lorch
 * @package redaxo4
 * @version v2010-1.B
 */

//Mit Post &uuml;bergebene Daten lesen
$gbook_name = rex_post('gbook_name','string');

//F&uuml;r alle Operationen notwendige SQL Einstellungen
$sql = new rex_sql; 
$sql->setTable($REX['TABLE_PREFIX'].'761_mGB_Books');
$sql->setValue('name', $gbook_name);


if ($func == 'update' && $gbook_name != '')
{
  //Update der Einstellungen
  $sql->setValue('updatedate', time());
  $sql->setValue('updateuser', '');

  $sql->setWhere('bid='.$mBG_bid);
  $sql->update();
  $sql->getError();

  echo rex_info("Die &Auml;nderungen wurden &uuml;bernommen.");
}
elseif ($func == 'add' && $gbook_name != '')
{
  //Datensatz neu erstellen
  $sql->setValue('createdate', time());
  $sql->setValue('createuser', '');
  $sql->insert();
  
  echo rex_info("Es wurde eine neues G&auml;stebuch erstellt.");
  
  $func = 'update';
}
elseif ($func == 'del')
{
  //G&auml;stebuch l&ouml;schen
  $sql->setWhere('bid = '.$mBG_bid.'');  
  $sql->delete();
  
  $sql->setTable($REX['TABLE_PREFIX'].'761_mGB_Entries');
  $sql->setWhere('bid = '.$mBG_bid.'');  
  $sql->delete();
  echo rex_warning("Das G&auml;stebuch wurde gel&ouml;scht!");
  
  $mBG_bid = '';  
}

?>

<div class="rex-addon-output-v2">

<?php
$sql->setQuery('SELECT bid FROM `'.$REX['TABLE_PREFIX'].'761_mGB_Books` ORDER BY name LIMIT 1');

if($sql->getRows() > 0 && $func != 'add')
{
  if(empty($mBG_bid))
    $mBG_bid = $sql->getValue('bid');

   //Formulardaten aus Datenbank auslesen, sofern vorhanden
   $gbook = $sql->getArray('SELECT * FROM `'.$REX['TABLE_PREFIX'].'761_mGB_Books` WHERE (bid='.$mBG_bid.') LIMIT 1');
   $gbook_name = $gbook['0']['name'];
?>

<table class="rex-table" style="margin-bottom:10px;">
    <caption>Folgendes G&auml;stebuch verwalten:</caption>
    <colgroup>
      <col width="*">
    </colgroup>
    <thead>
      <tr>
        <th>
          <form action="index.php" method="GET">
            <fieldset>
              <input type="hidden" name="page" value="multiguestbook" />
              <input type="hidden" name="subpage" value="manage_gbooks" />
                G&auml;stebuch w&auml;hlen:&nbsp;<?php echo mGB_buildGBDropDown('bid', $mBG_bid, 'onchange="this.form.submit();" style="width:250px;"'); ?>
              <noscript><input type="submit" value="Verwalten" /></noscript>
            </fieldset>
          </form>        
        </th>
      </tr>
    </thead>
</table>

<?php
}

if(!empty($mBG_bid))
  $func = 'update';

if($func == 'update')
{
?>

<div class="rex-form" style="margin-bottom:10px;">
<form action="<?php echo 'index.php?page=multiguestbook&subpage=manage_gbooks&func=update&bid='.$mBG_bid.''; ?>" method="post" enctype="multipart/form-data" id="REX_FORM">
<fieldset class="rex-form-col-1">
<legend><span>Einstellungen:</span></legend>
<div class="rex-form-wrapper">
            
<div class="rex-form-row"><p class="rex-form-text">
<label for="gbook_name">Name:</label>
<input class="rex-form-text" type="text" name="gbook_name" value="<?php echo $gbook_name; ?>" />
</div>

<div class="rex-form-row">
  <p class="rex-form-col-a rex-form-submit">
    <input class="rex-form-submit" type="submit" value="Einstellung speichern" accesskey="s" title="Einstellung speichern"/>
	</p>
</div>

<div class="rex-clearer"></div>

</div>
</fieldset>
</form>

<form action="<?php echo 'index.php?page=multiguestbook&subpage=manage_gbooks&func=del&bid='.$mBG_bid.''; ?>" method="post" enctype="multipart/form-data" id="REX_FORM">
<fieldset class="rex-form-col-1">
<legend><span>Aktionen:</span></legend>
<div class="rex-form-wrapper">
            
<div class="rex-form-row">
  <p class="rex-form-col-a rex-form-submit">
    <input class="rex-form-submit" type="submit" value="Dieses G&auml;stebuch l&ouml;schen" accesskey="s" title="Dieses G&auml;stebuch l&ouml;schen" onclick="return confirm('Achtung: Das G&auml;stebuch und seine gesamten Eintr&auml;ge werden unwiederbringlich gel&ouml;scht!')"/>
	</p>
</div>

<div class="rex-clearer"></div>

</div>
</fieldset>
</form>

</div>
<?php
}
else
{
?>
<div class="rex-form" style="margin-bottom:10px;">
<form action="<?php echo 'index.php?page=multiguestbook&subpage=manage_gbooks&func=add'; ?>" method="post" enctype="multipart/form-data" id="REX_FORM">
<fieldset class="rex-form-col-1">
<legend><span>Einstellungen:</span></legend>
<div class="rex-form-wrapper">
            
<div class="rex-form-row"><p class="rex-form-text">
<label for="gbook_name">Name:</label>
<input class="rex-form-text" type="text" name="gbook_name" value="<?php echo $gbook_name; ?>" />
</div>

<div class="rex-form-row">
  <p class="rex-form-col-a rex-form-submit">
    <input class="rex-form-submit" type="submit" value="G&auml;stebuch erstellen" accesskey="s" title="G&auml;stebuch erstellen"/>
	</p>
</div>

<div class="rex-clearer"></div>

</div>
</fieldset>
</form>
</div>
<?php
}
?>

<table class="rex-table" style="margin-bottom:10px;">
    <caption>Folgendes G&auml;stebuch verwalten:</caption>
    <colgroup>
      <col width="*">
    </colgroup>
    <thead>
      <tr>
        <th>
          <a href="index.php?page=multiguestbook&subpage=manage_gbooks&func=add">Ein neues G&auml;stebuch erstellen</a>  
        </th>
      </tr>
    </thead>
</table>

</div>

