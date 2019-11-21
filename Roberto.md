# DAW2-daw1921

## CLase 1

- Crear una cuenta en Github
- Crear un nuevo repositorio
        DAW2-daw1921
- instalar git
- Si aparece un error  "no se pudo bloquear /var /liv /dkpg/     lock"..., introducir la siguiente instruccion:

    ```
    sudo  fuser -vki /cvar/lib/dpkg/lock
    ```

    y volver a instalar git.

    ```
     sudo apt install git
    ```     

### instrucciones basicas git
- clonar el repositorio
``` 
git clone [url]

```

- ver etsado del repositorio local 
```
git status

```

- hacer un *commit* (comprometer) los cambios al repositorio local

``` 
git commit  -am "mensaje"

```

- Subir (push) los cambios del repositorio local al remoto

``` 
git push origin master

```

Actualizar (pull)el repositorio local con los cambios  desde el repositorio remoto

``` 
git pull origin master
```


### Añadir clave SSH a github
en primer lugar instalamos openssh-server:
```
sudo apt install openssh-server
```

Despues lugar generamos una clave :
```
h-keygen -t rsa -b 4096 -C "email"
```
Una vez generada la clave , la copiamos en el portapapeles, para ello mostramos la clave por la consola del sistema y luego la copiamos.
```
cat ~/.ssh/id_rsa.pub
```
Una vez copiada ir al apartado settings de la cuenta de github  y en el apartado *SSH and GPG keys* hacer click sobre *Nes SSH key* y copiar la clave SSH.

Arrancamos el agente *ssh* en segundo plano:

```
eval "$(ssh-agent -s)"

```
y añadimos la clave al agente

```
ssh-add ~/.ssh/id_rsa
```
Para que githun acepte la conexion ssh hay que modificar la direccion *origin*. Para ver la url actual:

```
git remote show origin
```
esto nos mostrara un mensaje sinmilar a este:

```
URL para obtener: http://github.com/r.redfield.90@gmail.com/
URL para  publicar: http://github.com/r.redfield.90@gmail.com/
```
ahora hay que modificar esta direccion añadinendo la opcion ssh:
```
git remote set-url origin git+ssh://git@github.com/R-Redfield/DWA2-daw1921.git

```

### Instalacion de virtual box


Primero instalaremos las dependencias de virtualbox

```
sudo apt install libcurl5 libqt5opengl5 libqt5printsupport5

sudo apt install gcc make perl
```
Luego instalaremos virtualbox

```

sudo dpkg -i virtualbox-6.0_6.0.12-133076~Ubuntu~bionic_amd64.deb 
```
por ultimo instalaremos  Flameshot para hacer capturas de pantalla.

```
sudo apt install flameshot

```


## Clase 2

Crear un nuevo usuario en Linux

```
sudo adduser "nombre" (en minusculas)
```
introduciremos nuestra contraseña y luego la del nuevo usuario, aceptaremos todos los demas campos de registro.

Añadir permisos de super usuario

```
sudo usermod -aG sudo "usuario" 
```

//nota solucion al error no se pudo bloquear /var/lib/dpkg/ lock-frontend

```
sudo  fuser -vki /cvar/lib/dpkg/lock-frontend
```

contraseña server "server123"

inicializar  un directorio local de git
```
git init
```

añadir permisos a un archivo o un directorio
```
chmod "nombre del archivo"
```

añadir una rama a git

```
git branch "nomre" sin comillas
```
para cambiar a la rama creada 

```
git checkout bugfix 
```

integrar cambios 

ir a la rama master
usar la instruccion

```
git merge bugfix
```
entonces el codigo de la rama bugfix se pasa a la master.


para eliminar una rama que ya hemos "mergeado"

```
git branch -d bugfix
```

instalar meld (herramienta que arregla un problema cuando un merge se solapa con otro)

```
sudo apt install meld
```

cuando se abre la ventana de "meld" apareceren 3 columnas. la del centro es la master y las de los extremos es el cambio de cada una de las ramas. Para solucionar el conflicto solo hay que marcar la flecha del cambio que realmente queremos guardar.

borrar archivo en linux
 ```
 rm nombre
 ```

herramienta de resolucion 
```
 git mergetool
 ```


 ## Clase 3

 Bajada de Cent OS
 http://centos.uvigo.es/7.7.1908/isos/x86_64/


 ### instalacion de apache en centos

 login: robero pass:t688905468


```
 sudo vi /etc/sysconfig/network-scripts/ifcfg-enp + tabular

```
cambinar el parametros onboot a yes. 
para entrar enmodod edicion es la i
esc para salir del modo edicion.
si se bloquea usar los dos puntos ":"
y para finalizar guardar con WQ

para reinicar el sistema de red

```
sudo service network restart
```

para instalar el apache en centos minimal es
```
sudo yum install httpd
```

yum:gestor de paquetes

aceptar todo con si
### comandos de apache

ver el estado de apache
```
systemctl status httpd
apachectl status
```
arrancar el servidor
```
sudo systemctl start httpd
```

para conectar por ssh necesitamos saber la ip del servidor
```
ip addr show
```

conectarse por ssh

```
ssh roberto@10.0.2.14
```

esto no va a funcionar (la ip cambia a la del servdidor)

una vez configurado el nat nos podremos meter via ssh por el siguiente comando
```
ssh roberto@127.0.0.1-p 2222
```

solucion de problemas.

instalar ssh server

```
sudo yum install openssh-server
```

abrir el firewall

```
abrir firewall http
sudo firewall-cmd --zone=public --add-service=http --permament
abrir firewall ssh
sudo firewall-cmd --zone=public --add-service=ssh --permanent
recargar el firewall
sudo firewall-cmd --reload
```
estos parametros arreglaron el conection refused

parar el servidor

```
apachectl stop
```

arrancart servidor 

```
apachectl start
```

reiniciar el servidor

```
apachectl restart
```

reiniciar cuando todas las transacciones terminen

```
apachectl graceful
```
espera a que las sesiones terminen pero no inicia nuevas


arrancar automaticamente con cada reinicio el seridor

```
sudo systemctl enable httpd
```

instalar el manual de apache

```
sudo yum install httpd-manual
```

instalar nano

```
sudo yum install nano

```

sudo nano /etc/httpd/conf/httpd.conf

server root= configuracion de todo el httpd

listen= el puerto por el que queremos escuchar

include conf.modules.d/*.conf=carga todos los modulos y podemos añadir exclusiones o cargar solo los que queramos

sersverAdmin "root@localhost"= se puede cambiar por nuestro correo para cuando hayan errores nos lleguen los correos de errores a nuestro correo configurado ahi

ServerName www.example.com:80 =sirve para poner nuestro dominio

Directory/
allowoverride none
require all dnied
/Directory

esto bloquea el acceso al sistema de archivos

includeOptional conf.d/*.conf carga todos los dominios que tengamos.

comprueba si la sintaxis del archvo de configuracion es correcta.

```
sudo apachectl configtest
```
```
sudo nano etc/hostname
```

para cambiar el nombre del srevidor

el archivo de host permite guardar los nombres de dominio

```
sudo nano etc/host
```
esto nos permite cambiar el archivo de host

y para que se apliquen los cambios hay que reiniciar el servidor

sudo reboot


instalar filzilla
```
sudo apt install filezilla
```
conectar con el servidor
crear carpeta de descargas
```
mkdir descargas
```
instalar unzip para descomprimir en el servidor
```
sudo yum install unzip
```
descomprimir el zip usando unzip+archivo

## clase 5

```
sudo nano /etc/sysconfig/network-scripts/ifcfg-enp<TAB>

 sudo nano/etc/sysconfig/network-scripts/ifcfg-enp + tabular

```
 para poner direccionamiento estatico
 ```
BOOTPRTO=static

crear linea debajo 
IPADDR=192.168.1.175
NETMASK=255.255.255.0
GATEWAY=192.168.1.1
DNS1=8.8.8.8
DNS2=8.8.4.4
```
conexion a FTP
```
direccion del servidor
usuario: Roberto
pass:t688905468
puerto;22
```

descomprimir la pagina web
```

ll /var/www/ para ver la carpeta donde se almacenan las webs
```
```
sudo mkdir /var/www/clientes 
sudo mkdir /var/www/proveedores
```
para crear las carpetas dentro de la carpeta de apache que almancena las webs
```
sudo cp -R web_daw/* /var/www/clientes/
sudo cp -R web_daw/* /var/www/proveedores/
```
para copiar la carpeta web a la direccion


permisos 
644 para archivos
755 para carpetas

ll /etc/httpd

configuraion de apache

y para configurar el virtualhost
sudo nano /etc/httpd/conf.d/clientes.conf
para crear un archvios de configuracion para la pagina clientes


<VirtualHost *:80>
    DocumentRoot /ruta
    SreverName direccion.com
</VirtualHost>

para que toda la configuracion tenga exito hay que reinciar apache


segunda ip:192.168.1.195
 con dos ips podemos modificar que cada pagina entre en una distita


para hacer que una web se escuche por un puerto distinto de la misma direccion en el archvio de configuracion de la web añadimos la instruccion 
Listen 8080

para abrir el puerto 8080 

sudo firewall-cmd --add-port=8080/tcp --permanent



instalar php

httpd -M 

muestra la lista de modulos instalados en apache


sudo yum install apel-release yum utils

instala dos repositorios necesrios para actualizar los modulos de apache

sudo yum clean all && sudo yum update -y

sudo network restart (reinicia la red)

sudo  yum install epel-release yum-utils
sudo yum install http://rpms.remirepo.net/enterprise/remi-release-7.rpm

activar repositorio
sudo yum-configmanager --enable remi-php72

instalar php

sudo yum install php php-common php-opcache php-mcrypt php-cli

sudo yum install php-gd php-curl php-mysqlnd

para ver la version de php 
php -v

ll /etc/httpd/conf.modules.d es la ruta de la configuracion de los modulos

y el archivo php.conf es el archivo de configuracion de php


## Clase 6

sudo nano /var/www/inde.php

reinicia el server php
sudo apachectl restarat

### instalar mysql
sudo yum instasll mariadb mariadb-server 

### ver el estado del servidor sql
sudo systemctl status mariadb

### arrancar sql server
sudo systemctl start mariadb

### hacer que maria db se arranque con el inicio
sudo systemctl enable mariadb

### configurar la seguridad de mysqul
sudo mysql_secure_installation

decimos que yes a todo

entrar al editor de bases de datos
```
mysql -u root-p
```
mostrar las bases de datos
```
show DATABASES
```

### instalar php myadmin

```
sudo yum install php-pcl-zip php-mbstring 
sudo yum install phpmyadmin

ll /etc/httpd/conf.d
ll /etc/httpd/conf.modules.d
```
## seguridad

crear carpeta  de admin
```
sudo mkdir /var www/clientes /admin
sudo nano /var www/clientes /adminindex.html
````
 crear carpeta para guardar passwords

```
 sudo htpasswor
 sudo httpasswd -c /etc/httpd/passwords/paswords-admin admin
```

 pass:admin

 para ver la pass
```
 cat /etc/httpd/passwords/paswords-admin
```

 crear otra pass para otro admin
```
 sudo htpasswd  /etc/httpd/passwords/paswords-admin admin2
```
 para restringir el acceso a una web clientes

 entramos en la configuracion de la web
 sudo nano /etc/httpd/conf.d/clientes.conf

 añadimos estas lineas

 <Directory "/var/www/clientes/admin">
        AuthType Basic
        AuthName "Administador"
        AuthUserFile /etc/httpd/passwords/password-admin
        Require valid-user para cualquiera con la contraseña
        Require admin para solo el administrador




</Directory>


crear carpeta admin y archivo index en la carpeta proveedores

crear archivo de contraseña
```
sudo htdigest -c /etc/httpd/password digest/ "administradores" admin
```

editamos la config de la web
<Directory "var/www/proveedores/admin">

        AuthType Digest
        AuthName "addministradores"
        AuthUserFile /etc/httpd/password/digest
        #require valid-user 
        Require	user admin
</Directory>

reiniciamos el servidor

para ver el log de errores de seguridad

```
sudo more /var/log/httpd/error_log
```

### control de acceso

crear carpeta gestion en clientes
```
sudo mkdir /var/www/clientes/gestion
```
crear index.html dentrno

cambiar configuracion
```
sudo nano /etc/httpd/conf.d/proveedores.conf
```

<Directory "var/www/clientes/gestion">
        <RequireAll>
                Require all denied
        </RequireAll>
</Directory>

 con esta nueva directiva bloqueamos a todos
 esta seria la directiva para que entre solamente la ip

 <Directory "var/www/clientes/gestion">
        <RequireAll>
                Require	ip 192.168.1.140
                #  Require all denied
        </RequireAll>
        require not ip "ip" te impide entrar
</Directory>

###comprovar acceso a carpetas
```
sudo mkdir /var/www/clientes/testheaccess
```

crear un index.html dentro

cambiar la configuracion de clientes añadiendo esto

<Directory "/var/www/clientes/testhtaccess">
    AllowOverride All
    Options Indexes
</Directory>
si existe un archivo HTML lo servira antes que mostrar la lista de archivos.

ahora crearemos el archivo de configuracion htcaccess

```
sudo nano /var/www/clientes/testhtaccess/.htaccess
```
estos son los parametros que podemos tener en este archivo.
#Require all denied #no deja acceder a nadie

Require all Granted #esto da permiso a todo el mundo

#Require ip 192.168.1.140 #solo perite entrar a esta ip

#Require nonip 192.168.1.140 #deniega el acceso	a esta ip

## ssl

La idea de SSL es hacer de entidad certificadora que nos certifique que realmente nos estamos conectando donde queremos.

#### habilitar SSl
```
instalar ssl
sudo yum install openssl
```
crear clave privada
````
openssl genrsa -out certificado.key 2048
```

crear clave privada (archivo csr)
```
openssl req -new -key certificado.key -out certificado.csr
```
pass: patata

firmar de nuevo
```
openssl x509 -req -days 90 -in certificado.csr -signkey certificado.key -out certificado.crt
```
instalar modulo ssl
```
sudo yum install mod_ssl
```
ver que aparezca 
```
ll /etc/httpd/conf.d

````

 ahora hay que mover los certificados a la carpeta de certificados

```
 sudo cp certificado.crt /etc/pki/tls/certs
 
 sudo cp certificado.key /etc/pki/tls/certs
```
ahora tocaria configurar el archivo ssl para que sepa donde estan los certificados
```
sudo nano /etc/httpd/conf.d/ssl.conf
```


cambiar etas lineas

```
SSLCertificateFile /etc/pki/tls/certs/certificado.crt
SSLCertificateKeyFile /etc/pki/tls/private/certificado.key
```

añadir https al firewall

```
sudo firewall-cmd --zone=public --add-service=https --permanent
reiniciar el firewall
sudo firewall-cmd --reload
```


añadimos esto

Redirect /https://clientes.com
a la primera directiva de la configuracion del sitio
```
sudo nano /etc/httpd/conf.d/clientes.conf
```



