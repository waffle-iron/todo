<?php
class Persona_model extends CI_Model {

	/**
	 * Variables para los stored procedures usados por el modelo
	 */
	private $sp_consulta 	= 'call persona_consulta(?)';
	private $sp_alta 		= 'call persona_alta(?, ?, ?, ?)';
	private $sp_editar 		= 'call persona_editar(?, ?, ?, ?)';
	private $sp_baja 		= 'call persona_baja(?)';
	
	/**
	 * Variables para los atributos del modelo
	 */
	public $cuil;
	public $nombre;
	public $apellido;
	public $mail;
	
	public function __construct()
	{
		$this->load->database();
	}
	
	/**
	 * Consulta de persona
	 * Consulta personas por cuil o devuelve toda la tabla
	 * @param 		string 		$cuil
	 * @return 		mixed 		object|array Devuelve un objeto Persona si se consulta por un CUIL, sino devuelve un array
	 */
	public function consulta($cuil=NULL)
	{
		$query = $this->db->query($this->sp_consulta, array('cuil' => $cuil));
		if($cuil)
		{
			if ($query->num_rows() > 0) {
				$row=$query->row_array();
				$this->cuil=$row["CUIL"];
				$this->nombre=$row["Nombre"];
				$this->apellido=$row["Apellido"];
				$this->mail=$row["Mail"];
			}
			return $this;
		}
		else
		{
			return $query->result_array();
		}
	}
	
	/**
	 * Alta de persona
	 * @return 		array Devuelve un array con la la clave 'resultado', OK en caso de alta exitosa y sino ERROR
	 */
	public function alta()
	{	
		if($this->db->query($this->sp_alta, 
				array(
						'cuil' 		=> $this->input->post('cuil'), 
						'Nombre' 	=> $this->input->post('nombre'), 
						'Apellido' 	=> $this->input->post('apellido'), 
						'Mail' 		=> $this->input->post('mail')))
				)
			$resultado['resultado']='OK';
		else
			$resultado['resultado']='ERROR';
		return $resultado;
	}
	
	/**
	 * Edicion de persona
	 * @return 		array Devuelve un array con la la clave 'resultado', OK en caso de alta exitosa y sino ERROR
	 */
	public function editar()
	{
		if($this->db->query($this->sp_editar, 
				array(
						'cuil' 		=> $this->input->post('cuil'), 
						'Nombre' 	=> $this->input->post('nombre'), 
						'Apellido' 	=> $this->input->post('apellido'), 
						'Mail' 		=> $this->input->post('mail')))
				)
			$resultado['resultado']='OK';
		else
			$resultado['resultado']='ERROR';
		return $resultado;
	}
	
	/**
	 * Baja de persona
	 * @return 		array Devuelve un array con la la clave 'resultado', OK en caso de alta exitosa y sino ERROR
	 */
	public function baja($cuil = FALSE)
	{
		if($query = $this->db->query($this->sp_baja, array('cuil' => $cuil)))
			$resultado['resultado']='OK';
		else
			$resultado['resultado']='ERROR';
		return $resultado;
	}
}