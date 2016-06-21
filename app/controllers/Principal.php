<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	* Index de Hydra Apps 
	*/
	class Principal extends Base_Controller
	{
		public function index(){
			$this->load_view_unique('principal');
		}
	}
