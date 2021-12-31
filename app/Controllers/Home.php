<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;

class Home extends BaseController
{
	use ResponseTrait;
	
	public function index()
	{
		return view('welcome_message');
	}

	public function home()
	{
		return view('home');
	}

	/**
	 * [api rest marvel access return array]
	 * @return array colaborators
	 */
	public function colaborators($person)
	{
		return view('home');
	}
}
