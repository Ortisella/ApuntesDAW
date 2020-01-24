# Introducción a Docker

# INDICE

- [Ejercicio 3](Ejercicio3.md)
- [Ejercicio 4](Ejercicio4.md)
- [Ejercicio 5](Ejercicio5.md)

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

- Crear imagen del contenedor:
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

# Redes

## Comandos para gestionar redes en Docker

- Crear una red:
```
docker network create -d bridge mired
```

- Borrar una red:
```
docker network rm
```

- Ver todas las opciones de red:
```
docker network --help

    Resultado:
        connect   name_driver name_container  Connect a container to a network
        create      Create a network
        disconnect  Disconnect a container from a network
        inspect nombre_red    Display detailed information on one or more networks
        ls          List networks
        prune       Remove all unused networks
        rm  nombre_red        Remove one or more networks
```

- Ver las interfaces de todas las redes:
```
ifconfig
```

- Ejecutar img en la red especificada:
```
docker run --rm -d --network=mired --name ejemplo -p 8080:80 rafael0507/daw-hola-mundo

el --rm hará que si se para el contenedor se borrará automaticamente
```

- Installar curl si no lo tienes:
```
sudo apt install curl
```

- Ver si funciona:
```
curl localhost
```

- Ispecionar contenedor y buscar directamente un elemento:
```
docker container inspect ejemplo | grep "IPAddress"
```

- Red de tipo host:
```
docker run --rm -d --network=host --name ejemplo2 rafael0507/daw-hola-mundo
```

-----------------

# Almacenamiento

## Volumenes

- Ver todas los comandos de los volumenes:
```
docker volume --help

    Resultado:
        create  nombre_volumen    Create a volume
        inspect     Display detailed information on one or more volumes
        ls          List volumes
        prune       Remove all unused local volumes
        rm          Remove one or more volumes
```

- Ver datos del volumen:
```
docker volume inspect name_volumen
```

- Ver todos los volumenes:
```
docker volume ls
```

- Borrar volumenes que no se estan usando:
```
docker volume prune
```

- Ver contendo del volumen creado:
```
sudo ls /var/lib/docker/volumes/datos/ -al
sudo ls /var/lib/docker/volumes/datos/_data -al
```

- Enlazar volumen con contenedor:
```
docker run -d -p 80:5000 --name miweb -v datos:/opt/webapp training/webapp
```

- Modificar la imagen dentro del volumen:
```
sudo nano /var/lib/docker/volumes/datos/_data/app.py
```

- Si queremos que los cambios realizados en el volumen se vean tenemos que reiniciar la imagen:
```
docker restart miweb
```

## Volumenes Conectados(BIND)

- Creamos un contenedor local:
```
docker run --rm -d -p 80:5000 --name miweb1 -v ~/miweb:/opt/webapp training/webapp
```
- Copiar el archivo:
```
docker cp miweb1:/opt/webapp/. ~/miweb1
```

- Crear el volumen y copiarlo directamente:
```
docker run --rm -d -p 80:5000 --name miweb -v ~/miweb:/opt/webapp training/webapp
```

-----------------