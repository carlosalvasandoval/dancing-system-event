<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

function create_flash_message($text, $type)
{
  $ci = & get_instance();
  $ci->session->set_flashdata('message', array(
   'text' => $text,
   'type' => $type));
}

function show_flash_message()
{
  $ci = & get_instance();
  $message = $ci->session->flashdata('message');
  $ci->session->unset_userdata('message');
  return $message;
}

function include_action_script()
{
  $ci = & get_instance();
  $class = $ci->router->fetch_class();
  $action = $ci->router->fetch_method();
  $relative_path = 'assets/js/' . $class . '/' . $action . '.js';
  if (file_exists(FCPATH . $relative_path))
  {
   echo '<script type = "text/javascript" src ="' . base_url($relative_path . '?time=' . time()) . '"></script>';
  }
}

function set_datetime_db($datetime)
{
  $new_datetime = DateTime::createFromFormat('d/m/Y H:i A', $datetime);
  return $new_datetime->format("Y-m-d H:i:s");
}

function set_datetime($datetime)
{
  $new_datetime = date("d/m/Y h:i A", strtotime($datetime));
  return $new_datetime;
}

function valid_datetime($datetime)
{
  $ci = & get_instance();
  $set_datetime = set_datetime_db($datetime);
  if(!DateTime::createFromFormat('Y-m-d H:m:s', $set_datetime))
  {
    $ci->form_validation->set_message('valid_datetime', 'El campo {field} tiene un formato invalido');
    return FALSE;
  }else{
    return TRUE;
  }
}

function set_date_db($date)
{
  $new_date = DateTime::createFromFormat('d/m/Y', $date);
  return $new_date->format("Y-m-d");
}

function set_date($date)
{
  $new_date = date("d/m/Y", strtotime($date));
  return $new_date;
}

function valid_date($date)
{
  $ci = & get_instance();
  $set_date = set_date_db($date);
  if(!DateTime::createFromFormat('Y-m-d', $set_date))
  {
    $ci->form_validation->set_message('valid_date', 'El campo {field} tiene un formato invalido');
    return FALSE;
  }else{
    return TRUE;
  }
}

function set_session($item, $value)
{
  $ci = & get_instance();
  $ci->session->set_userdata($item, $value);
}

function get_session($item)
{
  $ci = & get_instance();
  return $ci->session->userdata($item);
}

function upload($file, $name_input, $ruta = "files/", $allowed_types = "png|PNG|jpg|JPG|gif|GIF"){
  $ci = & get_instance();
  $config['upload_path'] = './assets/'.$ruta;
  $config['allowed_types'] = $allowed_types;
  $config['encrypt_name'] = true;

  $ci->load->library('upload', $config);
  if ( !$ci->upload->do_upload($name_input) )
  {
    return array("result"=>false, "msg"=>$ci->upload->display_errors());
  }else{
    return array("result"=>true, "file_name"=>$ci->upload->data('file_name'));
  }
}

function remove($file, $ruta="files/"){
  if(unlink("./assets/".$ruta.$file))
  {
    return true;
  }else{
    return false;
  }
}

function get_count_likes($url='')
{
  $set_url = "https://graph.facebook.com/?ids=".$url;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL,$set_url);
  $result=curl_exec($ch);
  curl_close($ch);
  $set_result = json_decode($result);
  $likes = 0;
  foreach($set_result as $link=>$data)
  {
    $likes = $data->share->share_count;
  }
  return $likes;
}

function debug_r($array){
  echo "<pre>";
  print_r($array);
  die;
}
