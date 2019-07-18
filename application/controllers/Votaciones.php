<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Votaciones extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model("Votaciones_model", "Votaciones");
	}

	public function index()
	{
		$this->load->model("Concursos_model", "Concursos");
		$concursos = $this->Concursos->get_to_vote();
		if(count($concursos)==1)
		{
			redirect("votaciones/parejas/".$concursos[0]->id);
		}
		$this->data["concursos"] = $concursos;
		$this->get_template('votaciones/index', $this->data);
	}

	public function parejas($concurso_id='')
	{
		$concurso_id = (empty($concurso_id))?get_session("concurso_id_see"):$concurso_id;
		if(!is_numeric($concurso_id))
		{
			show_error("Access failed");
		}
		set_session("concurso_id_see", $concurso_id);
		$this->load->library('facebook');
		$fb_logged = false;
		if($this->facebook->is_authenticated())
		{
			$user = $this->facebook->request('get', '/me?fields=id,name,email');
			set_session("user_fb", $user);
			$fb_logged = true;
		}
		$this->load->model("Concursos_model", "Concursos");
		$parejas = $this->set_porcentaje($concurso_id, TRUE);
		$concurso = $this->Concursos->get($concurso_id);
		$this->data["parejas"] = $parejas;
		$this->data["concurso"] = $concurso;
		$this->data["fb_api"] = TRUE;
		$this->data["fb_logged"] = $fb_logged;
		$pareja_id = get_session("vote_pareja_id");
		$this->data["has_pareja_selected"] = (!empty($pareja_id))?TRUE:FALSE;
		$this->get_template('votaciones/parejas', $this->data);
	}

	public function set_porcentaje($concurso_id, $return=FALSE)
	{
		$this->load->model("Parejas_model", "Parejas");
		$parejas = $this->Parejas->get_to_vote($concurso_id);
		$cant_votos = 0;
		foreach($parejas as $pareja)
		{
			$cant_votos+=$pareja->votos;
		}
		$set_cant_votos = ( $cant_votos<=0 )?1:$cant_votos;
		foreach($parejas as $pareja)
		{
			$cal_porcentaje=($pareja->votos*100/$set_cant_votos);
			$porcentaje = round($cal_porcentaje, 0);
			$pareja->porcentaje = $porcentaje;
		}
		if($return)
		{
			return $parejas;
		}else{
			echo json_encode($parejas);
		}
	}

	public function votar($pareja_id)
	{
		$this->load->model("Parejas_model", "Parejas");
		$pareja = $this->Parejas->get($pareja_id);
		$this->load->model("Concursos_model", "Concursos");
		$concurso = $this->Concursos->get($pareja->concurso_id);
		$pareja->foto = (!empty($pareja->foto))?$pareja->foto:"pareja.jpg";
		$graph = (object)array(
			"title" => $concurso->nombre." - ".$pareja->nombre,
			"image" => base_url("assets/files/".$pareja->foto),
			"url" => base_url("votaciones/votar/".$pareja_id)
		);
		$this->data["graph"] = $graph;
		$this->data["fb_api"] = TRUE;
		$this->data["pareja"] = $pareja;
		$this->get_template("votaciones/votar", $this->data);
	}

	public function concurso_in_time($concurso_id, $return = false)
	{
		$this->load->model("Concursos_model", "Concursos");
		$concurso = $this->Concursos->get($concurso_id);
		$today = date("Y-m-d H:i:s");
		$result = ($today>=$concurso->fecha_ini_votacion && $today<=$concurso->fecha_fin_votacion)?1:0;
		if(!$return)
		{
			echo $result;			
		}else{
			return $result;
		}
	}

	public function vote()
	{
		if($this->input->is_ajax_request() && $this->input->method(TRUE)=='POST')
		{
			$this->load->library('facebook');
			$response = array("result"=>false, "msg"=>"", "fb_logged"=>1); 

			$pareja_id = $this->input->post("pareja_id");
			$pareja_id = ($pareja_id == -1) ? get_session("vote_pareja_id") : $pareja_id;
			$this->load->model("Parejas_model", "Parejas");
      		$pareja = $this->Parejas->get($pareja_id);
      		$in_time = $this->concurso_in_time($pareja->concurso_id, true);
      		if(!$in_time)
      		{
      			$response["msg"] = "Ya paso las fecha de votación en el concurso";
      		}else{
				if(!$this->facebook->is_authenticated())
				{
					set_session("vote_pareja_id", $pareja_id);
					$response["fb_logged"] = 0;
				}else{
					$user_fb = get_session("user_fb");
					$fb_id = $user_fb["id"];
					$voted = $this->Votaciones->already_voted($fb_id, $pareja_id);
					set_session("vote_pareja_id", "");
					if($voted)
					{
      					$response["msg"] = "Usted ya a seleccionado su pareja favorita, ya no puede hacer mas votaciones";
					}else{
						$today = date("Y-m-d H:i:s");
						$data_insert = array(
							"id" => "",
							"fb_id" => $fb_id,
							"pareja_id" => $pareja_id,
							"datos_fb" => json_encode($user_fb),
							"fecha" => $today
						);
						$response = $this->Votaciones->save($data_insert);
						$parejas = $this->set_porcentaje($pareja->concurso_id, TRUE);
						$response["parejas"] = json_encode($parejas);
					}
				}

      		}
      		echo json_encode($response);
		}else{
			redirect("/");
		}
	}
}
