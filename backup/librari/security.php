<?php
defined('_FINDEX_') or die('Access Denied');
  
  class Security
  {
	  private $lTable = "log";
      private $ip;
      private $counter;
      private $wait;
      
      /**
       * Security::__construct()
       * 
       * @param integer $attempt
       * @param integer $wait
       * @return
       */
      function __construct($attempt = 3, $wait = 180)
      {
          $this->setPars($attempt, $wait);
          $this->ip = $this->getip();
      }
      
      /**
       * Security::getip()
       * 
       * @return
       */
      private function getip()
      {
          return $_SERVER['REMOTE_ADDR'];
      }
      
      /**
       * Security::setPars()
       * 
       * @param mixed $counter
       * @param mixed $wait
       * @return
       */
      private function setPars($counter, $wait)
      {
          $this->counter = $counter;
          $this->wait = $wait;
      }
      
      /**
       * Security::loginAgain()
       * 
       * @param mixed $remain
       * @return
       */
      public function loginAgain(&$remain)
      {
          $remain = 0;
          $time = $this->getTime();
          $var = $this->getRecord($this->ip);
          if (!isset($var))
              return true;
          if ($var['failed'] < $this->counter)
              return true;
          if (($time - $var['failed_last']) > $this->wait) {
              $this->deleteRecord($this->ip);
              return true;
          }
          $remain = $this->wait - ($time - $var['failed_last']);
          return false;
      }
      
      /**
       * Security::setFailedLogin()
       * 
       * @return
       */
      public function setFailedLogin()
      {
          $this->setRecord($this->ip, $this->getTime());
      }
      
      /**
       * Security::getTime()
       * 
       * @return
       */
      private function getTime()
      {
          return time();
      }
      
      /**
       * Security::getRecord()
       * 
       * @param mixed $ip
       * @return
       */
      private function getRecord($ip)
      {
          global $db;
		  
          $sql = "SELECT * FROM " . $this->lTable . " WHERE ip='" . $db->escape($ip) . "' AND type='user'";
          $row = $db->first($sql);
		  
		  return ($row) ? $row : 0;
      }
      
      /**
       * Security::setRecord()
       * 
       * @param mixed $ip
       * @param mixed $failed
       * @param mixed $failed_last
       * @return
       */
      private function setRecord($ip, $failed_last)
      {
          global $db;
		  
          $ip = $db->escape($ip);
          if ($row = $this->getRecord($ip)) {
              $data = array(
					'failed' => "INC(1)", 
					'failed_last' => $failed_last
			  );
              
              $db->update($this->lTable, $data, "id='" . $row['id'] . "'");
          } else {
              $data = array(
					'ip' 		=> $ip, 
					'type' 		=> "user", 
					'failed' 	=> 1, 
					'failed_last' => $failed_last, 
					'importance' => "yes", 
					'user_id' => "Guest", 
					'created' => "NOW()", 
					'message' => "Possible Brute force attack", 
					'info_icon' => "attack"
			  );
              
              $db->insert($this->lTable, $data);
          }
      }

      /**
       * Security::writeLog()
       * 
       * @param mixed $message
       * @param string $type
       * @param mixed $imp
       * @param mixed $icon
       * @return
       */
      function writeLog($message, $type='', $imp, $icon)
      {
          global $db, $core, $user;
          
			if (!$icon)
			  $icon = "default";
			  
			if (empty($type))
			  $type = "system";
			  
			$data = array(
					'user_id' => $user->username, 
					'ip' => $this->ip, 
					'created' => "NOW()", 
					'type' => $type, 
					'message' => $message, 
					'info_icon' => trim($icon), 
					'importance' => trim($imp)
			);
			
			$db->insert($this->lTable, $data);
      }

      /**
       * Security::getLogs()
       * 
       * @param mixed $type
       * @return
       */
	  public function getLogs()
	  {
		  global $db, $pager, $core;
		  
		  require_once(WOJOLITE . "lib/class_paginate.php");
          $pager = new Paginator();

          if (isset($_POST['fromdate']) && $_POST['fromdate'] <> "" || isset($from) && $from != '') {
              $enddate = date("Y-m-d");
              $fromdate = (empty($from)) ? $_POST['fromdate'] : $from;
              if (isset($_POST['enddate']) && $_POST['enddate'] <> "") {
                  $enddate = $_POST['enddate'];
              }
              $where = " WHERE created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
			   
			   $q = "SELECT COUNT(*) FROM ".$this->lTable.""
			   . "\n WHERE created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59' LIMIT 1";
			   $record = $db->query($q);
			   $total = $db->fetchrow($record);
			   $counter = $total[0];  
          }  else {
			  $where = '';
			  $counter = countEntries($this->lTable);
		  }

		  if (isset($_GET['sort'])) {
			  list($sort, $order) = explode("-", $_GET['sort']);
			  $sort = sanitize($sort);
			  $order = sanitize($order);
			  if (in_array($sort, array("type", "importance", "user_id", "created", "info_icon"))) {
				  $ord = ($order == 'DESC') ? " DESC" : " ASC";
				  $sorting = $sort . $ord;
			  } else {
				  $sorting = " created DESC";
			  }
		  } else {
			  $sorting = " created DESC";
		  }
		  
          $pager->items_total = $counter;
          $pager->default_ipp = $core->perpage;
          $pager->paginate();
          
          if ($counter == 0) {
              $pager->limit = null;
          }
		  
		  $sql = "SELECT *, DATE_FORMAT(created, '" . $core->long_date . "') as added" 
		  . "\n FROM " . $this->lTable
		  . "\n $where"
		  . "\n ORDER BY " . $sorting . $pager->limit;
		  $row = $db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;
	  }
	  
      /**
       * Security::emptylogs()
       * 
       * @return
       */
	  public function emptylogs()
	  {
		  global $db;
		  
		  if ($db->query("TRUNCATE TABLE " . $this->lTable)) {
			  $this->writeLog(lang('LOG_MSG_EMPTY'), "no", "content");
		  } else
			  return false;
	  }
					  
      /**
       * Security::deleteRecord()
       * 
       * @param mixed $ip
       * @return
       */
      private function deleteRecord($ip)
      {
          global $db;
          $db->delete("log", "ip='" . $db->escape($ip) . "' AND type = 'user'");
      }
	  
      /**
       * Security::getLogFilter()
       * 
       * @return
       */
      public function getLogFilter()
	  {
		  $arr = array(
				 'type-ASC' => _LG_TYPE.' &uarr;',
				 'type-DESC' => _LG_TYPE.' &darr;',
				 'importance-ASC' => _LG_IMPORTANCE.' &uarr;',
				 'importance-DESC' => _LG_IMPORTANCE.' &darr;',
				 'user_id-ASC' => _LG_USER.' &darr;',
				 'user_id-DESC' => _LG_USER.' &darr;',
				 'created-ASC' => _CREATED.' &uarr;',
				 'created-DESC' => _CREATED.' &darr;',
				 'info_icon-ASC' => _LG_DATA.' &uarr;',
				 'info_icon-DESC' => _LG_DATA.' &darr;'
		  );
		  
		  $filter = '';
		  foreach ($arr as $key => $val) {
				  if ($key == get('sort')) {
					  $filter .= "<option selected=\"selected\" value=\"$key\">$val</option>\n";
				  } else
					  $filter .= "<option value=\"$key\">$val</option>\n";
		  }
		  unset($val);
		  return $filter;
	  }
  }
?>