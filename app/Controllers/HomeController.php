<?php
namespace App\Controllers;

use Pandora3\Core\Interfaces\ResponseInterface;
use Pandora3\Core\Controller\Controller;

class HomeController extends Controller {

	public function getRoutes(): array {
		return [
			'/' => 'index',
			'/about' => 'about',
		];
	}

	protected function index(): ResponseInterface {
		return $this->render('Index');
	}

	protected function about(): ResponseInterface {
		return $this->render('About');
	}

}