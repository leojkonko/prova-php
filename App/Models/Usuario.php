<?php 

namespace App\Models;

use MF\Model\Model;

class Usuario extends Model{
	
	private $id;
	private $nome;
	private $email;
	private $senha;

	public function __get($atributo){
		return $this->$atributo;
	}

	public function __set($atributo, $value){
		 $this->$atributo = $value;
	}

	//salvar
	public function salvarDados(){
		$query = "insert into usuarios(nome, email, senha) values(:nome, :email, :senha)";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':nome', $this->__get('nome'));
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->bindValue(':senha', $this->__get('senha'));	
		$stmt->execute();

		return $this;
	}

	//validar se os dados são ok
	public function validarcadastro() {
		$valido = true;

		if (strlen($this->__get('nome')) < 3){
			$valido = false;
		}

		if (strlen($this->__get('email')) < 5){
			$valido = false;
		}

		if (strlen($this->__get('senha')) < 4){
			$valido = false;
		}

		return $valido;

	}

	//recuperar um usuário por email
	public function getEmailUsuarioBD() {
		$query = "select nome, email from usuarios where email = :email";

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	//consulta no banco para autenticar o usuario
	public function autenticar() {
		$query = "select id, nome, email from usuarios where email = :email and senha = :senha";

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->bindValue(':senha', $this->__get('senha'));
		$stmt->execute();

		$usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

		if ($usuario['id'] != '' && $usuario['nome'] != ''){
			$this->__set('id', $usuario['id']);
			$this->__set('nome', $usuario['nome']);
		}

		return $this;
	}

	public function getAll() {
		$query = "
		select 
			u.id, u.nome, u.email,
			(
				select 
					count(*)
				from
					usuarios_seguir as us 
				where
					us.id_usuario = :id_usuario and us.id_usuario_seguindo = u.id

			) as seguindo_sn 
		from 
			usuarios as u
		where 
			u.nome like :nome and u.id != :id_usuario";

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':nome', '%'.$this->__get('nome').'%');
		$stmt->bindValue(':id_usuario', $this->__get('id'));
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
}