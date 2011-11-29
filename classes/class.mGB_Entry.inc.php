<?php
/**
 * multiGuestbook - mGBook_entry Class
 * @author m[dot]lorch[at]it-kult[dot]de Markus Lorch
 * @package redaxo4
 * @version 0.9.2
 */
 
class mGB_Entry extends mGB
{
  var $_id = '';
  var $_sqlTable = '761_mGB_Entries';
  var $_sqlIndex = "eid";
  
  function mGB_Entry($eid)
  {
    global $REX;
    
    $this->_id = $eid;
    $this->SQL = new rex_sql;
  }
}
?>