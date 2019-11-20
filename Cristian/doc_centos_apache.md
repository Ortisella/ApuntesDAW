- [INSTALACIÓN DE APACHE EN CENTOS](#Instalación-de-Apache-en-Centos)
    - [Instalación de Apache](#Instalación-de-apache)
    - [Comandos de gestión de Apache](#Comandos-de-gestión-de-apache)
    - [Manipulación de Apache](#Manipulación-de-apache)

- [CONEXIÓN POR SSH A LA MÁQUINA VIRTUAL](#Conexión-por-SSH-a-la-máquina-virtual)
    - [Cuando las IPS son distintas de la maquina virtual y local - ( Regla de reenvíos )](#Cuando-las-IPS-son-distintas-de-la-maquina-virtual-y-local)
    - [Cuando coinciden las IPS de la maquina virtual y local - ( Adaptador puente )](#Cuando-coinciden-las-IPS-de-la-maquina-virtual-y-local)
    - [Colocar la IP generada por el puerto como estática para que siempre sea la misma](#Colocar-la-IP-generada-por-el-puerto-como-estática-para-que-siempre-sea-la-misma)
    - [Configuración del host del servidor](#Añadir-un-nombre-a-la-IP-del-servidor-en-los-hosts)
        - [Cambiar el nombre del hostname](#Cambiar-el-nombre-del-hostname)
        - [En caso de que las IPs no sean iguales (Conexión NAT)](#En-caso-de-que-las-IPs-no-sean-iguales-(Conexión-NAT))
        - [En caso de que las IPs sean iguales](#En-caso-de-que-las-IPs-sean-iguales)
    
- [TRATAMIENTO DEL CONTENIDO DEL SERVIDOR CON FILEZILLA](#Tratamiento-del-contenido-del-servidor-con-FileZilla)

- [SIMULAR DISTINTAS WEBS SOPORTADAS POR EL MISMO SERVIDOR](#Simular-distintas-webs-soportadas-por-el-mismo-servidor)
    - [Configurar las carpetas y archivos de las webs](#Configurar-las-carpetas-y-archivos-de-las-webs)
    - [Asignar la misma IP para cada web](#Asignar-la-misma-IP-para-cada-web)
    - [Asignar 1 IP distinta para cada web (En caso de disponer de 2 IPS)](#Asignar-1-IP-distinta-para-cada-web-(En-caso-de-disponer-de-2-IPS))
    - [Crear una página nueva con un puerto distinto en la misma IP](#Crear-una-página-nueva-con-un-puerto-distinto-en-la-misma-IP)
    - [Ensites y Dissites](#Cuando-cambiamos-el-archivo-conf-de-un-sitio-que-ya-estaba-configurado-con-un-virtualhost-distinto-al-actual-hay-que-hacer-ensites-y-dissites-en-apache-si-nos-da-error)

- [INSTALACIÓN DE PHP Y SUS CONFIGURACIONES](#Instalación-de-PHP-y-sus-configuraciones)
    - [Añadir una página de PHP con BBDD](#Añadir-una-página-de-PHP-con-BBDD)
    - [Instrucciones dentro del gestor de BBDD](#Instrucciones-dentro-del-gestor-de-BBDD)


- [CONFIGURAR LA SEGURIDAD DE APACHE](#Configurar-la-seguridad-de-apache)
    - [Autenticación básica](#Autenticación-básica)
    - [Autenticación Digest](#Autenticación-Digest)
    - [Control de Acceso](#Control-de-Acceso)
    - [Control de acceso a nivel de carpeta (.htaccess)](#Control-de-acceso-a-nivel-de-carpeta-(.htaccess))
    - [Configuración de SSL (Secure Sockets Layer) en apache](#Configuración-de-SSL-(Secure-Sockets-Layer)-en-apache)



# Instalación de Apache en Centos
Documentación

- Descargamos la iso de la versión minimal de centos en su página web principal.

- Creamos una maquina virtual en VirtualBox con la iso descargada y configuramos el sistema operativo.

- Al crear el usuario en la instalacíon, marcar la casilla de utilizar este usuario como administrador.

## Instalación de apache

- Activamos la red

```
sudo vi /etc/sysconfig/network-scripts/ifcfg-enp0s3
```

- Cambiar al modo edición del resultado de la instrucción anterior. Para entrar al modo edición pulsamos la tecla "i".

- Cambiamos la instrucción ONBOOT de "no" a "yes".

- Salimos del modo edición con "escape".

- Para guardar ponemos :wq.

- Reiniciar el servicio de web:

```
sudo service network restart
```

- Comprobar el ping con la instrucción "ping" y para detener la ejecución del control de paquetes pulsar "Control + C".

- Instalamos apache:
```
sudo yum install httpd
```
------
## Comandos de gestión de apache

- Comprobar el estado de apache:

```
systemctl status httpd
```

- Arrancar el servidor:
```
sudo systemctl start httpd
```

- Apagar la maquina virtual
```
sudo shutdown
```


# Conexión por SSH a la máquina virtual

- En el menu de configuración de la maquina virtual en VirtualBox, en el partado red, podemos comprobar que estamos conectados mediante NAT.

- Para comprobar nuestra ip en la maquina virtual:
```
ip addr show
```

- Para comprobar la ip en nuestro propio ordenador utilizamos la misma instrucción que antes.

## Cuando las IPS son distintas de la maquina virtual y local

- Para utilizar la conexión SSH de uno a otro necesitamos estar en la misma IP.

- En configuración de red, vamos al apartado de avanzados y podemos hacer un reenvio de puertos.

-  Creamos una nueva regla de reenvios.
```
Protocolo: TCP
IP anfitrión: 127.0.0.1 (ip del ordenador)
Puerto anfitrión: 2222
IP invitado: 10.0.2.15 (ip de la maquina)
Puerto invitado: 22 (este es el servicio de SSH) (80 es para el sevicio HTTP)
```

- Ejecutamos en la consola del ordenador la conexión a la maquina virtual mediante el puente.
```
ssh cristian@127.0.0.1 -p  2222
```
- Instalamos el servidor de SSH:
```
sudo yum install openssh-server
```

- Abrir el Firewall para conexiones http:
```
sudo firewall-cmd --zone=public --add-service=http --permanent
```


- Abrir el Firewall para conexiones ssh:
```
sudo firewall-cmd --zone=public --add-service=ssh --permanent
```

- Reiniciamos el Firewall:
```
sudo firewall-cmd --reload
```

## Cuando coinciden las IPS de la maquina virtual y local

- En configuración de red de la maquina virtual, cambiamos el modo de conexión de NAT a Adaptador Puente.

- Volvemos a inicar la maquina virtual.

- Miramos que ip nos ha asignado el Adaptador puente.

```
ip addr show
```

- Cada vez que iniciemos la maquina virtual cambiara la ip, apuntamos la que nos ha asignado : 192.168.1.181/24 (en este caso).

- Ahora vamos al terminal de nuestro local para conectarnos por SSH.

```
ssh cristian@192.168.1.181 (ip generada por el Puerto de Envios)
```

- Ahora estamos conectado desde local al servidor de la maquina virtual

- Abrir el Firewall para conexiones http:
```
sudo firewall-cmd --zone=public --add-service=http --permanent
```

- Reiniciamos el Firewall:
```
sudo firewall-cmd --reload
```
----

## Instrucciones linux

- Saber la version de linux:
```
cat  /etc/*-release
```

- Reiniciar centos: 
```
shutdown -rf now
```
---

## Manipulación de apache
- Para ver la verison de apache ejecutamos en la consola local:
```
httpd -v o httpd -V
```

- Si establecemos una regla de reenvios a HTTP, y luego vamos al navegador local y utilizamos 127.0.0.1/Puerto afitrión, estaremos en la página del servidor. (Podemos utilizar el puerto anfitrión 3333 para http)

- Para ver el estado de apache hacemos desde local:
```
apachectl status
```

- Para parar o iniciar o reinicar el servidor apache hacemos desde local:
```
apachectl stop
apachectl start
apachectl restart
apachectl graceful //lo mismo que restart pero respetando las conexiones actuales
```

- Hacer que el sistema arranque el servidor de apache cuando inicie:
```
sudo systemctl enable httpd
```

- Instalamos el manual:
```
sudo yum install httpd-manual
```

- Reiniciamos apache y accedemos al manual mediante:
```
apachectl restart
127.0.0.1:3333/manual/
```


- Si vamos a:
```
cd /etc/httpd
ll
```
- En conf esta el archivo de configuración de apache.
- En conf .d podemos crear archivos de configuración parciales.
- En conf modules .d la configuración de los modulos.
- En logs las respuestas del servidor.
- En modules para acceder a los modulos.

## Colocar la IP generada por el puerto como estática para que siempre sea la misma
---------------
### Instalación de nano 
```
sudo yum install nano
```

- Ahora podemos ver el archivo de configuración de apache con nano.
```
sudo nano /etc/httpd/conf/httpd.conf
```
-----

```
sudo nano /etc/sysconfig/network-scripts/ifcfg-enp0s3
```
- Cambiar BOOTPROTO de DHPC A static
- Crear una linea con IPADDR=(ip generada por el puerto)
- Crear una linea con NETMASK=(con la mascara generada por el puerto)(255.255.255.0)
- Crear una linea con GATEWAY=192.168.1.2 (1 para casa)
- Crear una linea con DNS1=8.8.8.8
- Crear una linea con DNS2=8.8.4.4
- Reiniciar el servidor para volver a ver la IP que genera y debería ser la misma siempre

-----------------------

Para revisar que los archivos de configuración estén bien:
```
sudo apachectl configtest
```
----


# Añadir un nombre a la IP del servidor en los hosts

## Cambiar el nombre del hostname

- Revisar el nombre del servidor:
```
cat /etc/hostname 
```
- Cambiar el nombre del servidor:
```
sudo nano /etc/hostname
```
---
## En caso de que las IPs no sean iguales (Conexión NAT)

- Cambiar el archivo de hosts para relacionar IPs con URLS, por ejemplo que 127.0.0.1 se llame servidor y podamos acceder mediante el nombre "servidor" en el navegador, para que funcione hay que reiniciar (En Centos):
```
sudo nano /etc/hosts
sudo reboot
```

- Ahora que estamos fuera de la conexión servidor, configuramos el archivo hosts de local:
```
sudo nano /etc/hosts
"y ponemos el mismo nombre de referencia de la dirección 127.0.0.1 (servidor)"
```



- Volvemos a conectarnor al servidor por ssh:
```
ssh cristian@servidor -p 2222
```

- Ahora podemos acceder al servidor con el navegador mediante:
```
servidor:3333
```

-----

## En caso de que las IPs sean iguales

- Añadir en el archivo hosts de local la ip proporcionada por el puente con el nombre que nosotros queramos.

```
exit

sudo nano /etc/hosts

(ip generada) nombre
```

- Entrar en el servidor desde local:
```
ssh cristian@ (nombre especificado en hosts o la ip generada por el puente)
```

- Ya podriamos acceder al servidor desde el navagador local con el nombre del host que hayamos puesto en la direccion generada por el puente de envios.
```
nombre/
```

-------------------------------------------
# Tratamiento del contenido del servidor con FileZilla

- Instalar filezilla en local
```
sudo apt install filezilla
```

- Poner un nuevo sitio en filezilla desde el icono arriba a la izquierda.

- Poner nuestra ip, el puerto 22 y por protocolo SSH.

- Modo de acceso normal, y ponemos nuestro usuario y contraseña

- Despues de guardarlo, accedemos a un nuevo sitio desde la flecha de accion debajo del icono de arriba a la izquierda que hemos pulsado antes.

- Ahora conectados al servidor podemos crear carpetas y demas y observarlas desde el FIleZilla.

- Podemos subir archivos de local al FileZilla y de esa manera meter archivos al servidor.

-----
## Instalar ZIP
```
sudo yum install unzip
```

----

# Simular distintas webs soportadas por el mismo servidor

## Configurar las carpetas y archivos de las webs

- Salir de ssh

- Entrar en Descargas

```
cd Descargas
```

- Y descargar el archivo del aula virtual en el directorio

- Una vez lo tengamos en Descargas ejecutar la siguiente intrucción (estando conectados a Filezilla) para copiar por ssh. (ojo, lo normal es no tener la carpeta creada de Descargas en el servidor): 

```
scp ./web_daw.zip cristian@servidor:/home/cristian/Descargas/web_daw.zip
```

- Otra opción es arrastrar directamente el archivo a la carpeta en Filezilla.

- Cambiar el tiempo de espera de conexión de FIlezilla desde Edición opciones a uno superior si no nos funciona


- Entrar al servidor y descomprimir el archivo con unzip

```
ssh cristian@nombre

cd Descargas

sudo unzip web_daw.zip
```

- A continuación creamos 2 carpetas en el servidor para cada web en la carpeta dedicada a webs

```
sudo mkdir /var/www/clientes
sudo mkdir /var/www/proveedores
```

- Ahora copiamos el contenido la web que hemos pasado y descomprimido previamente a cada una de las dos carpetas (Estando en Descargas)

```
sudo cp -R web_daw/* /var/www/clientes/
sudo cp -R web_daw/* /var/www/proveedores/
```

- Cambiamos el titulo de cada web para diferenciarlas:
```
sudo nano /var/www/clientes/index.html
sudo nano /var/www/proveedores/index.html
```

- Los permisos deben ser estos:
```
644 (rw-r--r--) archivos
755 (rwxr-xr-x) carpetas
```

-Mirar permisos:
```
ll /var/www/
ll /var/www/clientes/
ll /var/www/proveedores/
```
---

## Asignar la misma IP para cada web

 - Ver la configuración de apache
 ```
 ll /etc/httpd/conf.d
 ```

 - Comprobamos que no hay nada en conf y procedemos a añadir los archivos ahi:
 ```
 sudo nano /etc/httpd/conf.d/clientes.conf
 ```

 - Al crear el archivo añadirmos esto en el:
 ```
 <VirtualHost *:80> (que vaya por el puerto 80)
    DocumentRoot /var/www/clientes (declaramos carpeta origen)
    ServerName clientes.com (declaramos nuestro dominio)
</VirtualHost>
 ```

 - Y repetimos el mismo paso para proveedores

 - Desde local vamos a editar el archivo hosts

 - Añadimos las IPS (previamente compradas) para clientes y proveedores, pero como solo tenemos la del servidor pues ponemos esa para los 2
 ```
192.168.1.181 (ip generada) clientes.com
192.168.1.181 (ip generada) proveedores.com
 ```

 - Entramos al servidor y reiniciamos apache

 ```
 ssh cristian@nombre
 sudo apachectl restart
 ```

 - Ahora ya podemos acceder a cada web por sus accesos en el navegador

 ```
 clientes.com
 proveedores.com
 ```
------

## Asignar 1 IP distinta para cada web (En caso de disponer de 2 IPS)

- Cerramos la maquina virtual

- Añadirmos otro adaptador puente en el virtualBox desde la configuracion web

- Volvemos a iniciar la máquina virtual

- Vemos que IPS nos ha generado

```
ip addr show
```

- ( Podemos hacer estática esta segunda IP, si queremos )

- Cambiamos el archivo VirtualHost para poner un ip distinta a cada una
```
sudo nano /etc/httpd/conf.d/clientes.conf
sudo nano /etc/httpd/conf.d/proveedores.conf
```

```
<VirtualHost 192.168.1.181:80>
    DocumentRoot /var/www/clientes
    ServerName clientes.com
</VirtualHost>


<VirtualHost 192.168.1.193:80>
    DocumentRoot /var/www/proveedores
    ServerName proveedores.com
</VirtualHost>
```

- Despues comprobar los fallos y luego reiniciar con:
```
sudo apachectl configtest
sudo apachectl restart
```

- Ahora estan asignadas la ips en cada página y debemos cambiar el archivo hosts de local ya que lo teniamos configurado para que apuntaran a la misma

```
exit
sudo nano /etc/hosts
```

- Ahora ya podemos acceder a las páginas por sus respectivas IPs y nombres.

-----

## Crear una página nueva con un puerto distinto en la misma IP

- Creamos la carpeta, copiamos todo el contenido de clientes a esa nueva carpeta y editamos el html para diferenciarla

```
mkdir /var/www/trabajadores
sudo cp -R /var/www/clientes/* /var/www/trabajadores
sudo nano /var/www/trabajadores/index.html
```

- Creamos un archivo nuevo de configuracion:
```
sudo nano /etc/httpd/conf.d/trabajadores.conf
```

- Declaramos que escuche por otro puerto distinto que el de los otros
```
Listen 8080
<VirtualHost *:8080>
    DocumentRoot /var/www/trabajadores
    ServerName trabajadores.com
</VirtualHost>
```

- Reiniciamos el servidor
```
sudo apahcectl restart
```

- Abrimos ese puerto en el Firewall
```
sudo firewall-cmd --add-port=8080/tcp --permanent
```

- Y recargamos el Firewall

```
sudo firewall-cmd --reload
```

- Ahora podemos acceder a esa pagina especificando el puerto:
```
192.168.1.181:8080
```
- Si añadimos esta nueva IP con puerto a hosts podremos generar un acceso.

---

### Problemas con los puertos

- Centos solo tiene una serie de puertos disponibles para que podamos asignar, si por casualidad le asignamos uno y no nos deja actualizar apache  seguir los siguientes pasos:

```
sudo yum -y install policycoreutils-python
```

```
sudo semanage port -a -t http_port_t -p tcp (puerto)
```

- Si nos da error con la ultima poner:

```
sudo semanage port -m -t http_port_t -p tcp (puerto)
```

- Reiniciar apache.

```
sudo apachectl restart
```
---

# Instalación de PHP y sus configuraciones

- Comporbar que modulos tenemos instalados:

```
httpd -M
```

Si nos da cualquier error de mirrors al instalar lo de a continuación, dejar el archivo enp03 a como lo teniamos inicialmente, actualizar la red, descargar todo esto, y volver a cambiarlo a como lo tenemos ahora y actualizar la red.


- Instalar este repositorio:

```
sudo yum install epel-release yum-utils
```

- Instalamos el repositorio para PHP:
```
sudo yum install http://rpms.remirepo.net/enterprise/remi-release-7.rpm
```

- Activamos el repositorio:
```
sudo yum-config-manager --enable remi-php72
```

- Instalamos PHP y otras de sus librerias:
```
sudo yum install php php-common php-opcache php-mcrypt php-cli
```

- Instalar otras librerias:
```
sudo yum install php-gd php-curl php-mysqlnd
```

- Ver la versión de PHP:
```
php -v
```

- Con esto se ha añadido un archivo de configuracion de php en las configuraciones del httpd.

---
- Instalar dependencias de PHPMyAdmin

```
sudo yum install php-pecl-zip php-mbstring
```

- Instalamos PHPMyAdmin

```
sudo yum install phpmyadmin
```

- Modificar el archivo de configuracion de phpmyadmin
```
sudo nano /etc/httpd/conf.d/phpMyAdmin.conf
```

- Dentro del archivo comentamos con "#" todo el RequireAny,
y añadimos esta linea:
```
Require all granted
```
- Reiniciamos el servidor
```
sudo apachectl restart
```

- Ahora podemos acceder mediante el navegador:
```
servidor/phpmyadmin
```

## Añadir una página de PHP con BBDD

- Creamos un archivo php en:
```
sudo nano /var/www/clientes/index.php
<?php phpinfo(); ?>
```

- Reiniciamos el servidor
```
sudo apachectl restart
```

- Ahora podemos entrar a ver lo que muestra lo que hayamos definido en el arvicho por el navegador.

```
servidor/index.php 

(esto es porque clientes es la primera página definida en la IP del servidor)

(o también)

clientes.com/index.php
```

- Vamos a instalar mysql

```
sudo yum install mariadb mariadb-server
```

- Miramos el estado de la base de datos y vemos que esta inactiva
```
sudo systemctl status mariadb
```

- Ponemos en marcha la base de datos
```
sudo systemctl start mariadb
```

- Habilitar la base de datos al inicio del servidor
```
sudo systemctl enable mariadb
```

- Configurar la seguridad de la bbdd
```
sudo mysql_secure_installation
```

- Podemos elegir si poner root password o no. y luego todo a si



## Instrucciones dentro del gestor de BBDD
- Entramos al gestor de la base de datos
```
mysql -u root -p
```

- Desde aqui podemos crear tablas, hacer consultas etc.

- Mostrar la base de datos
```
show DATABASES;
```

- Crear la base de datos.
```
create DATABASE hola;
```

- Salir del gestor de la BBDD
```
quit
```

-----

# Configurar la seguridad de apache

## Autenticación básica

- Imaginamos que tenemos páginas que solo pueden ver personas autorizadas

- Creamos otra página en la web de clientes en la que solo pueda acceder el administrador 

```
sudo mkdir /var/www/clientes/admin

sudo nano /var/www/clientes/admin/index.html
```
- Y ponemos algo dentro para identificarla

- Creamos una carpeta donde crear los usuarios y sus passwords en un archivo
```
sudo mkdir /etc/httpd/password

sudo htpasswd -c /etc/httpd/password/passwords-admin admin
```
- Segun la instrucción anterior añadirmos el usuario admin al archivo de contraseñas passwords-admin

- Si añadimos otro usuario al archivo tendremos que quitar el -c de la instrucción anterior ya que el archivo ya estaría creado

```
sudo htpasswd /etc/httpd/password/passwords-admin admin2
```

- Ponemos de contraseña "admin"

- Así podemos ver la contraseñas de los usuarios en el archivo de forma encriptada
```
cat /etc/httpd/password/passwords-admin
```

- Restringimos el acceso de la página

```
sudo nano /etc/httpd/conf.d/clientes.conf
```

- Ponemos:
```
<Directory "/var/www/clientes/admin">
    AuthType Basic
    AuthName "Administrador"
    AuthUserFile /etc/httpd/password/passwords-admin
    Require valid-user 
</Directory>
```

- Con el Require decimos que sea validado cualquier usuario registrado en la ruta, si solo queremos que sea un usuario especifico ponemos: Require user admin

- Comprobar que en la configuración no hay un error sintáctico
```
sudo apachectl configtest
```

- Reiniciar apache: 
```
sudo apachectl restart
```

- Ahora si entramos al navegador nos pedira usuario y contraseña
```
servidor/admin/

o 

clientes.com/admin
```

## Autenticación Digest
- Creamos un archivo que será accedido restringidamente
```
sudo mkdir /var/www/proveedores/admin

sudo nano /var/www/proveedores/admin/index.html
```
- Escribimos un mensaje dentro

- Creamos el archivo de contraseñas en el que meteremos el usuario admin
```
sudo htdigest -c /etc/httpd/password/digest "administradores" admin
```
- Ponemos contraseña admin

- Recordemos que el -c solo se pondra la vez en la que se crea el archivo, cuando añadamos otros usuarios no.

- Así podemos ver la contraseñas de los usuarios en el archivo en forma hash
```
cat /etc/httpd/password/digest
```

- Restringimos el acceso
```
sudo nano /etc/httpd/conf.d/proveedores.conf
```
- Ponemos: 
```
<Directory "/var/www/proveedores/admin">
    AuthType Digest
    AuthName "administradores" (lo mismo que hemos puesto en el htdigest)
    AuthUserFile /etc/httpd/password/digest
    Require valid-user 
</Directory>
```

- Comprobar que en la configuración no hay un error sintáctico
```
sudo apachectl configtest
```

- Reiniciar apache: 
```
sudo apachectl restart
```

- Ahora si entramos al navegador nos pedira usuario y contraseña
```
proveedores.com/admin/
```

## Control de Acceso
- Podemos restringir el acceso por IPs o rangos de IPs

- Vamos a crear otro archivo en clientes

```
sudo mkdir /var/www/clientes/gestion

sudo nano /var/www/clientes/gestion/index.html
```

- Ponemos dentro un mensaje acorde

- Modificamos el archivo de configuración
```
sudo nano /etc/httpd/conf.d/clientes.conf
```

- Añadimos 
```
<Directory "/var/www/clientes/gestion">
    <RequireAll>
        Require all denied
    </RequireAll>
</Directory>
```

- Con el Require all denied, restringimos el acceso a todo el mundo

- Require all granted daria acceso a todo el mundo


- Añadimos nuestra IP para tener el acceso permitido
```
<Directory "/var/www/clientes/gestion">
    <RequireAll>
        Require ip 192.168.1.151 (nuestra ip en local)
    </RequireAll>
</Directory>
```
- Ahora solo podriamos entrar con nuestra IP

- Con Require noy ip denegariamos el accesoa una IP concreto en el que esten todos permitidos

- Para permitir a un rango de IPs:
Require ip 192.168.1  o Require ip 192.168.1.0/255.255.255.0 o Require ip 192.168.1.0/24 (todas las que deriven de ahi tendran permiso)

- Y reiniciamos el servidor:
```
sudo apachectl restart
```


## Control de acceso a nivel de carpeta (.htaccess)

- Podemos controlar el acceso mediante una carpeta

- Creamos otro archivo en clientes

```
sudo mkdir /var/www/clientes/testhtaccess

sudo nano /var/www/clientes/testhtaccess/datos.txt
```

- Modificamos el archivo de configuracion de clientes

```
sudo nano /etc/httpd/conf.d/clientes.conf
```

- Añadimos:
```
<Directory "/var/www/clientes/testhtaccess">
    AllowOverride All
    Options Indexes (solo funciona si no hay un index.html)
</Directory>
```

- El Options indexes muestra una estructura en forma de indices.

- Reiniciamos el servidor: 
```
sudo apachectl restart
```

- Ahora podemos ver el indice en el navegador
```
clientes.com/testhtaccess
```

- Vamos a restringir el acceso a esta carpeta

- Añadimos un archivo htaccess a esta carpeta

```
sudo nano /var/www/clientes/testhtaccess/.htaccess
```

- Añadimos:
```
Require all denied
```

- La documentación de como configurar  el Require lo tenemos en el apartado anterior

- No hace falta recargar el servidor cuando configuramos este archivo ya que siempre va a coger el archivo para los permisos por defecto

## Configuración de SSL (Secure Sockets Layer) en apache
- Con SSL configurariamos la conexión segura

- Significa que el servidor al que nos estamos conectamos esta espeficicando quien es

- Vamos a habilitar la conexión SSL en nuestro servidor generando un certificado autofirmado

- Instalamos el servidor de SSL
```
sudo yum install openssl
```

### Crear una clave privada

```
openssl genrsa -out certificado.key 2048
```

- Tenemos que estar en el directorio del usuario

### Crear un archivo csr

```
openssl req -new -key certificado.key -out certificado.csr
```

- Ponemos de contraseña patata

### Crear un archivo crt

```
openssl x509 -req -days 90 -in certificado.csr -signkey certificado.key -out certificado.crt
```

### Agregar el certificado al servidor apache

- Instalar modulo apahce que genera conexiones seguras
```
sudo yum install mod_ssl
```

- Copiar los certificados a los directorios conrrespondientes
```
sudo cp certificado.crt /etc/pki/tls/certs

sudo cp certificado.key /etc/pki/tls/private
```

- Configurar el archivo ssl para que detecte los certificados
```
sudo nano /etc/httpd/conf.d/ssl.conf
```

- Cambiamos la linea SSLCertificateFile y SSLCertificateKeyFile a esto:
```
SSLCertificateFile /etc/pki/tls/certs/certificado.crt

SSLCertificateKeyFile /etc/pki/tls/private/certificado.key
```

- Reiniciamos apache
```
sudo apachectl restart
```

- Añadimos el servicio https a ña zone publica del firewall

```
sudo firewall-cmd --zone=public --add-service=https --permanent
```

- Reiniciamos el firewall
```
sudo firewall-cmd --reload
```

- Añadirmos el puerto 443 a la configuración del usuario:

```
sudo nano /etc/httpd/conf.d/clientes.conf

<VirtualHost *:443>
    DocumentRoot /var/www/clientes
    ServerName alumnos.com
    SSLEngine On
    SSLCertificateFile /etc/ssl/certs/certificado.crt
    SSLCertificateKeyFile /etc/ssl/private/certificado.key
</VirtualHost>
```

- Reiniciamos apache:

```
sudo apachectl restart
```

- Accedemos por https a la página:
```
https://clientes.com
```

- Vamos al apartado de avanzado y aceptamos riesgo y continuamos

- Configurar el archivo de clientes

```
sudo nano /etc/httpd/conf.d/clientes.conf
```

- En el VirtualHost 80 añadimos:
```
Redirect / https://clientes.com
```

- Reiniciamos apache:
```
sudo apachectl restart
```

- Ahora ponemos en el navegador:
```
clientes.com
```

- Solo con poner lo anterior se genera el https automaticamente 

