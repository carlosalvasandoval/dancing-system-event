<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parejas extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("Parejas_model", "Parejas");
	}

	public function index($concurso_id)
	{
		$this->load->model("Responsables_model", "Responsables");
		$user = $this->ion_auth->user()->row();
		if($user->rol_active != ADMIN)
		{
			$responsable = $this->Responsables->get($concurso_id, $user->id);
			if($user->id != $responsable->user_id)
			{
				create_flash_message("Accedo denegado", "danger");
				redirect("/");
			}
		}

		$this->data["rol"] = $user->rol_active;
		$this->load->model("Concursos_model", "Concursos");
		set_session("concurso_id", $concurso_id);
		$concurso = $this->Concursos->get($concurso_id);
		$this->data["concurso"] = $concurso;

		$this->add_lib_css("assets/lib/bootstrap-toggle/css/bootstrap-toggle.min.css");
		$this->add_lib_js("assets/lib/bootstrap-toggle/js/bootstrap-toggle.min.js");
		$this->get_template("parejas/index", $this->data);
	}

	public function save($id='')
	{
		$concurso_id = get_session("concurso_id");
		$user = $this->ion_auth->user()->row();
		$pareja = $this->Parejas->get($id);
		$this->data["id"] = $id; 
		$this->data["concurso_id"] = $concurso_id;	

		$title_form = (empty($id))?"Registrar":"Editar";
		$title_form .= " Pareja";
		$this->data["title_form"] = $title_form;

		$user = $this->ion_auth->user()->row();
		$user_id = $user->id;

		if($user->rol_active!=ADMIN)
		{
			$this->load->model("Responsables_model", "Responsables");
			$this->load->model("Concursos_model", "Concursos");
			$responsable = $this->Responsables->get($concurso_id, $user_id);
			$concurso = $this->Concursos->get($concurso_id);

			$today = date("Y-m-d H:i:s");
			if($today>$concurso->fecha_fin_inscripcion)
			{
				create_flash_message("Ya no puede registrar mas parejas, la fecha de cierre de inscripción fue el ".set_datetime($concurso->fecha_fin_inscripcion), "danger");
				redirect("parejas/index/".$concurso_id);
			}

			if(!empty($pareja) && empty($responsable))
			{
				create_flash_message("Acceso denegado", "danger");
				redirect("parejas/index/".$concurso_id);
			}
			
			if(empty($id))
			{
				$parejas = $this->Parejas->get_by_concurso_profesor($concurso_id, $user_id);
				if($concurso->parejas_profesor <= count($parejas))
				{
					create_flash_message("Ya no puede registrar mas parejas, el numero máximo a registrar es de ".$concurso->parejas_profesor, "danger");
					redirect("parejas/index/".$concurso_id);
				}			
			}
		}

		$this->load->model("Integrantes_model", "Integrantes");
		$integrantes = $this->Integrantes->get_by_pareja($id);
		$this->data["integrante"] = (count($integrantes)>1)?$integrantes:"";

		$this->data["post_data"] = "";
		if($this->input->method(TRUE)=='POST')
		{
			$this->post_data = $this->input->post();
			$this->data["post_data"] = $this->post_data;

			$this->form_validation->set_rules('nombre_pareja', 'Nombre de la pareja', "trim|required");
			$this->form_validation->set_rules('dni[]', 'DNI', "trim|required|integer|min_length[8]|max_length[8]");
			$this->form_validation->set_rules('nombres[]', 'Nombre(s)', "trim|required");
			$this->form_validation->set_rules('apellidos[]', 'Apellidos', "trim|required");
			$this->form_validation->set_rules('fecha_nacimiento[]', 'Fecha de nacimiento', "trim|required|valid_date");

			if( $this->form_validation->run() )
			{
				if(empty($id))
				{
					for($i=0; $i<CANT_INTEGRANTES; $i++)
					{
						$pareja_added = $this->Parejas->is_added($this->post_data["dni"][$i], $concurso_id);
						if(!empty($pareja_added))
						{
							create_flash_message("El integrante con el DNI ".$this->post_data["dni"][$i]." ya esta agregado en la pareja ".$pareja->nombre, "danger");
							redirect("parejas/save/".$id);
						}
					}

					$data_pareja = array(
						"concurso_id" => $concurso_id,
						"user_id" => $user_id
					);
				}

				$nombre_pareja = filter_var($this->post_data["nombre_pareja"], FILTER_SANITIZE_STRING);
				$data_pareja["id"] = $id;
				$data_pareja["nombre"] = $nombre_pareja;

				if($user->rol_active==ADMIN && !empty($_FILES["foto"]["name"]))
				{
					$response_upload_foto = upload($_FILES["foto"], "foto");
					if(!$response_upload_foto["result"])
        	{
        		create_flash_message($response_upload_foto["msg"], "danger");
        		redirect("parejas/save/".$id);
        	}	
  				$data_pareja["foto"] = $response_upload_foto["file_name"];
				}

				$response_pareja = $this->Parejas->save($data_pareja);
				if(!$response_pareja["result"])
				{
					create_flash_message($response["msg"], "danger");
					redirect("parejas/save/".$id);
				}
				$pareja_id = $response_pareja["data"]->id;				

				$data_integrante = array();

				for($i=0; $i<CANT_INTEGRANTES; $i++)
				{
					$integrante = $this->Integrantes->get_by_dni($this->post_data["dni"][$i]);
					$integrante_id = (!empty($integrante))?$integrante->id:"";
					$copia_dni = NULL;
					if( !empty($_FILES["copia_dni"]["name"][$i]) )
					{
						$_FILES["doc"]["name"] = $_FILES["copia_dni"]["name"][$i];
						$_FILES["doc"]["type"] = $_FILES["copia_dni"]["type"][$i];
						$_FILES["doc"]["tmp_name"] = $_FILES["copia_dni"]["tmp_name"][$i];
						$_FILES["doc"]["error"] = $_FILES["copia_dni"]["error"][$i];
						$_FILES["doc"]["size"] = $_FILES["copia_dni"]["size"][$i];
						$response = upload($_FILES["doc"], "doc");
						if(!$response["result"])
          	{
          		create_flash_message($response["msg"], "danger");
          		redirect("parejas/save/".$id);
          	}	
    				$copia_dni = $response["file_name"];
					}

					$fecha_nacimiento = set_date_db($this->post_data["fecha_nacimiento"][$i]);
					$nombres = filter_var($this->post_data["nombres"][$i], FILTER_SANITIZE_STRING);
					$apellidos = filter_var($this->post_data["apellidos"][$i], FILTER_SANITIZE_STRING);

					$data_integrante[] = array(
						"id" => $integrante_id,
						"pareja_id" => $pareja_id,
						"dni" => $this->post_data["dni"][$i],
						"nombres" => $nombres,
						"apellidos" => $apellidos,
						"fecha_nacimiento" => $fecha_nacimiento,
						"copia_dni" => $copia_dni,
					);
				}

				$response_integrante = $this->Integrantes->save($data_integrante);
				if(!$response_integrante["result"])
				{
					create_flash_message($response_integrante["msg"], 'danger');					
				}else{
					create_flash_message("Datos guardados", "success");
					redirect("parejas/index/".$concurso_id);
				}	
			}else{
				create_flash_message($this->form_validation->error_string(), 'danger');
			}
		}else{		
			if(!empty($pareja))
			{
				$this->data["pareja"] = $pareja;
			}
		}
		$this->data["user"] = $user;

		$this->add_lib_css("assets/lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css");
		$this->add_lib_js("assets/lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js");
		$this->add_lib_css("assets/lib/jasny-bootstrap/css/jasny-bootstrap.min.css");
		$this->add_lib_js("assets/lib/jasny-bootstrap/js/jasny-bootstrap.min.js");
		$this->get_template("parejas/form", $this->data);
	}

	public function validar($id)
	{
		$user = $this->ion_auth->user()->row();
		$pareja = $this->Parejas->get($id);
		$this->data["pareja"] = $pareja;
		$concurso_id = get_session("concurso_id");
		if($user->rol_active!=ADMIN)
		{
			$this->load->model("Responsables_model", "Responsables");
			$responsable = $this->Responsables->get($concurso_id, $user->id);
			if(!empty($pareja) && empty($responsable))
			{
				create_flash_message("No tiene permisos para realizar la acción", 'danger');
				redirect("parejas/index/".$concurso_id);
			}
		}
		$this->data["concurso_id"] = $concurso_id;

		if($this->input->method(TRUE)=='POST')
		{
			$this->form_validation->set_rules('estado_pareja', 'Validación Pareja', "trim|integer|required");
			if( $this->form_validation->run() )
			{
				$estado_pareja = $this->input->post("estado_pareja");
				$data_update = array(
					"id" => $id,
					"estado_pareja" => $estado_pareja
				);
				$response = $this->Parejas->save($data_update);
				if($response["result"])
				{	
					create_flash_message('Pareja validada', 'success');
					redirect("parejas/index/".$concurso_id);
				}else{
					create_flash_message($response["msg"], 'danger');
				}
			}else{
				create_flash_message($this->form_validation->error_string(), 'danger');
			}
		}
		$this->get_template("parejas/validar", $this->data);
	}

	public function checkin()
	{
		if($this->input->is_ajax_request() && $this->input->method(TRUE)=='POST')
		{
			$user = $this->ion_auth->user()->row();
			if($user->rol_active==PROFESOR)
			{
				$response = array("result"=>false, "msg"=>"No puede realizar esta acción");
			}else{
				$data = $this->input->post();
				$pareja = $this->Parejas->get($data["id"]);
				if($pareja->estado_pareja == PAREJA_RECHAZADA)
				{
					$response = array("result"=>false, "msg"=>"La pareja esta rechazada, no puede hacer el check in");
				}else{
					$data["fecha_checkin"] = date("Y-m-d H:i:s");
					$response = $this->Parejas->save($data);					
				}
			}
			echo json_encode($response);
		}else{
			redirect("/");
		}
	}

	public function delete()
	{

		if($this->input->is_ajax_request() && $this->input->method(TRUE)=='POST')
		{
			$id = (int)$this->input->post("id");
			$user = $this->ion_auth->user()->row();
			$pareja = $this->Parejas->get($id);
			$concurso_id = get_session("concurso_id");
			if($user->rol_active!=ADMIN)
			{
				$this->load->model("Responsables_model", "Responsables");
				$responsable = $this->Responsables->get($concurso_id, $user->id);
				if(!empty($pareja) && empty($responsable))
				{
					$response = array("result"=>false , "msg"=>"No tiene permisos para realizar la acción");
					echo json_encode($response);
					die;
				}
			}
			$response = $this->Parejas->delete($id);
			echo json_encode($response);
		}
		else
		{
			redirect("/", "refresh");
		}
	}

	public function grid()
	{
		$concurso_id = get_session("concurso_id");
		$user = $this->ion_auth->user()->row();
		echo $this->Parejas->grid($concurso_id, $user);
	}

	public function delete_foto()
	{
		if($this->input->is_ajax_request() && $this->input->method(TRUE)=='POST')
		{
			$pareja_id = (int)$this->input->post("pareja_id");
			$pareja = $this->Parejas->get($pareja_id);
			$user = $this->ion_auth->user()->row();
			if(!empty($pareja->foto) && $user->rol_active==ADMIN)
			{
				if(remove($pareja->foto))
				{
					$data_update = array(
						"id" => $pareja_id,
						"foto" => NULL
					);
					$response = $this->Parejas->save($data_update);
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

	public function see($id)
	{
		if($this->input->is_ajax_request() && $this->input->method(TRUE)=='GET')
		{
			$pareja = $this->Parejas->get($id);
			$this->load->model("Integrantes_model", "Integrantes");
			$integrantes = $this->Integrantes->get_by_pareja($id);
			$pareja->integrantes = $integrantes;
			echo json_encode($pareja);
		}
		else
		{
			redirect("/", "refresh");
		}
	}
}