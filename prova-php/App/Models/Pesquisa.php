<?php

namespace App\Models;

use MF\Model\Model;

class Pesquisa extends Model {
	private $id;
	private $nome;
	private $preco;
    private $preco_venda;
	private $quantidade;
	private $Produtos_id;
	private $id_venda_nt;
	private $vendas_id;
    private $codigo;


	public function __get($atributo) {
		return $this->$atributo;
	}

	public function __set($atributo, $valor) {
		$this->$atributo = $valor;
	}

    public function retornar_produto(){
        $query = "select id from produtos 
                where codigo like :codigo";
		$stmt = $this->db->prepare($query);
		//$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
		$stmt->bindValue(':codigo', '%'.$this->__get('codigo').'%');
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function recuperar_produto(){
        $query = "select * from produtos 
                where id = :id";
		$stmt = $this->db->prepare($query);
		//$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function retornar_venda(){
        $query = "SELECT venda_item.id_venda_nt, venda_item.preco_venda, venda_item.Produtos_id, 
        vendass.total_venda, vendass.id, vendass.data 
        FROM venda_item LEFT JOIN vendass ON venda_item.id_venda_nt = vendass.id 
        WHERE venda_item.Produtos_id = :id;";
		$stmt = $this->db->prepare($query);
		//$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function retornar_venda_final(){
        $query = "SELECT venda_item.id_venda_nt, venda_item.preco_venda, venda_item.Produtos_id, vendass.total_venda, vendass.id, vendass.data, endereco.CEP, endereco.UF, endereco.cidade, endereco.bairro, endereco.rua,
		produtos.nome, fornecedores.nome_fornecedor
        FROM venda_item 
        LEFT JOIN vendass ON venda_item.id_venda_nt = vendass.id 
        LEFT JOIN endereco ON venda_item.id_venda_nt = endereco.id 
		LEFT JOIN produtos ON venda_item.Produtos_id = produtos.id
		LEFT JOIN fornecedores ON venda_item.Produtos_id = fornecedores.id  
        WHERE venda_item.id_venda_nt = :id;";
		$stmt = $this->db->prepare($query);
		//$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}
/*
SELECT venda_item.id_venda_nt, venda_item.preco_venda, venda_item.Produtos_id, vendass.total_venda, vendass.id, vendass.data
		FROM vendass 
		LEFT JOIN venda_item ON vendass.id = venda_item.id_venda_nt
		WHERE vendass.id = :id;
        
        
        endereco.CEP, endereco.UF, endereco.cidade, endereco.bairro, endereco.rua,*/