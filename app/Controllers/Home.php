<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;
use CodeIgniter\I18n\Time;

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
		//$data['title'] = 'Personaje - '.$person;
		$char = $person == 'ironman'?1009368: ($person=='capamerica'?1009220: 0);
		//return view('home', $data);
		$baseUrl 	= 'https://gateway.marvel.com:443/v1/public/characters/';
		$apiKey 	= '6810f9d29ae71c4ca417e027d73f4949';
		$privateKey = '290c908b436c25f243a429801092a1b0fd01445e';
		$limit 		= '100';
		/*$date 		= new DateTime();
		$ts 		= $date->getTimestamp();*/
		$ts 		= 1929929;
		$hash 		= md5($ts.$privateKey.$apiKey);
		
		$comics = json_decode(file_get_contents("https://gateway.marvel.com:443/v1/public/characters/".$char."/comics?format=comic&formatType=comic&ts=".$ts."&apikey=".$apiKey."&hash=".$hash), true );

				
		//$data['Editors'] = "";
		//$data['Writers'] = "";
		if ($comics['data']['results']) {
			foreach ($comics['data']['results'] as $creator) {
				foreach ($creator['creators']['items'] as $item) {
					if($item['role']=='editor'){
						$data['Editors'][] = $item['name'];
					}
				}
			}
			foreach ($comics['data']['results'] as $creator) {
				foreach ($creator['creators']['items'] as $item) {
					if($item['role']=='writer'){
						$data['Writers'][] = $item['name'];
					}
				}
			}
		}
		
		if($data){
			return $this->respond($data);
		}else{
			return $this->failNotFound('Información no enconrada '.$id);
		}
	
	}
}
