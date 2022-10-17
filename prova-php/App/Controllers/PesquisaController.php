<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;
use App\Connection;
use App\Models\Produtos;

class PesquisaController extends Action {

	public function pesquisar_vendas() {
		$this->render('pesquisa');
	} 

	public function retornar_vendas(){
		$pesquisa = Container::getModel('Pesquisa');
		//if ($_POST != ''){}
		$pesquisa->__set('codigo', $_POST['codigo']);
		$retorno = $pesquisa->retornar_produto();
		$this->verificar_vendas($retorno);
	}

	public function recuperar_produto($id){
		$pesquisa = Container::getModel('Pesquisa');
		//parei aqui -> recuperar produtos com id do parametro
		//*---------------------------------------------------------------------------------
		foreach($id as $idd => $produto) {
		$pesquisa->__set('id', $id['id']);
		$retorno = $pesquisa->recuperar_produto();
		$this->view->retorno_produtos = $retorno;
		}
		
	}

	public function verificar_vendas($id){
		$pesquisa = Container::getModel('Pesquisa');
		$num = 0;
		$text = "id";
		$array = array();

		foreach($id as $idd => $produto) {
		$this->recuperar_produto($produto);
		$pesquisa->__set('id', $produto['id']);
		
		$retorno = $pesquisa->retornar_venda();  
		foreach($retorno as $iddd => $retorno_fe) {

		array_push($array, $retorno_fe['id_venda_nt']);

		}}
		
		$array_rd = array_unique($array);
		//print_r($array_rd);
		$this->retorno_vendas_final($array_rd);
	}

	public function retorno_vendas_final($array){
		
		$pesquisa = Container::getModel('Pesquisa');

		$arrayy = array();
		foreach($array as $iddd => $array_retorno) {

			$pesquisa->__set('id', $array_retorno);
			$retorno = $pesquisa->retornar_venda_final();
			
			array_push($arrayy, $retorno);			
		}

		$this->pesquisar_vendas_teste($arrayy);
	
		
}

	public function pesquisar_vendas_teste($array) {
		$this->view->retorno_vendas12 = $array;

		$this->render('pesquisa');

		
	}
}
?>