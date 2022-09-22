<?php 

namespace App\Models;

use MF\Model\Model;

class Seguidores extends Model{
	
	private $id;
	private $id_usuario;
	private $id_usuario_seguindo;

	public function __get($atributo){
		return $this->$atributo;
	}
 
	public function __set($atributo, $value){
		 $this->$atributo = $value;
	}

	public function seguirUsuario($id_usuario_seguindo){
		$query = "insert into usuarios_seguir(id_usuario, id_usuario_seguindo)values(:id_usuario, :id_usuario_seguindo) ";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
		$stmt->bindValue(':id_usuario_seguindo', $id_usuario_seguindo);
		$stmt->execute();

		return true;
	}

	public function deixarSeguirUsuario($id_usuario_seguindo){
		$query = "delete from usuarios_seguir where id_usuario = :id_usuario and id_usuario_seguindo = :id_usuario_seguindo";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
		$stmt->bindValue(':id_usuario_seguindo', $id_usuario_seguindo);
		$stmt->execute();

		return true;
	}

	public function qtdSeguidores() {
		$query = "select count(*) as total_seguidores from usuarios_seguir where id_usuario = :id_usuario";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function qtdSeguindo() {
		$query = "select count(*) as total_seguindo from usuarios_seguir where id_usuario_seguindo = :id_usuario_seguindo";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario_seguindo', $this->__get('id_usuario'));
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function qtdTweets() {
		$query = "select count(*) as total_tweets from tweets where id_usuario = :id_usuario";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
}