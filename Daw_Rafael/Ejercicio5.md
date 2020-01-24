# ejercicio 5

## 1- Busca en el repositorio php de hub.docker.com una imagen adecuada.

- Vamos a nuestro docker hub y buscamos php. Elegimos la primera imágen y nos llevará a su página donde podemos copiar el codigo para bajarnos la imagen:
```
docker pull php:apache
```

## 2- Averigua en qué carpeta de la imagen debes incluir el archivo index.php.

- Activar la imagen en formato interactivo:
```
docker run -it php:apache /bin/bash
```

- Encontrar la carpeta:
```
cd ./var/www/html
```

## 3- Crea una nueva imagen que incluya el archivo `index.php`. Ejecuta un contenedor basado en esta imagen y abre la dirección `localhost` en el navegador.

- Creamos carpeta local:
```
mkdir ejercicio5
```

- Entramos en la carpeta y creamos index.php:
```
nano index.php

<?php
    phpinfo();
    phpinfo(INFO_MODULES);
?> 
```

- Creamos DockerFile y ponemos la ruta para copiar el index en el html:
```
nano Dockerfile

FROM php:apache
MAINTAINER rafael <rafarnaugaselba05@gmail.com>
COPY index.php /var/www/html
```

- Y ejecutamos Docker build:
```
docker build -t php:apache_new .
```

- Lo ejecutamos:
```
docker run -d -p 80:80 php:apache_new
```

## 4- Crea una carpeta local llamada logs y monta un volumen de manera que en esta carpeta se muestren los logs de acceso al servidor para poder verlos localmente.

- Creamos la carpeta logs en nuestra carpeta del ejercicio:
```
mkdir logs
```

- Buscamos la ruta en el contenedor:
```
/var/log/apache2
```

- Enlazar volumen con contenedor:
```
docker run -d -p 80:80 --name miphp -v ~/ejercicio5/logs:/var/log/apache2 php:apache_new
```

- Lo reiniciamos:
```
docker restart miphp
```

- Lo miramos:
```
ls ~/ejercicio5/logs -al

Deberia salir:

drwxrwxr-x 2 rafael rafael 4096 ene 24 16:58 .
drwxrwxr-x 3 rafael rafael 4096 ene 24 16:24 ..
-rw-r--r-- 1 root   root    154 ene 24 16:59 access.log
-rw-r--r-- 1 root   root    956 ene 24 16:59 error.log
-rw-r--r-- 1 root   root      0 ene 24 16:58 other_vhosts_access.log
```
## 5- Accede varias veces a la página mediante el navegador y comprueba que los logs se actualizan. 

## 6- Obtén un listado de los módulos de php instalados en la imagen (php -m). 

```
docker exec -it miphp(nombre del contenedor) php -m
```

## 7- Sube la imagen a tu cuenta de hub.docker.com

- En nano Dockerfile ponemos:
```
FROM php:apache
MAINTAINER rafael0507 <rafarnaugaselba05@gmail.com>
COPY index.php /var/www/html
```

- Construimos el Docker:
```
docker build -t rafael0507/miphp .
```

- Conectarnos a lacuenta de docker hub:
```
docker login
```

- Subirlo a docker hub:
```
docker push rafael0507/miphp
```