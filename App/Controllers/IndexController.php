<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {
 		$this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
		$this->render('index');
	}

	public function inscreverse() {
		$this->view->erroCadastro = false;
		$this->render('inscreverse');

		$this->view->usuario = array(
				'nome' => '',
				'email' => '',
				'senha' => ''
			);
	}

	public function registrar() {

		$usuario = Container::getModel('Usuario');

		$usuario->__set('nome', $_POST['nome']);
		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', md5($_POST['senha']));



		if ($usuario->validarCadastro() && count($usuario->getEmailUsuarioBD()) == 0) {
			
				$usuario->salvarDados();

				$this->render('cadastro');

		} else {

			$this->view->usuario = array(
				'nome' => $_POST['nome'],
				'email' => $_POST['email'],
				'senha' => $_POST['senha']
			);

			$this->view->erroCadastro = true;

			$this->render('inscreverse');
		}
	}
}


?>