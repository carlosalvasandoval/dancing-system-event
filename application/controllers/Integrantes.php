<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Integrantes extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("Integrantes_model", "Integrantes");
	}

	public function delete_copia_dni()
	{
		if($this->input->is_ajax_request() && $this->input->method(TRUE)=='POST')
		{
			$integrante_id = (int)$this->input->post("integrante_id");
			$integrante = $this->Integrantes->get($integrante_id);
			if(!empty($integrante->copia_dni))
			{
				if(remove($integrante->copia_dni))
				{
					$data_update = array(
						"id" => $integrante_id,
						"copia_dni" => NULL
					);
					$response = $this->Integrantes->update($data_update);
				}else{
					$response = array("result"=>false, "msg" => "Error al borrar archivo");
				}
				echo json_encode($response);
			}
		}
		else
		{
			redirect("/", "refresh");
		}
	}
}
