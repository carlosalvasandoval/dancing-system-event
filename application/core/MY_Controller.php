<?php 

class MY_Controller extends CI_Controller
{
  public $post_data;
  public $data = array();
  public $lib_js = array();
  public $lib_css = array();
  
  public function __construct()
  {
    parent::__construct();
  }

  public function add_lib_css($css)
  {
    $this->lib_css[] = $css;
  }

  public function add_lib_js($js)
  {
    $this->lib_js[] = $js;
  }

  public function get_template($view, $vars = array())
  {
    $vars["lib_css"] =  $this->lib_css;
    $vars["lib_js"] =  $this->lib_js;
    $vars["message"] = show_flash_message();
    $vars["user_logged"] = ($this->ion_auth->logged_in()) ? $this->ion_auth->user()->row() : '';
    $this->load->view("head", $vars);
    $this->load->view($view);
    $this->load->view("footer");
  }
}