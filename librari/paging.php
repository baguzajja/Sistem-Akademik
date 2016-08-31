<?php
  /**
   * Class Pagination
   *
   * @package CMS Pro
   * @author wojocms.com
   * @copyright 2010
   * @version $Id: class_paginate.php, v2.00 2011-04-20 18:20:24 gewa Exp $
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class Paginator
  {
      public $items_per_page;
      public $items_total;
      public $num_pages;
      public $limit;
      public $default_ipp;
      private $mid_range;
      private $low;
      private $high;
      private $display;
      private $querystring;
      private $current_page;
      
      
      /**
       * Paginator::__construct()
       * 
       * @return
       */
      function __construct()
      {
          $this->current_page = 1;
          $this->mid_range = 7;
          $this->items_per_page = (!empty($_GET['ipp'])) ? sanitize($_GET['ipp']) : $this->default_ipp;
      }
      
      /**
       * Paginator::paginate()
       * 
       * @param bool $path
       * @return
       */
      public function paginate($path = false)
      {
		  global $core;
		  
          if (!is_numeric($this->items_per_page) || $this->items_per_page <= 0)
              $this->items_per_page = $this->default_ipp;
          $this->num_pages = ceil($this->items_total / $this->items_per_page);
          
          $this->current_page = intval(sanitize(get('pg')));
          if ($this->current_page < 1 or !is_numeric($this->current_page))
              $this->current_page = 1;
          if ($this->current_page > $this->num_pages)
              $this->current_page = $this->num_pages;
          $prev_page = $this->current_page - 1;
          $next_page = $this->current_page + 1;
          
          if ($_GET) {
              $args = explode("&amp;", $_SERVER['QUERY_STRING']);
              foreach ($args as $arg) {
                  $keyval = explode("=", $arg);
                  if ($keyval[0] != "pg" && $keyval[0] != "ipp")
                      $this->querystring .= "&amp;" . sanitize($arg);
              }
          }
          
          if ($_POST) {
              foreach ($_POST as $key => $val) {
                  if ($key != "pg" && $key != "ipp")
                      $this->querystring .= "&amp;$key=" . sanitize($val);
              }
          }
          
          if ($this->num_pages > 1) {
              if ($this->current_page != 1 && $this->items_total >= $this->default_ipp) {
                  if ($path && $core->seo) {
                      $this->display = "<a href=\"".$path.$prev_page."-".$this->items_per_page.".html\">" . _PAG_PREV . "</a>";
                  } else {
                      $this->display = "<a href=\"$_SERVER[PHP_SELF]?pg=$prev_page&amp;ipp=$this->items_per_page$this->querystring\">" . _PAG_PREV . "</a>";
                  }
              } else {
				  $this->display = "<a href=\"#\" class=\"no-more\">" . _PAG_PREV . "</a>";
              }
              
              $this->start_range = $this->current_page - floor($this->mid_range / 2);
              $this->end_range = $this->current_page + floor($this->mid_range / 2);
              
              if ($this->start_range <= 0) {
                  $this->end_range += abs($this->start_range) + 1;
                  $this->start_range = 1;
              }
              if ($this->end_range > $this->num_pages) {
                  $this->start_range -= $this->end_range - $this->num_pages;
                  $this->end_range = $this->num_pages;
              }
              $this->range = range($this->start_range, $this->end_range);
              
              for ($i = 1; $i <= $this->num_pages; $i++) {
                  if ($this->range[0] > 2 && $i == $this->range[0])
                      $this->display .= " ... ";
                  
                  if ($i == 1 or $i == $this->num_pages or in_array($i, $this->range)) {
                      if ($i == $this->current_page) {
                          $this->display .= "<a href=\"#\" title=\"" . _PAG_GOTO . " $i " . _PAG_OF . " $this->num_pages\" class=\"current tooltip\">$i</a>";
                      } else {
                          if ($path && $core->seo) {
                              $this->display .= "<a class=\"tooltip\" title=\"" . _PAG_GOTO . " $i " . _PAG_OF . " $this->num_pages\" href=\"".$path.$i."-".$this->items_per_page.".html\">$i</a>";
                          } else {
                              $this->display .= "<a class=\"tooltip\" title=\"" . _PAG_GOTO . " $i " . _PAG_OF . " $this->num_pages\" href=\"$_SERVER[PHP_SELF]?pg=$i&amp;ipp=$this->items_per_page$this->querystring\">$i</a>";
                          }
                      }
                  }
                  if ($this->range[$this->mid_range - 1] < $this->num_pages - 1 && $i == $this->range[$this->mid_range - 1])
                      $this->display .= " ... ";
              }
              if ($this->current_page != $this->num_pages && $this->items_total >= $this->default_ipp) {
                  if ($path && $core->seo) {
                      $this->display .= "<a href=\"".$path.$next_page."-".$this->items_per_page.".html\">" . _PAG_NEXT . "</a>\n";
                  } else {
                      $this->display .= "<a href=\"$_SERVER[PHP_SELF]?pg=$next_page&amp;ipp=$this->items_per_page$this->querystring\">" . _PAG_NEXT . "</a>\n";
                  }
              } else {
				  $this->display .= "<a href=\"#\" class=\"no-more\">" . _PAG_NEXT . "</a>";
              }
          } else {
              for ($i = 1; $i <= $this->num_pages; $i++) {
                  if ($i == $this->current_page) {
                      $this->display .= "<a href=\"#\" class=\"current\">$i</a>";
                  } else {
					  if ($path && $core->seo) {
						  $this->display .= "<a href=\"".$path . $i."-".$this->items_per_page.".html\">$i</a>";
					  } else {
                          $this->display .= "<a href=\"$_SERVER[PHP_SELF]?pg=$i&amp;ipp=$this->items_per_page$this->querystring\">$i</a>";
					  }
                  }
              }
          }
          $this->low = ($this->current_page - 1) * $this->items_per_page;
          $this->high = $this->current_page * $this->items_per_page - 1;
          $this->limit = " LIMIT $this->low,$this->items_per_page";
      }
      
      /**
       * Paginator::items_per_page()
       * 
       * @return
       */
      public function items_per_page()
      {
          $items = '';
          $ipp_array = array(10, 15, 25, 50, 75, 100);
          foreach ($ipp_array as $ipp_opt)
              $items .= ($ipp_opt == $this->items_per_page) ? "<option selected=\"selected\" value=\"$ipp_opt\">$ipp_opt</option>\n" : "<option value=\"$ipp_opt\">$ipp_opt</option>\n";
          return "<strong>" . _PAG_IPP . "</strong>: <select class=\"custombox\" onchange=\"window.location='$_SERVER[PHP_SELF]?pg=1&amp;ipp='+this[this.selectedIndex].value+'$this->querystring';return false\" style=\"min-width:50px\">$items</select>\n";
      }
      
      /**
       * Paginator::jump_menu()
       * 
       * @return
       */
      public function jump_menu()
      {
          $option = '';
          for ($i = 1; $i <= $this->num_pages; $i++) {
              $option .= ($i == $this->current_page) ? "<option value=\"$i\" selected=\"selected\">$i</option>\n" : "<option value=\"$i\">$i</option>\n";
          }
          return "<strong>" . _PAG_GOTO . "</strong>: <select class=\"custombox\" onchange=\"window.location='$_SERVER[PHP_SELF]?pg='+this[this.selectedIndex].value+'&amp;ipp=$this->items_per_page$this->querystring';return false\" style=\"min-width:50px\">$option</select>\n";
      }
      
      /**
       * Paginator::display_pages()
       * 
       * @return
       */
      public function display_pages()
      {
          return($this->items_total > $this->default_ipp) ? $this->display : "";
      }
  }
?>