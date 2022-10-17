<?php

namespace App\Models;

use MF\Model\Model;

class Produtos extends Model {
	private $id;
	private $nome;
	private $preco;
	private $codigo;
	private $cep;
	private $bairro;
	private $rua;
	private $uf;
	private $cidade;
	private $total_venda;
	private $preco_venda;
	private $quantidade;
	private $Produtos_id;
	private $id_venda_nt;
	private $vendas_id;



	public function __get($atributo) {
		return $this->$atributo;
	}

	public function __set($atributo, $valor) {
		$this->$atributo = $valor;
	}

    public function recuperarProdutos(){
       $query = "select * from produtos";
		$stmt = $this->db->prepare($query);
		//$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
		//$stmt->bindValue(':tweet', $this->__get('tweet'));
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		 
    } public function recuperarProdutosCarrinho(){
		$query = "SELECT produtos.nome, produtos.id, produtos.preco, produtos.codigo, fornecedores.nome_fornecedor
		FROM produtos 
		LEFT JOIN fornecedores ON produtos.id = fornecedores.id 
		WHERE produtos.id = :id;";
		//SELECT produtos.nome, fornecedores.nome FROM produtos LEFT JOIN fornecedores ON produtos.id = fornecedores.id WHERE produtos.id = 1;
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function recuperarFornecedor(){
		//$query = "select * from produtos where id = :id";
		$query = "
		SELECT 
			produtos.nome, fornecedores.nome 
		FROM 
			produtos 
		LEFT JOIN 
			fornecedores ON produtos.id = fornecedores.id 
		WHERE
			produtos.id = :id";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function insertEndereco(){
		$query = "
		INSERT into endereco (CEP, UF, cidade, bairro, rua) VALUES (:cep, :uf, :cidade, :bairro, :rua)";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':cep', $this->__get('cep'));
		$stmt->bindValue(':uf', $this->__get('uf'));
		$stmt->bindValue(':cidade', $this->__get('cidade'));
		$stmt->bindValue(':bairro', $this->__get('bairro'));
		$stmt->bindValue(':rua', $this->__get('rua'));
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function insertVenda(){
		$query = "
		INSERT into vendass (total_venda) VALUES (:total_venda)";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':total_venda', $this->__get('total_venda'));
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function consultarIVNT(){
		$query = "SELECT id_venda_nt FROM venda_item ORDER by id_venda_nt DESC;";
		$stmt = $this->db->prepare($query);
		//$stmt->bindValue(':total_venda', $this->__get('total_venda'));
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	
	public function insertVendaItens(){
		$query = "
		INSERT into venda_item (preco_venda, Produtos_id, id_venda_nt) 
		VALUES (:preco_venda, :Produtos_id, :id_venda_nt)";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':preco_venda', $this->__get('preco_venda'));
		$stmt->bindValue(':Produtos_id', $this->__get('Produtos_id'));
		$stmt->bindValue(':id_venda_nt', $this->__get('id_venda_nt'));
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
}