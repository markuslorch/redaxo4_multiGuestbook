<?php
/**
 * multiGuestbook - mGBook Class
 * @author m[dot]lorch[at]it-kult[dot]de Markus Lorch
 * @package redaxo4
 * @version 0.9.2
 */
 
class mGB_Book extends mGB
{
  var $_id = '';
  var $_clang = '';
  var $_show_offline = '';
  var $_sort_order = '';
  var $_sqlIndex = 'bid';
  var $_sqlTable = '761_mGB_Books';
  
  function mGB_Book($bid, $clang = FALSE, $show_offline = FALSE, $sort_order = 'ASC')
  {
    global $REX;
    
    //Set Class Variables
    $this->_id = $bid;
    $this->_clang = $clang;
    $this->_show_offline = $show_offline;
    $this->_sort_order= $sort_order;
    
    $this->SQL = new rex_sql;
  }

  /* Returns number of entries */
  function countEntries()
  {
    $this->SQL->setQuery($this->getEntriesSelect('761_mGB_Entries'));
    return $this->SQL->getRows();
  }
  
  /* Returns an Array of mGBookEntries Objects */
  function getEntries($start = FALSE, $step = FALSE)
  {
    if($start !== FALSE || $step !== FALSE)
      $sqlQry = $sqlQry.'LIMIT '.$start.', '.$step.' ';
    
    $this->SQL->setQuery($this->getEntriesSelect('761_mGB_Entries').$sqlQry);
    
    for($i = 0; $i < $this->SQL->getRows(); $i++)
    {
      $entries[] = new mGB_Entry($this->SQL->getValue('eid'));
      $this->SQL->next();
    }
  
    return $entries;
  } 
}  
?>