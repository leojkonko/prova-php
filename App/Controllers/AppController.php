<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {

	public function logout() {
		session_destroy();
		header('location: /');
	}

	public function timeline(){
		session_start();

		$this->validaAutenticacao();

			//recuperação dos tweets
			$tweet = Container::getModel('Tweet');
			$tweet->__set('id_usuario', $_SESSION['id']);
			$tweets = $tweet->getAll(); 
			
			$this->view->tweets = $tweets;

			$info = Container:: getModel('Seguidores');
			$info->__set('id_usuario', $_SESSION['id']); 
			//$info->__set('id_usuario_seguindo', $_SESSION['id']); 
			$this->view->total_tweets = $info->qtdTweets();
			$this->view->qtdSeguindo = $info->qtdSeguindo();
			$this->view->qtdSeguidores = $info->qtdSeguidores();


			$this->render('timeline');

	}

	public function tweet() {

		session_start();

	$this->validaAutenticacao();

			$tweet = Container::getModel('Tweet');

			$tweet->__set('tweet', $_POST['tweet']);
			$tweet->__set('id_usuario', $_SESSION['id']);

			$tweet->salvar();

			header('location: /timeline');
	}

	public function validaAutenticacao(){
		session_start();

		if (!isset($_SESSION['id']) || $_SESSION['id'] != '' || !isset($_SESSION['nome']) || $_SESSION['nome'] != '') {
				return true;
		} else {
			header('location: /?login=erro');
		}

	}

	public function quem_seguir(){
		//
		$this->validaAutenticacao();

	 	$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';

	 	$usuarios = array();

	 	 if ($pesquisarPor != ''){

	 	 	$usuario = Container::getModel('Usuario');
	 	 	$usuario->__set('nome', $pesquisarPor);
	 	 	$usuario->__set('id', $_SESSION['id']);
	 	 	$usuarios = $usuario->getAll();
	 	 	
	 	 	//print_r($usuarios);
	 	}

	 	 $this->view->usuarios = $usuarios;

	 	 $info = Container:: getModel('Seguidores');
			$info->__set('id_usuario', $_SESSION['id']); 
			//$info->__set('id_usuario_seguindo', $_SESSION['id']); 
			$this->view->total_tweets = $info->qtdTweets();
			$this->view->qtdSeguindo = $info->qtdSeguindo();
			$this->view->qtdSeguidores = $info->qtdSeguidores();

	 	 $this->render('/quem_seguir');
	}

	public function acao() {

		$this->validaAutenticacao();

		$acao = isset($_GET['acao']) ? $_GET['acao'] : '';
		$id_usuario_seguindo = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';

		$usuario = Container::getModel('Seguidores');
		$usuario->__set('id_usuario', $_SESSION['id']);

		
		if ($acao == 'seguir') {

			$usuario->seguirUsuario($id_usuario_seguindo);
			//header('location: /quem_seguir');

		} else if ($acao == 'unfollow') {

			$usuario->deixarSeguirUsuario($id_usuario_seguindo);
			
		}
		header('location: /quem_seguir');
	}

	public function removerTweet() {

		$this->validaAutenticacao();

		 $usuario = Container::getModel('Tweet');
	 	 $usuario->__set('id_usuario', $_SESSION['id']);
	 	 $usuario->__set('id', $_GET['id_tweet']);
	 	 $usuario->excluirTweet();	
	 	 
	 	 header('location: /timeline');
	}


}