# daw2-daw-1920

## clase 1

- Crear una cuenta en github
-Crear un nuevo repositorio: daw2-daw-1920
- instalar git
- Si aparece un error "No se puedo bloquear /var/lib/dpkg/lock" ..., introducir la siguiente intrucción:

```
sudo fuser -vki /var/lib/dpkg/lock
```

y volver a instalar git.

```
sudo apt install git
```

### Instrucciones básicas git

- Ir primero a Añadir clave ssh a github

- Clonar el repositorio remoto
```
git clone url
```

- Ver estado del repositorio local
```
git status
```

- Hacer un *commit* (comprometer) los cambios al repositorio local
```
git commit -am "mensaje"
```

- Subir (push) los cambios del repositorio local elrepositorio remoto:
```
git push origin master
```

- Sincronizar local con archivo en github:
```
git fetch
```

- Actualizar (pull) el repositorio local con los cambios desde el repositorio remoto
```
git pull origin master
```

### Añadir clave ssh a github

En primer lugar istalamos openssh-server:
```
sudo apt install openssh-server
```
Después generamos una clave:
```
ssh-keygen -t rsa -b 4096 -C "your_email@example.com"
```
Una vez generada la clave, la copiamos al portapapeles. Para ello, mostramos la clave por la consola del sistema, y luego la copiamos:
```
cat ~/.ssh/id_rsa.pub
```

y la añadimos a github (**settings** -> **SSH and PGP keys**)

Arrancamosel agente *ssh* en segundo plano:
```
eval "$(ssh-agent -s)"
```

y ahora añadimos la clave al agente:
```
ssh-add ~/.ssh/id_rsa
```

Para que github acepte la conexión ssh hay que modificar ladirección *origin*. Para ver la url actual:
```
git remote show origin
```

Esto lo mostrará un mensaje similar a este:
```
URL  para obtener: https://github.com/dante0507/daw2-daw-1920.git
URL para publicar: https://github.com/dante0507/daw2-daw-1920.git
```
Ahora hay que modificar esta dirección añadiendo la opción *ssh*:
```
git remote set-url origin git+ssh://git@github.com/tu-usuario/daw2-daw-1920.git
```

## Istalación de virtualbox

- Primero instalamos las dependencias:
```
sudo apt install libcurl4 libqt5opengl5 libqt5printsupport5 
sudo apt install gcc make perl
```

- Desargamos virtualbox y el *extension pack* desde la página de descargas de www.virtualbox.org
-Ejecutamos el archivo .deb descargado:
```
sudo dpkg -i virtualbox-6.0_6.0.12-133076~Ubuntu~bionic_amd64.deb
```

## Instalación Visual Studio

- Vamos a internet y nos descargamos el archivo .deb

- En terminal ponemos:
```
sudo dpkg -i nombre_del_arhivo.deb
```

## Crear nuevo usuario en Ubuntu

- Creamos el nombre de la nueva cuenta:
```
sudo adduser nombre de usuario
```

- Que la nueva cuenta tenga permisos de usuario:
```
sudo usermod -aG sudo nombre de usuario
```

## Ejemplo ejercicio 1

- Iniciar el repositoria y hacerlo en un servidor local:
```
git init
```

- Modificar script:
```
nano nombre del script.sh
```

- Abriremos el script con "nano script.sh" yle pondremos el interprete "#!/bin/bash"

- Para que el script se pueda ejecutar ponemos:
```
chmod +x script.sh
```

- Ejecutar el script:
```
./script.sh
```

- Lo añadimos al seguimiento:
```
git add script.sh
```

- Tendrmos siempre al principio del servido una rama llamada "master" pero podemos crear otras así:
```
git branch nombreRama
```

- Estar en la rama:
```
git checkout nombreRama
```

- Volver a la rama master:
```
git checkout master
```
- Actualizar la rama master:
```
git merge nombreRama
```

- Ver rama activa o en la que te encuentras:
```
git branch
```

- Eliminar rama:
```
git branch -d nombreRama
```
- ### Si pusieramos más de una rama y actualizar la rama maste con las dos no será posible por lo que tendermos que realizar estos pasos:

- Miramos la resolución de conflicto:
```
git mergetool
```

- Instalamos meld:
```
sudo apt install meld
```

- Volvemos a mirar la resolucion y nos saldrá una entana que nos dira que queremos poner en el script principal. Lo elegimos y lo guerdamos. Cuenado acabemos tendremos que borrar los archivos innecesarios:
```
rm nombreArchivo
```

# [Ejercicio1](Ejercicio1.md)

# [InstalarCentos](InstalarCentOS.md)


- Instalar FileZilla:
```
sudo apt install filezilla
```

# Simular dos dominios y una ip

- Creamos dos carpetas donde poner nuestras paginas:
```
sudo mkdir /var/www/carpeta1
sudo mkdir /var/www/carpeta2
```

- Copiamos las capetas en la base web:
```
sudo cp -R web_daw/* /var/www/carpeta1/
sudo cp -R web_daw/* /var/www/carpeta2/
```

- Cambiamos el titulo html de las webs:
```
sudo nano /var/www/nombre/index.html
```

- Premisos:
```
644 (rw-r--r--) para archivos
755 (rwxr-xr-x) para carpetas
```
## Crear virtualbox en las webs

- Ceamos la web en el httpd:
```
sudo nano /etc/httpd/conf.d/nombre.conf
```

- Ponbemos el virtualbos en cada web:
```
<VirtualHost *:80>
        DocumentRoot /var/www/nombre
        ServerName nombre.com
</VirtualHost>
```

-  Creamos la Ip:
```
sudo nano /etc/hosts
Ip nombre.com
```

- Reiniciamos apache:
```
sudo apachectl restart
```

# Simular un dominio y dos ips

- Apgaos el servidor centOS
- VAmos a Configuracion/ Red
- Habilitamos un segundo puente 

- Volvemos la web en el httpd:
```
sudo nano /etc/httpd/conf.d/nombre.conf
```

- Cambiamos la ip:
```
<VirtualHost ip:80>
        DocumentRoot /var/www/nombre
        ServerName nombre.com
</VirtualHost>
```

- Confirmamos que todo esta correcto:
```
sudo apachectl configtest
```

- Y reiniciar apache:
```
sudo apachectl restart
```

- Debemos salir de apche y entrar en las ips así:
```
sudo nano /etc/hosts
```
- Cambiamos la ip de una de las web con la segunda ip

# Abrir web desde otro puerto

- Creamos la carpeta, cambiamos el html y el conf
- Ponemos dominio diferente:
```
Listen 8080
<VirtualHost *:8080>
        DocumentRoot /var/www/nombre
        ServerName nombre.com
</VirtualHost>
```

- Abriri el puerto en firewall:
```
sudo firewall-cmd --add-port=8080/tcp --permanent
```

- Reiniciamos firewall:
```
sudo firewall-cmd --reload
```

## Instalar PHP

- Ver modulos:
```
httpd -M
```

- Cambiar el Gateaway:
```
GATEWAY=192.168.1.2
```

- Reiniciar el servidor:
```
sudo service network restard
```

- Instalar PHp en centos:
```
sudo yum install epel-release yum-utils
sudo yum install http://rpms.remirepo.net/enterprise/remi-release-7.rpm
```

- Activamos el repositorio:
```
sudo yum-config-manager --enable remi-php72
```

- Instalar librerias de PHP:
```
sudo yum install php php-common php-opcache php-mcrypt php-cli
sudo yum install php-gd php-curl php-mysqlnd
```
- Ver version de PHP:
```
php -v
```