<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estadisticas extends MY_Controller {
	public function index($concurso_id)
	{
		$user = $this->ion_auth->user()->row();
		if($user->rol_active != ADMIN)
		{	
			create_flash_message("Acceso denegado", "danger");
			redirect("concursos", "refresh");
		}
		$this->load->model("Parejas_model", "Parejas");
		$this->load->model("Votaciones_model", "Votaciones");
		$integrantes = $this->Parejas->get_to_statistic($concurso_id);
		$parejas = array();
		$pareja_id = "";
		$cant_votos = 0;
		foreach($integrantes as $integrante)
		{
			if($pareja_id != $integrante->pareja_id)
			{
				$pareja_id = $integrante->pareja_id;
				$votos = $this->Votaciones->get_votos_by_pareja($pareja_id);
				$parejas[] = (object)array(
					"pareja_id" => $pareja_id,
					"nombre" => $integrante->pareja,
					"integrantes" => "",
					"votos" => $votos,
					"porcentaje" => ''
				);
				$index_parejas = count($parejas)-1;
				$cant_votos += $votos;
			}
			$parejas[$index_parejas]->integrantes .= $integrante->nombre."<br>";
		}
		$set_cant_votos = ( $cant_votos<=0 )?1:$cant_votos;
		foreach($parejas as $pareja)
		{
			$pareja->porcentaje = ($pareja->votos*100)/$set_cant_votos;
		}
		$this->data["parejas"] = $parejas;
		$this->load->model("Concursos_model", "Concursos");
		$concurso = $this->Concursos->get($concurso_id);
		$this->data["concurso"] = $concurso;
		$this->get_template("estadisticas/index", $this->data);
	}
}
