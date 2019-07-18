<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Concursos extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in())
		{
			create_flash_message("Sesión experiada", "danger");
			redirect("/");
		}
		$this->load->model("Concursos_model", "Concursos");
	}

	public function index()
	{
		$user = $this->ion_auth->user()->row();
		$this->data["user"] = $user;
		$this->get_template("concursos/index", $this->data);
	}

	public function save($id=''){
		if(!$this->ion_auth->is_admin())
		{
			create_flash_message("Acceso denegado", "danger");
			redirect("/");
		}

		if($this->input->method(TRUE)=='POST')
		{
			$this->post_data = $this->input->post();
			$this->data["post_data"] = $this->post_data;			
			$this->form_validation->set_rules('nombre', 'Nombre', "trim|required");
			$this->form_validation->set_rules('fecha_ini_inscripcion', 'Fecha Inscripción', "trim|required|valid_datetime");
			$this->form_validation->set_rules('fecha_fin_inscripcion', 'Fecha Cierre Inscripción', "trim|required|valid_datetime");
			$this->form_validation->set_rules('fecha_ini_votacion', 'Fecha Votación', "trim|required|valid_datetime");
			$this->form_validation->set_rules('fecha_fin_votacion', 'Fecha Cierre Votación', "trim|required|valid_datetime");
			$this->form_validation->set_rules('parejas_profesor', 'N° parejas por Profesor', "trim|integer|required");
			$this->form_validation->set_rules('categoria_id', 'Categoria', "trim|integer|required");


			if( $this->form_validation->run() )
			{
				$fecha_ini_inscripcion = $this->post_data["fecha_ini_inscripcion"];
				$this->post_data["fecha_ini_inscripcion"] = set_datetime_db($fecha_ini_inscripcion);

				$fecha_fin_inscripcion = $this->post_data["fecha_fin_inscripcion"];
				$this->post_data["fecha_fin_inscripcion"] = set_datetime_db($fecha_fin_inscripcion);

				if( $this->post_data["fecha_ini_inscripcion"] > $this->post_data["fecha_fin_inscripcion"])
				{
					create_flash_message("Fecha Inscripción debe ser menor a la Fecha Cierre Inscripción", "danger");
					redirect("concursos/save/".$id);
				}


				$fecha_ini_votacion = $this->post_data["fecha_ini_votacion"];
				$this->post_data["fecha_ini_votacion"] = set_datetime_db($fecha_ini_votacion);

				$fecha_fin_votacion = $this->post_data["fecha_fin_votacion"];
				$this->post_data["fecha_fin_votacion"] = set_datetime_db($fecha_fin_votacion);

				if( $this->post_data["fecha_ini_inscripcion"] > $this->post_data["fecha_ini_votacion"])
				{
					create_flash_message("Fecha Inscripción debe ser menor a la Fecha Votación", "danger");
					redirect("concursos/save/".$id);
				}

				if( $this->post_data["fecha_ini_votacion"] > $this->post_data["fecha_fin_votacion"])
				{
					create_flash_message("Fecha Votación debe ser menor a la Fecha Cierre Votación", "danger");
					redirect("concursos/save/".$id);
				}

				$nombre_sanitizado = filter_var($this->post_data["nombre"], FILTER_SANITIZE_STRING);
				$this->post_data["nombre"] = $nombre_sanitizado;

				$response = $this->Concursos->save($this->post_data);
				if( $response["result"] )
				{
					create_flash_message("Concurso guardado", "success");
					redirect("concursos");
				}else{
					create_flash_message($response["msg"], "danger");
				}
			}
			else
			{
				create_flash_message($this->form_validation->error_string(), 'danger');
			}
		}

		$this->data["title_form"] = ((empty($id))?"Registrar":"Editar")." Concurso";
		$this->data["concurso"] = (!empty($id))?$this->Concursos->get($id):'';
		if( !empty($this->data["concurso"]) )
		{
			$fecha_ini_inscripcion = $this->data["concurso"]->fecha_ini_inscripcion;
			$this->data["concurso"]->fecha_ini_inscripcion = set_datetime($fecha_ini_inscripcion);

			$fecha_fin_inscripcion = $this->data["concurso"]->fecha_fin_inscripcion;
			$this->data["concurso"]->fecha_fin_inscripcion = set_datetime($fecha_fin_inscripcion);

			$fecha_ini_votacion = $this->data["concurso"]->fecha_ini_votacion;
			$this->data["concurso"]->fecha_ini_votacion = set_datetime($fecha_ini_votacion);

			$fecha_fin_votacion = $this->data["concurso"]->fecha_fin_votacion;
			$this->data["concurso"]->fecha_fin_votacion = set_datetime($fecha_fin_votacion);
		}

		$this->load->model("Categorias_model", "Categorias");
		$categorias = $this->Categorias->get();
		$this->data["categorias"] = $categorias;
		$this->add_lib_css("assets/lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css");
		$this->add_lib_js("assets/lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js");
		$this->get_template("concursos/form", $this->data);
	}

	public function delete()
	{
		if($this->input->is_ajax_request() && $this->input->method(TRUE)=='POST' && $this->ion_auth->is_admin())
		{
			$id = (int)$this->input->post("id");
			$response = $this->Concursos->delete($id);
			echo json_encode($response);
		}
		else
		{
			redirect("/", "refresh");
		}
	}

	public function grid()
	{
		$user = $this->ion_auth->user()->row();
		echo $this->Concursos->grid($user->id, $user->rol_active);
	}
}
