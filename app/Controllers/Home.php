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
	 * [Método API REST para obtener los editores y escritores involucrados en los comics ya sea de iron man o cap merica]
	 * @param  string $person [ironman/capamerica]
	 * @return array $data
	 */
	public function colaborators($person)
	{
		$char = $person == 'ironman'?1009368: ($person=='capamerica'?1009220: 0);
		$baseUrl 	= 'https://gateway.marvel.com:443/v1/public/characters/';
		$apiKey 	= '6810f9d29ae71c4ca417e027d73f4949';
		$privateKey = '290c908b436c25f243a429801092a1b0fd01445e';
		$limit 		= '100';
		$ts 		= 1929929;
		$hash 		= md5($ts.$privateKey.$apiKey);
		$comics = json_decode(file_get_contents("https://gateway.marvel.com:443/v1/public/characters/".$char."/comics?format=comic&formatType=comic&ts=".$ts."&apikey=".$apiKey."&hash=".$hash), true );
		$data['Editors'] = array();
		$data['Writers'] = array();
		if ($comics['data']['results']) {
			foreach ($comics['data']['results'] as $creator) {
				foreach ($creator['creators']['items'] as $item) {
					if($item['role']=='editor' and !in_array($item['name'], $data['Editors']) ){
						$data['Editors'][] = $item['name'];
					}
				}
			}
			foreach ($comics['data']['results'] as $creator) {
				foreach ($creator['creators']['items'] as $item) {
					if($item['role']=='writer' and !in_array($item['name'], $data['Writers']) ){
						$data['Writers'][] = $item['name'];
					}
				}
			}
		}
		if($data){
			return $this->respond($data);
		}else{
			return $this->failNotFound('Información no enconrada '.$person);
		}
	
	}

	public function chars($person)
	{
		$data['title'] = 'Personaje - '.$person;
		$data['char'] = $person == 'ironman'?1009368: ($person=='capamerica'?1009220: 0);
		return view('characters', $data);
	}

	/**
	 * [Devuelve un array de cada uno de los nombres de personajes y el nombre del comic con los que ha interactuado ya sea ironman o capamerica]
	 * @param  string $person [ironman/capamerica]
	 * @return array $data
	 */
	public function characters($person)
	{
		$char = $person == 'ironman'?1009368: ($person=='capamerica'?1009220: 0);
		$baseUrl 	= 'https://gateway.marvel.com:443/v1/public/characters/';
		$apiKey 	= '6810f9d29ae71c4ca417e027d73f4949';
		$privateKey = '290c908b436c25f243a429801092a1b0fd01445e';
		$limit 		= '100';
		$ts 		= 1929929;
		$hash 		= md5($ts.$privateKey.$apiKey);

		$dataSup 	= json_decode( file_get_contents("https://gateway.marvel.com:443/v1/public/characters/".$char."?ts=".$ts."&apikey=".$apiKey."&hash=".$hash), true );
		$super 		= $dataSup['data']['results'][0]['name'];

		$hash 		= md5($ts.$privateKey.$apiKey);
		$comics 	= json_decode(file_get_contents("https://gateway.marvel.com:443/v1/public/characters/".$char."/comics?format=comic&formatType=comic&ts=".$ts."&apikey=".$apiKey."&hash=".$hash), true );
		$characters = array();
		if ($comics['data']['results']) {
			foreach ($comics['data']['results'] as $comic) {
				foreach ($comic['characters']['items'] as $item) {
					if ($super!=$item['name'] && !in_array($item['name'], $characters)) {
						$characters[] = $item['name'];
					}
				}
			}
		}
		$data['characters'] = array();
		foreach ($characters as $char) {
			$cms 	= array();
			foreach ($comics['data']['results'] as $comic) {
				foreach ($comic['characters']['items'] as $item) {
					if ($char==$item['name']) {
						$cms[] = $comic['title'];
					}
				}
			}
			$data['characters'][]= [
									"character"=>$char,
									 "comics"=> $cms
									];
		}

		if($data){
			return $this->respond($data);
		}else{
			return $this->failNotFound('Información no enconrada '.$person);
		}
	}
}
