<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$routes['venda'] = array(
			'route' => '/venda',
			'controller' => 'indexController',
			'action' => 'processarVenda'
		);
		
		$routes['venda_confirmada'] = array(
			'route' => '/venda_confirmada',
			'controller' => 'indexController',
			'action' => 'vendaConfirmada'
		);

		$routes['pesquisar_vendas'] = array(
			'route' => '/pesquisar_vendas',
			'controller' => 'PesquisaController',
			'action' => 'pesquisar_vendas'
		);

		$routes['pesquisa_bd'] = array(
			'route' => '/pesquisa_bd',
			'controller' => 'PesquisaController',
			'action' => 'retornar_vendas'
		);

		$routes['pesquisar_vendas_teste'] = array(
			'route' => '/pesquisar_vendas_teste',
			'controller' => 'PesquisaController',
			'action' => 'pesquisar_vendas_teste'
		);
				$this->setRoutes($routes);
	}

}

?>