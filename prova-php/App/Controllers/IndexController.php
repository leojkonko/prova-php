<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;
use App\Connection;
use App\Models\Produtos;

class IndexController extends Action {

	public function index() {
		$produtos = Container::getModel('Produtos');
		$retorno = $produtos->recuperarProdutos();
		$this->view->produtos = $retorno;		
		$this->render('index');
	}

	public function processarVenda() {
		if(!isset($_POST['id2'])){
			if(!isset($_POST['id3'])){
				if(!isset($_POST['id4'])){
					if(!isset($_POST['id5'])){
						header('location: /?errorProduto');
					}
				}
			}
		}		
		if($_POST['uf'] == "" || $_POST['uf'] == " " || $_POST['uf'] == 'undefined'){
			header('location: /?errorCep');
		}
		$this->view->vendaCompleta = $_POST;
		$produtos = Container::getModel('Produtos');
		$idd = 0;
		$iddd = 'id';
		$count = count($_POST);
		$array = array();
		$array_preco = array();
		while($idd <= $count){
			
			$idd++;
			if(isset($_POST[$iddd . $idd])) {
				
			$produtos->__set('id', $_POST[$iddd . $idd]);
			$retorno = $produtos->recuperarProdutosCarrinho();
			$this->view->produtos_completos = $retorno;
				
			foreach($retorno as $id_produto => $produto) {
				
				array_push($array_preco, $produto['preco']);
				
			array_push($array, $produto);
			$this->view->produtos_completos = $array;}
			
		}
		
		}
		//print_r($array_preco);
		//echo "soma(a) = ".array_sum($array_preco);
		$this->view->venda = $array_preco;
		$this->render('venda');
		//$this->recuperar_fornecedor();		
	}

	

	public function recuperar_fornecedor(){
		$produtos = Container::getModel('Produtos');
		$idd = 0;
		$iddd = 'id';
		$count = count($_POST);
		$array = array();
		//$array_preco = array();
		while($idd <= $count){
			//print_r($_POST[$iddd . $idd]);
			$idd++;
			if(isset($_POST[$iddd . $idd])) {
				
			$produtos->__set('id', $_POST[$iddd . $idd]);
			//$retorno = $produtos->recuperarProdutosCarrinho();
			$retorno_fornecedor = $produtos->recuperarFornecedor();
				
			foreach($retorno_fornecedor as $id_produto => $produto) {

			array_push($array, $produto['nome']);		
			
			$this->view->fornecedores = $array;}}		
		}
		$this->render('venda');
	}

	//1
	public function vendaConfirmada(){
		
		$this->insertVendass();
		$this->insertEndereco();
		$id_venda_nt = 0;
		$produtos = Container::getModel('Produtos');
		$retorno = $produtos->consultarIVNT();

		echo "<pre>";
		//print_r($retorno[0]);
		echo "</pre>";
		$id_venda_nt = $retorno[0];
		$id_venda_nt = implode(" ", $id_venda_nt);
		//echo $id_venda_nt;
		//$id_venda_nt = $id_venda_nt;
		$this->insertVendaItem($id_venda_nt);
	}

	public function insertEndereco(){
		$produtos = Container::getModel('Produtos');
		echo "<pre>";
		print_r($_POST);
		echo "<pre>";
		$produtos->__set('cep', $_POST['cep']);
		$produtos->__set('bairro', $_POST['bairro']);
		$produtos->__set('cidade', $_POST['cidade']);
		$produtos->__set('rua', $_POST['rua']);
		$produtos->__set('uf', $_POST['uf']);
		$produtos->insertEndereco();
	}

	public function insertVendass(){
		$produtos = Container::getModel('Produtos');
		echo "<pre>";
		print_r($_POST);
		echo "<pre>";
		$produtos->__set('total_venda', $_POST['venda_total']);
		$produtos->insertVenda();
	}

	public function insertVendaItem($id_venda_nt){
		$id_venda_nt++;
		//echo ($id_venda_nt. "oii");
		$produtos = Container::getModel('Produtos');

		echo "<pre>";
		//print_r($produtos);
		echo "</pre>";
		$idd = '0';
		$i = '0';
		$preco = 'preco';
		$iddd = 'id';
		$qtd_ids = array();

		foreach($_POST as $id_produto => $produto) { 
			$i++;
			if (isset($_POST[$iddd . $i])){
			/*echo "<pre>";
			//print_r($_POST[$iddd . $i]);
			echo "</pre>";*/
			
			$idd++;
			if (isset($_POST[$preco . $idd])){
				echo "<pre>";
				//print_r($_POST);
				echo "</pre>";
			
			$produtos->__set('preco_venda', $_POST[$preco . $idd]);
			$produtos->__set('Produtos_id', $_POST[$iddd . $i]);
			echo $id_venda_nt;
			//$id_venda_nt++;
			$produtos->__set('id_venda_nt', $id_venda_nt);
			$produtos->insertVendaItens();
			
		}}		
	}

	header('location: /');
		
	}
}
?>