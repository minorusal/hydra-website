<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Base_Controller extends CI_Controller {
    public function __construct(){
        parent::__construct();       
    }
    /**
    * Carga la base de datos de acuerdo al pais de origen
    * del usuario (mx,cr,etc)
    * @param string $db
    * @return void
    */
    public function load_database($bd){
    	if($bd!=""){
    		$load = $this->load->database($bd,TRUE);
	    	if(!$load){
	    		return true;
	    	}
    	}
    }

    /**
	* Finalizar la sesion activa
	* @return void
	*/
	public function logout($redirect = true, $page='login'){
		$this->load_database('global_system');
		$this->session->sess_destroy();
		if($redirect){
			redirect($page);	
		}
	}

    /**
    * unifica las vistas header & footer con las vistas parseadas
    * de la seccion seleccionada
    * @param string $view
    * @param array $data
    * @param array $data_includes
    * @param string $ext
    * @return void
    */
    public function load_dashboard($view, $data = array(), $data_includes = array() ,$ext = '.html'){
		$ext          = ($ext!='.html') ? '': $ext;
		$uri          = $this->uri->segment_array();
		//$includes     = $this->load_scripts($data_includes);
		//$data_modulos = $this->sites_panel;
		//$img_path     = './assets/avatar/users/';
		//$img_path_    = base_url().'assets/avatar/users/';
		//$avatar_image = ($this->session->userdata('avatar_user') =='' ) ? 'sin_foto.png' : $this->session->userdata('avatar_user');
		//$icon_root    = ($this->root_available()) ? 'fa fa-user-secret' : '';
		//$dataheader['site_title'] 	  = $this->vars->cfg['site_title'];
		//$dataheader['data_js']        = (!empty($includes)) ? $includes['js']  : '';
		//$dataheader['data_css']       = (!empty($includes)) ? $includes['css'] : '';
		//$dataheader['base_url']       = base_url();
		//$dataheader['panel_navigate'] = $this->sites_panel;
		//$dataheader['avatar_user']    = (file_exists($img_path.$avatar_image))? $img_path_.$avatar_image : $img_path_.'sin_foto.png';
		//$dataheader['avatar_pais']    = $this->session->userdata('avatar_pais');
		//$dataheader['user_mail']      = $this->session->userdata('mail');
		//$dataheader['user_name']      = $this->session->userdata('name');
		//$dataheader['user_perfil']    = $this->session->userdata('perfil');
		//$dataheader['close_session']  = $this->lang_item('close_session');
		//$dataheader['date']           = $this->lang_item('edit_perfil');
		//$dataheader['icon_root']      = $icon_root;
		//$dataheader['date']           = date('d/m/Y');
		//$dataheader['fecha_hoy']	  = $this->timestamp_complete();
		//$uri_nav                      = $this->array2string_lang(explode('/', $this->uri->uri_string()),array("navigate","es_ES"),' » ');
		//$dataheader['uri_string']     = $uri_nav;
		$datafooter                   = array('anio' => date('Y'));
		$data = (empty($data)) ? array() : $data;
		$data['RESOURCESPATH'] = RESOURCESPATH;
		//$data['base_url']=$dataheader['base_url'];
		//$this->parser->parse('dashboard/header.html', $dataheader);
		$this->parser->parse($view.$ext, $data);
		//$this->parser->parse('dashboard/footer.html', $datafooter); 
	}



	/**

    * Carga una vista unica sin integrar el header 

    * ni el footer, puede servir para la carga de 

    * paginas de error

    * @param string $view

    * @param array $data

    * @param boolean $autoload

    * @param array $data_includes

    * @param string $ext

    * @return void

    */

	public function load_view_unique($view, $data = array(), $autoload = false ,$ext = '.html'){
		$data['RESOURCESPATH'] = RESOURCESPATH;
		return $this->parser->parse($view.$ext, $data, $autoload);

	}





	/**

	* convierte un objeto a un arreglo

	* @param object $obj

	* @return array

	*/

	public function object_to_array($obj){

		$reaged = (array)$obj;

		foreach($reaged as $key => &$field){

			if(is_object($field))

				$field = $this->object_to_array($field);

		}

		return $reaged;

	}



	/**

	* elimina el cache almacenado

	* @return void

	*/

	public function removeCache(){

        $this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');

        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');

        $this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);

        $this->output->set_header('Pragma: no-cache');

    }



    /**

    * Devuleve la cantidad de segmentos contenidos en la URL

    * contabilizando a partir del dominio

    * Ejemplo http://domain.com/sitio/pagina/3

    * el valor devuleto sera 4

    * @return int

    */

    public function uri_segment(){

    	return $this->uri->total_segments();

    }



    /**

    * Devuleve el ultimo segmentos contenido en la URL

    * @return int

    */

    public function uri_segment_end($prev = 0){

    	return $this->uri->segment($this->uri->total_segments()-$prev);

    }



    /**

    * Devuleve la URL actual

    * @return string

    */

    public function uri_string(){

    	return $this->uri->uri_string();

    }



    /**

    * Si $post es false devuleve un arreglo con el total de items 

    * recibidos por el metodo POST[]

    * de lo contrario devolvera el item con respecto al index $post

    * @param int $post

    * @return array

    */

    public function request_post($post = false){

    	if($post===false){

    		return $this->input->post();

    	}

    	return $this->input->post($post);

    }





    /**

    * Si $get es false devuleve un arreglo con el total de items 

    * recibidos por el metodo GET[]

    * de lo contrario devolvera el item con respecto al index $get

    * @param int $get

    * @return array

    */

    public function request_get($get = false){

    	if($get===false){

    		return $this->input->get();

    	}

    	return $this->input->get($get);

    }



    /**

    * devuleve el tiempo unix actual

    * @return string

    */

    public function timestamp(){

    	return date('Y-m-d H:i:s');

    }

   

    /**

    * Devuelve el item del dia con respecto al indice $index

    * @param int $index

    */

    public function days_item($index){

    	$day = $this->get_days();

		return $day[$index];

    }

    /**

    * Devuelve un array con los dias de la semana

    * @param array

    */

    public function get_days(){

		$days[0]= $this->lang_item('domingo',false);

		$days[1]= $this->lang_item('lunes',false);

		$days[2]= $this->lang_item('martes',false);

		$days[3]= $this->lang_item('miercoles',false);

		$days[4]= $this->lang_item('jueves',false);

		$days[5]= $this->lang_item('viernes',false);

		$days[6]= $this->lang_item('sabado',false);

		

		return $days;

    }

    /**

    * Devuelve el item del mes con respecto al indice $index,

    * si el $index no se define devolvera un array con todos los meses

    * @param int $index

    * @return array

    */

    public function get_months($index = false){

		$months[0]  = $this->lang_item('enero', false);

		$months[1]  = $this->lang_item('febrero', false);

		$months[2]  = $this->lang_item('marzo', false);

		$months[3]  = $this->lang_item('abril', false);

		$months[4]  = $this->lang_item('mayo', false);

		$months[5]  = $this->lang_item('junio', false);

		$months[6]  = $this->lang_item('julio', false);

		$months[7]  = $this->lang_item('agosto', false);

		$months[8]  = $this->lang_item('septiembre', false);

		$months[9]  = $this->lang_item('octubre', false);

		$months[10] = $this->lang_item('noviembre', false);

		$months[11] = $this->lang_item('diciembre', false);



		if($index){

			return $months[ltrim($index,'0')];

		}

		return $months;

    }





    /**

    * Devuelve el item de idioma con respecto al indice $index

    * @param int $index

    * @return string

    */



    public function lang_item($index, $format = false){

    	$index = strtolower(str_replace('lang_', '', trim($index)));

    	$lang_item = ($this->lang->line($index)) ? $this->lang->line($index) : 'lang_'.$index;

    	

    	if($format==true){

    		$lang_item = text_format_tpl($lang_item);

    	}

    	return $lang_item;

    }



    /**

    * carga el archivo Lang de idioma

    * @param string $name

    * @param string $lang

    * @return void

    */



    public function lang_load($name, $lang = "es_ES"){

    	$this->lang->load(trim($name,'/'),$lang);

    }

    

    /**

    * convierte un arreglo a su respectivo item lang

    * @param array $input

    * @param string $lang_

    * @param string $separator

    * @return string

    */



	public function array2string_lang($input = array(), $lang_ =array(), $separator = " "){

		$string = "";

		$land_load = (empty($lang_)) ? false : $this->lang_load($lang_[0],$lang_[1]);

		foreach ($input as $item) {

			$lang_item = $this->lang_item($item);

			$string    =  $string . $separator . $lang_item;

		}

		return trim($string, $separator);

	}



	/**

    * Devuelve la variable de session con respecto al indice $index

    * @param int $index

    * @return string

    */

	public function item_session($index){

		return $this->session->userdata($index);

	}





	/**

	* Devuelve la cadena encryptada

	* @param string $string

	* @param bool $key

	* @return string

	*/

	public function encrypting_string($string = '', $key = false){

		if($key){

			return base64_encode( $this->encrypt->encode($string, $key) );

		}else{

			return base64_encode( $this->encrypt->encode($string) );

		}

		

	}



	/**

	* Devuelve la cadena desencryptada

	* @param string $string

	* @param bool $key

	* @return string

	*/

	public function decrypting_string($string = '', $key = false){

		if($key){

			return base64_decode( $this->encrypt->decode($string, $key) );

		}else{

			return base64_decode( $this->encrypt->decode($string) );

		}

	}



	/**

	* Genera un token 

	* @param int $length

	* @param bool $encrypt

	* @param string $key

	* @return string

	*/

	public function generate_token($length = 15, $encrypt = true , $key = ''){

		$key_encrypt = ($key) ? $key : '';



		$settings = array(

							'upercase'  => true,

							'lowercase' => true,

							'int'       => true, 

							'symbol'    => true

						);



		$token =  ($encrypt) ? $this->encrypt_encode($this->random_string($length, $settings, $key_encrypt)) : $this->random_string($length,$settings, $key_encrypt);

		

		return $token;

	}



	/**

	* Genera un string con caracteres aleatorios dependiendo de la configuraciion 

	* @param int $length

	* @param array $settings

	* @param string $key

	* @return string

	*/

	public function random_string($length = 10, $settings = array(),  $key = ''){

		if(empty($settings)){

			return false;

		}

	    $characters  = '';

	    $characters .= ($key!='') ? $key : '';

	    $characters .= (array_key_exists('upercase', $settings))  ?  ($settings['upercase'])  ? 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' : '' : '';

	    $characters .= (array_key_exists('lowercase', $settings)) ?  ($settings['lowercase']) ? 'abcdefghijklmnopqrstuvwxyz' : '' : '';

	    $characters .= (array_key_exists('int', $settings))       ?  ($settings['int'])       ? '1234567890'                 : '' : '';

	    $characters .= (array_key_exists('symbol', $settings))    ?  ($settings['symbol'])    ? '|@#$%()=+[]{}-_'  : '' : '';

	    

	    $charactersLength = strlen($characters);

	    $randomString = '';

	    for ($i = 0; $i < $length; $i++) {

	        $randomString .= $characters[rand(0, $charactersLength - 1)];

	    }

	    return $randomString;

	}





	/**

	* Valida una direccion de correo electronico

	* @param string $mail

	* @return boolean

	*/

	public function validate_email($mail){

	   	$exp ='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';

	   	if(preg_match($exp, $mail)){

	     	return true;

	   	}

	   	else{

	    	return false;

	   	}

	}



	public function json_error($params){

		echo json_encode( array ('success' => false, 'error' => $params ) );

	}



	public function json_success($params){

	

		echo json_encode( array ('success' => true, 'response' => $params ) );

	}



	public function url_exists($url){

		$h = get_headers($url);

		$status = array();

		preg_match('/HTTP\/.* ([0-9]+) .*/', $h[0] , $status);

		return ($status[1] == 200);

	}

}

?>