# Marvel Prueba

## Entorno

- Fedora 35 x86_64
- Servidor XAMPP 8.0.13
- PHP 8
- API Rest Codeigniter 4.1.5

## Pruebas realizadas en Postman

	cd /opt/lampp/htdocs
	git clone https://github.com/jesusferm/marvel.git
	cd marvel
	php spark serve

# Servicios web disponibles

## Servicio web que devuelve la lista de editores y escritores de los comics de cada super-heroe
[http://localhost:8080/marvel/characters/ironman](http://localhost:8080/marvel/characters/ironman)
[http://localhost:8080/marvel/characters/capamerca](http://localhost:8080/marvel/characters/capamerica)

## Servicio web que devuelve el nombre del personaje y comiv con los que ha interactuado el personaje enviado vía get
[http://localhost:8080/marvel/colaborators/capamerica](http://localhost:8080/marvel/colaborators/capamerica)
[http://localhost:8080/marvel/colaborators/ironman](http://localhost:8080/marvel/colaborators/ironman)