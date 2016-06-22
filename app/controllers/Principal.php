<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* Index de Hydra Apps 
	*/
	class Principal extends Base_Controller{
		public function index(){
			
			$data['nosotros']	= URLPATH.'nosotros';
			$data['portafolio']	= URLPATH.'portafolio';
			$data['servicios']	= URLPATH.'servicios';
			$data['contacto']	= URLPATH.'contacto';
			$this->load_view_unique('principal',$data);
		}

		public function buildNosotros(){
			$this->load_view_unique('nosotros');
		}

		public function buildPortafolio(){
			$this->load_view_unique('portafolio');
		}

		public function buildServicios(){
			$this->load_view_unique('servicios');
		}

		public function buildContacto(){
			$this->load_view_unique('contacto');
		}
	}

