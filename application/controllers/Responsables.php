<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Responsables extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			return show_error('You must be an administrator to view this page.');
		}
		$this->load->model("Responsables_model", "Responsables");
	}

	public function index($concurso_id, $rol)
	{
		$this->data["concurso_id"] = $concurso_id;
		$this->data["rol"] = $rol;
		$rol_allow = array(PROFESOR, RECEPCIONISTA);
		if( empty($concurso_id) || !in_array($rol, $rol_allow) )
		{
			create_flash_message("Accesso denegado", "danger");
			redirect("concursos");
		}
		$this->load->model("Concursos_model", "Concursos");
		$concurso = $this->Concursos->get($concurso_id);
		$this->data["concurso"] = $concurso;
		$this->data["title_view"] = $concurso->nombre." - ";
		$rol_name = ($rol==PROFESOR)?"Profesores":"Recepcionistas";
		$this->data["title_view"] .= $rol_name;
		$this->data["rol_name"] = $rol_name;

		$this->load->model("Responsables_model", "Responsables");
		$desasignados = $this->Responsables->get_desasignados($concurso_id, $rol);
		$this->data["desasignados"] = $desasignados;

		$this->add_lib_css("assets/lib/select2/css/select2.min.css");
		$this->add_lib_js("assets/lib/select2/js/select2.full.min.js");
		$this->get_template("responsables/index", $this->data);
	}

	public function save(){
		if($this->input->method(TRUE)=='POST')
		{
			$this->post_data = $this->input->post();	
			$this->form_validation->set_rules('user_id', 'Asignar', "trim|required|integer");
			$this->form_validation->set_rules('concurso_id', 'Concurso', "trim|required|integer");

			if( $this->form_validation->run() )
			{
				$data_db = $this->post_data;
				unset($data_db["rol"]);
				$response = $this->Responsables->save($data_db);
				if( $response["result"] )
				{
					create_flash_message("Usuario asignado", "success");
				}else{
					create_flash_message($response["msg"], "danger");
				}
			}
			else
			{
				create_flash_message($this->form_validation->error_string(), 'danger');
			}
			redirect("responsables/index/".$this->post_data["concurso_id"]."/".$this->post_data["rol"]);
		}else{
			redirect("concursos");
		}
	}

	public function delete($id, $concurso_id, $rol)
	{
		$response = $this->Responsables->delete($id);
		if($response["result"])
		{
			create_flash_message("Usuario desasignado", "success");
		}else{
			create_flash_message($response["msg"], "danger");
		}

		redirect("responsables/index/".$concurso_id."/".$rol);
	}

	public function grid($concurso_id, $rol)
	{
		echo $this->Responsables->grid($concurso_id, $rol);
	}
}
