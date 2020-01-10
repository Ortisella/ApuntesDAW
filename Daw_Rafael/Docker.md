# Introducción a Docker

# INDICE

- [Ejercicio 3](Ejercicio3.md)

## Características
- Tecnología de virtualización
- Flexible y portable
- Enfocado a sistemas distribuidos

## Instalar Docker

- Paquete que permite que docker funcione en linux
```
sudo apt install linux-image-generic linux-image-extra-virtual
```

- Instalarlo:
```
sudo apt install docker docker.io docker-compose
```

- Poner nuestro ususario en docker:
```
sudo usermod -aG docker $(whoami)
```

- Reiniciamos el ordenador o cerramos sesión

## Codigo de Docker

- Ver la version de docker:
```
docker version
```

- Ver codigo para imagenes de docker:

[https://docs.docker.com/engine/reference/commandline/docker](https://docs.docker.com/engine/reference/commandline/docker)


- Ver imagenes:
```
docker images
```

- Descargar una imagen:
```
docker pull <image>

Ejemplo: docker pull httpd
```

- Borrar imagen:
```
docker rmi <img id> o <nombre>
docker image rm <img id> o <nombre>
```

- Borrar contenedores:
```
docker container rm <id> o <nombre>
```

- Borrar todos los contenedores:
```
docker system prune
```

- Borra todos los contenedores de la que depende la imagen:
```
docker system prune --filter label=image=<img>
```

- Listar contenedores:
```
docker ps
docker container ls -a
```

- Descarga la imagen:
```
docker run <img>

Ejemplo: docker run httpd
```

- El docker run pasa que cada vez que lo activemos se creara otro contenedor

-  Arrancar un contenedor existente:
```
docker start <container id>
```

- Saber contenedores en marcha:
```
docker ps
```

- Inspeccionar los datos de la imgen:
```
docker inspect <img>
```

- Historial de una imagen:
```
docker history <img>
```

- Especificar en que puerto se ejecute el contenedor:
```
docker run -p 8080:80 <img>
Poner en el navegador: localhost:8080
```

- Ejecutar img en segundo plano:
```
docker run -p 8080:80 -d <img>
```

## Crear una imagen de Docker

### Manual

- Descargar la imagen:
```
docker pull training/webapp
```

- Hacer que valla en el puerto 80:
```
docker run -p 80:5000 training/webapp
Ponemos en el buscador: localhost
```
- Abrimos una sesión en terminal dentro de un nuevo contenedor de la imagen:
```
docker run -t -i training/webapp /bin/bash
```

- Ver archivos:
```
ls -al
```

- Inspeccionar app:
```
cat app.py
```

- Instalar nano a la imagen:
```
apt-get update && apt-get install nano
```

- Modificar la imagen:
```
nano app.py
```

- Salimos del contenedor:
```
exit
```

- Miramos el nombre del contenedor donde esta la imagen con:
```
docker container ls -a
```

- Crar imagen del contenedor:
```
docker commit -m "actualizar" -a "yo" e297e4dc5d88 training/webapp:sp
```

- Ahora ejecutamos la imagen modificada:
```
docker run -p 80:5000 training/webapp:sp python app.py
```

### Automatizada -> Dockerfile

- Creamos carpeta para ejercicios docker:
```
mkdir ejercicios_docker
```

- Nos metemos en el contenedor:
```
docker run -t -i training/webapp /bin/bash
```

- Miramos la información y copiamos el contenido desde import:
```
cat app.py
```

- Vamos a la nueva carpeta y creamo un archivo para guardar la información:
```
nano app.py
```

- Y creamos Dokerfile:
```
nano Dockerfile
```

- En Dockerfile ponemos:
```
FROM training/webapp:latest
MAINTAINER rafael <rafarnaugaselba05@gmail.com> (nombre de ususario y correo de docker)
COPY app.py /opt/webapp/
```

- Y ejecutamos Docker build:
```
docker build -t training/webapp:spanish .
```

- Lo ejecutamos:
```
docker run -p 80:5000 training/webapp:spanish
```

## Subir imagen a docker hub

- Creamos una cuenta: [https://hub.docker.com/](Docker Hub)
```
Id: rafael0507
Email: rafarnaugaselba05@gmail.com
```

- En nano Dockerfile ponemos:
```
FROM training/webapp:latest
MAINTAINER rafael0507 <rafarnaugaselba05@gmail.com>
COPY app.py /opt/webapp/
```

- Construimos el Docker:
```
docker build -t rafael0507/webapp:spanish .
```

- Conectarnos a lacuenta de docker hub:
```
docker login
Nos pedirá el id y contraseña de docker
```

- Subirlo a docker hub:
```
docker push rafael0507/webapp:spanish
```

- Si borraramos todos los contenedores e imagenes, aun podriamos ejecutar la imagen así:
```
docker run -d -p 80:5000 --name miweb rafael0507/webapp:spanish

El '-d' ejecuta la imagen en segundo plano
```

- Si quisieramos cambiar el tag, usamos:
```
docker tag id_img rafael0507/webapp:latest
Se cerarra una imagen con el mismo id pero diferente tag
```

### Codigo para la imagen

- Parar la imagen:
```
docker stop nombre_imagen
```

- Reiniciar imagen:
```
docker restart nombre_imagen
```

- Iniciar imagen:
```
docker start nombre_imagen
```

-----------------

# Ejercicio 2

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