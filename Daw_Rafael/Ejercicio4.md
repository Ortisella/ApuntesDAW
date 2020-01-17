# Ejercicio 4

## Parte 1: Ejecuta el contenedor y accede a la página web mediante el puerto local 8080. 

- Descargar la imagen:
```
docker pull prakhar1989/static-site
```

- Inspeccionar los datos de la imgen:
```
docker inspect prakhar1989/static-site
```

- Ejecutamos la imagen en el puerto 8080 en segundo plano:
```
docker run -p 8080:80 -d prakhar1989/static-site
```

- Ponemos en el navegador 'localhost:8080' para verlo.

## Parte 2: Crea una imagen nueva a partir de esta mediante un archivo Dockerfile para que se muestre el siguiente mensaje: Hola mundo!!!. 

- Creamos carpeta para la imagen:
```
mkdir ejercicios_dos
```

- Activamos el container:
```
docker start id_container
```

- Accedemos al container:
```
docker exec -it id_container /bin/bash
```

- Buscamos index.html:
```
find -iname index.html
```

- Entramos en la carpeta donde esta el index.html y entramos en el archivo:
```
cat index.html y copiamos el contenido
```

- Salimos con 'exit' y en la carpeta creada haces 'nano index.html' y pegamos el contenido.

- Y creamos Dokerfile:
```
nano Dockerfile
```

- En Dockerfile ponemos:
```
FROM prakhar1989/static-site:latest
MAINTAINER rafael0507 <rafarnaugaselba05@gmail.com>
COPY index.html /usr/share/nginx/html/
```
- Construimos el Docker:
```
docker build -t rafael0507/daw-hola-mundo:latest .
```

## Parte 3: Ejecuta un contenedor a partir de la imagen creada y comprueba que funciona correctamente. Debe mostrar el mensaje Hola mundo!!! en la dirección http://localhost:8080


- Ejecutamos la imagen con el nuevo contenedor, el cual tiene la nueva configuración:
```
docker run -p 8080:80 -d rafael0507/daw-hola-mundo:latest
```

## Parte 4: Sube la imagen a tu repositorio de docker-hub. 

- Conectarnos a lacuenta de docker hub:
```
docker login
Nos pedirá el id y contraseña de docker
```

- Subirlo a docker hub:
```
docker push rafael0507/daw-hola-mundo:latest
```

## Parte 5: Borra todas las imágenes y todos los contenedores locales

- Miramos si hay algun container activo, lo cerramos y borramos todos los contenedores e imagenes:
```
docker system prune -a
```

## Parte 6: Ejecuta de nuevo un contenedor a partir de la imagen creada. Debe descargarla automáticamente de docker-hub

```
docker run -d -p 8080:80 --name index rafael0507/daw-hola-mundo:latest
```