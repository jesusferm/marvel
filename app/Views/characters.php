<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$title;?></title>
	<meta name="description" content="The small framework with powerful features">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
	<link rel="stylesheet" href="<?=base_url('bootstrap/css/bootstrap.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('bootstrap-icons/bootstrap-icons.css')?>">
</head>
<body>
	<header class="p-3 mb-3 border-bottom">
		<div class="container">
			<div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
				<a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
					<svg class="bi bi-me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
				</a>

				<ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
					<li><a href="#" class="nav-link px-2 link-secondary">Overview</a></li>
					<li><a href="#" class="nav-link px-2 link-dark">Inventory</a></li>
					<li><a href="#" class="nav-link px-2 link-dark">Customers</a></li>
					<li><a href="#" class="nav-link px-2 link-dark">Products</a></li>
				</ul>

				<form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
					<input type="search" class="form-control" placeholder="Search..." aria-label="Search">
				</form>

				<div class="dropdown text-end">
					<a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
						<img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
					</a>
					<ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1" style="">
						<li><a class="dropdown-item" href="#">New project...</a></li>
						<li><a class="dropdown-item" href="#">Settings</a></li>
						<li><a class="dropdown-item" href="#">Profile</a></li>
						<li><hr class="dropdown-divider"></li>
						<li><a class="dropdown-item" href="#">Sign out</a></li>
					</ul>
				</div>
			</div>
		</div>
	</header>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
				<?php
					$baseUrl 	= 'https://gateway.marvel.com:443/v1/public/characters/';
					$apiKey 	= '6810f9d29ae71c4ca417e027d73f4949';
					$privateKey = '290c908b436c25f243a429801092a1b0fd01445e';
					$limit 		= '100';
					$date 		= new DateTime();
					$ts 		= $date->getTimestamp();
					$hash 		= md5($ts.$privateKey.$apiKey);

					$url 		= "${baseUrl}?nameStartsWith=ironman&limit=${limit}&ts=${ts}&apikey=${apiKey}&hash=${hash}";

					$ch = curl_init();
					//http://gateway.marvel.com/v1/public/comics?ts=1&apikey=1234&hash=ffd275c5130566a2916217b101f26150
					curl_setopt($ch, CURLOPT_URL, "https://gateway.marvel.com:443/v1/public/characters/".$char."?ts=".$ts."&apikey=".$apiKey."&hash=".$hash);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$res = curl_exec($ch);
					curl_close($ch);

					/*print_r($res);

					echo '<br><br>';*/

					$data = json_decode( file_get_contents("https://gateway.marvel.com:443/v1/public/characters/".$char."?ts=".$ts."&apikey=".$apiKey."&hash=".$hash), true );
					//$data['data']['results'][0]['id']
				?>
				<h3>
					<?php
					echo $char.' - Personaje: '.$data['data']['results'][0]['name'];
					?>
				</h3>

				<?php
				$comics = json_decode(file_get_contents("https://gateway.marvel.com:443/v1/public/characters/".$char."/comics?format=comic&formatType=comic&ts=".$ts."&apikey=".$apiKey."&hash=".$hash), true );

				
				
				if ($comics['data']['results']) {
					//echo 'Editors : [';
					foreach ($comics['data']['results'] as $comic) {
						//print_r($creator['creators']);
						echo $comic['title'].'<br>';
						//print_r($comic['characters']['items']);

						foreach ($comic['characters']['items'] as $item) {
							echo $item['name'].',';
						}
						echo '<br><br>';
					}
					/*echo '],<br>Writers : [';
					foreach ($comics['data']['results'] as $creator) {
						//print_r($creator['creators']);
						foreach ($creator['creators']['items'] as $item) {
							if($item['role']=='writer'){
								echo $item['name'].',';
							}
						}
					}
					echo ']';*/
				}
				?>
			</div>
		</div>
	</div>

	<script src="<?=base_url('bootstrap/js/bootstrap.bundle.js')?>"></script>
	<script src="<?=base_url('jquery/jquery-3.6.0.min.js')?>"></script>
</body>
</html>
