- [INSTALACIÓN DE APACHE EN CENTOS](#Instalación-de-Apache-en-Centos)
    - [Instalación de Apache](#Instalación-de-apache)
    - [Comandos de gestión de Apache](#Comandos-de-gestión-de-apache)
    - [CONEXIÓN POR SSH A LA MÁQUINA VIRTUAL](#Instalación-de-Apache-en-Centos)
    - [Cuando las IPS son distintas de la maquina virtual y local](#Cuando-las-IPS-son-distintas-de-la-maquina-virtual-y-local)
    - [Cuando coinciden las IPS de la maquina virtual y local](#Cuando-coinciden-las-IPS-de-la-maquina-virtual-y-local)
    - [Manipulación de Apache](#Manipulación-de-apache)
    - [Colocar la IP generada por el puerto como estática para que siempre sea la misma](#Colocar-la-IP-generada-por-el-puerto-como-estática-para-que-siempre-sea-la-misma)
- [AÑADIR UN NOMBRE A LA IP DEL SERVIDOR EN LOS HOSTS](#Añadir-un-nombre-a-la-IP-del-servidor-en-los-hosts)
    - [Cambiar el nombre del hostname](#Cambiar-el-nombre-del-hostname)
    - [En caso de que las IPs no sean iguales (Conexión NAT)](#En-caso-de-que-las-IPs-no-sean-iguales-(Conexión-NAT))
    - [En caso de que las IPs sean iguales](#En-caso-de-que-las-IPs-sean-iguales)
    
- [TRATAMIENTO DEL CONTENIDO DEL SERVIDOR CON FILEZILLA](#Tratamiento-del-contenido-del-servidor-con-FileZilla)

- [SIMULAR DISTINTAS WEBS SOPORTADAS POR EL MISMO SERVIDOR](#Simular-distintas-webs-soportadas-por-el-mismo-servidor)
    - [Asignar la misma IP para cada web](#Asignar-la-misma-IP-para-cada-web)
    - [Asignar 1 IP distinta para cada web (En caso de disponer de 2 IPS)](#Asignar-1-IP-distinta-para-cada-web-(En-caso-de-disponer-de-2-IPS))
    - [Crear una página nueva con un puerto distinto en la misma IP](#Crear-una-página-nueva-con-un-puerto-distinto-en-la-misma-IP)

- [INSTALACIÓN DE PHP Y SUS CONFIGURACIONES](#Instalación-de-PHP-y-sus-configuraciones)

- [AÑADIR UNA PÁGINA DE PHP CON BBDD](#Añadir-una-página-de-PHP-con-BBDD)
    - [Instrucciones dentro del gestor de BBDD](#Instrucciones-dentro-del-gestor-de-BBDD)


- [CONFIGURAR LA SEGURIDAD DE APACHE](#Configurar-la-seguridad-de-apache)
    - [Autenticación básica](#Autenticación-básica)
    - [Autenticación Digest](#Autenticación-Digest)
    - [Control de Acceso](#Control-de-Acceso)
    - [Control de acceso a nivel de carpeta (.htaccess)](#Control-de-acceso-a-nivel-de-carpeta-(.htaccess))
    - [Configuración de SSL (Secure Sockets Layer) en apache](#Configuración-de-SSL-(Secure-Sockets-Layer)-en-apache)
    - [Más cosas de seguridad](#Más-cosas-de-seguridad)



# Instalación de Apache en Centos
Documentación

- Descargamos la iso de la versión minimal de centos en su página web principal.

- Creamos una maquina virtual en VirtualBox con la iso descargada y configuramos el sistema operativo.

- Al crear el usuario en la instalacíon, marcar la casilla de utilizar este usuario como administrador.

## Instalación de apache

- Al inicio poner nombre de usuario y contraseña

- En centOS activamos la red:
```
sudo vi /etc/sysconfig/network-scripts/ifcfg-enp<TAB>
```

- Cambiar al modo edición del resultado de la instrucción anterior para activar la edición de configuración con la "i".

- Cambiamos la última instrucción ONBOOT de "no" a "yes".

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
- Apagar la maquina virtual:
```
sudo shutdown
```

-----

# Conexión por SSH a la máquina virtual

- En el menu de configuración de la maquina virtual en VirtualBox, en el partado red, podemos comprobar que estamos conectados mediante NAT.

- Para comprobar nuestra ip en la maquina virtual:
```
ip addr show
```

- Para comprobar la ip en nuestro propio ordenador utilizamos la misma instrucción que antes. Podemos comprobar que son distintas. 

- Para utilizar la conexión SSH de uno a otro necesitamos estar en la misma IP.

## Cunado las IPS son distintas de la maquina virtual y local

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
ssh rafael@127.0.0.1 -p  2222
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

- Vamos a configuración/red y cambiamos NAT por Adaptador puente

- Volvemos a iniciar la maquina virtual

- Comprobar dirección IP:
```
ip addr show
```

- Apuntar IP ya que se va cambiando cada vez que la iniciemos

- A traves de la terminal de nuestro ordenador ponemos:
```
ssh rafael@IPapuntada
```
- Ya estaremos conectados al servidor

- Iniciamos apache:
```
sudo systemctl start httpd
```

- Abilitar el puerto para que si ponemos la Ip en el navegador aparezca:
```
sudo firewall-cmd --zone=public --add-service=http --permanent
```
- Ahora hay que reiniciar el firewall:
```
sudo firewall-cmd --reload
```

## Codigo Importante para Apache:
```
cat /etc/*-release //version sistema Linux

sudo apachectl stop //Para el servidor

sudo apachectl start //Iniciar el servidor

apachectl status //Estado de apache

sudo apachectl restart //reinicia apache pero las conexiones se van

sudo apachectl graceful //Espera que todas la conexiones actuales para reiniciar
```

- Cuando reinicemos centOS apache estará activado: 
```
sudo systemctl enable httpd
```

- Intalar manual:
```
sudo yum install httpd-manual
sudo apachectl restart
```

- Version apache:
```
httpd -v
```

- Crear y administrar servidores:
```
sudo nano /etc/hosts
```

- Instalar nano:
```
sudo yum install nano
```

- Cambiar nombre del ordenador:
```
sudo nano /etc/hostname
```

- Reiniciar servidor:
```
sudo reboot
```

- Archivos configuracion apache:
```
ll /etc/httpd
```

- Archivo de configuración:
```
sudo nano /etc/httpd/conf/httpd.conf
```

## Instrucciones linux

- Saber la version de linux:
```
cat  /etc/*-release
```

- Reiniciar centos: 
```
shutdown -rf now
```


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

-----------------------

Para revisar que los archivos de configuración estén bien:
```
sudo apachectl configtest
```

---------------

## Colocar la IP generada por el puerto como estática para que siempre sea la misma

```
sudo nano /etc/sysconfig/network-scripts/ifcfg-enp0s3
```

- Poner este codigo desde BOOTPROTO:
```
BOOTPROTO=static
IPADDR=192.168.1.El que tengas
NETMASK=255.2555.255.0
GATEWAY=192.168.1.1
DNS1=8.8.8.8
DNS2=8.8.4.4
```

- Para revisar que los archivos de configuración estén bien:
```
sudo apachectl configtest
```

- Reiniciar el servido:
```
sudo reboot
    o
sudo shutdown -r now
```

### Instalación de nano 
```
sudo yum install nano
```

- Ahora podemos ver el archivo de configuración de apache con nano.
```
sudo nano /etc/httpd/conf/httpd.conf
```
-----

# Añadir un nombre a la IP del servidor en los hosts

## Cambiar el nombre del host

- Revisar el nombre del servidor:
```
cat /etc/hostname 
```
- Cambiar el nombre del servidor:
```
sudo nano /etc/hostname
```

## En caso de que las IPs no sean iguales (Conexión NAT)

- Cambiar el archivo de hosts para relacionar IPs con URLS, por ejemplo que 127.0.0.1 se llame servidor y podamos acceder mediante el nombre "servidor" en el navegador, para que funcione hay que reiniciar:
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
ssh rafael@servidor -p 2222
```

- Ahora podemos acceder al servidor con el navegador mediante:
```
servidor:3333
```

- Mi servidor para entrar:
```
ssh miservidor
```

## En caso de que las IPs sean iguales

- Añadir en el archivo hosts la ip proporcionada por el puente con el nombre que nosotros queramos tanto en el servidor como en local.

```
sudo nano /etc/hosts

(ip generada) servidor
```
- Salir del servidor:
```
exit
```

```
sudo nano /etc/hosts

(ip generada) servidor
```

- Entrar en el servidor desde local:
```
ssh rafael@ (nombre especificado en el hostname o la ip generada por el puente)
```

- Ya podriamos acceder al servidor desde el navagador local con el nombre del host que hayamos puesto en la direccion generada por el puente de envios.
```
servidor/
```

# Tratamiento del contenido del servidor con FileZilla

- Instalar filezilla
```
sudo apt install filezilla
```

- Poner un nuevo sitio en filezilla desde el icono arriba a la izquierda.

- Poner nuestra ip, el puerto 22 y por protocolo SSH.

- Modo de acceso normal, y ponemos nuestro usuario y contraseña

- Despues de guardarlo, accedemos a un nuevo sitio desde la flecha de accion debajo del icono de arriba a la izquierda que hemos pulsado antes.

- Ahora conectados al servidor podemos crear carpetas y demas y observarlas desde el FIleZilla.

- Podemos subir archivos de local al FileZilla y de esa manera meter archivos al servidor.

## Instalar ZIP
```
sudo yum install unzip
```

# Simular distintas webs soportadas por el mismo servidor

- Salir de ssh
- Entrar en Descargas
- Y descargar el archivo del aula virtual en el directorio
- Una vez lo tengamos en Descargas ejecutar la siguiente intrucción para copiar por ssh el archivo establecemos la ruta del servidor (ojo, lo normal es no tener la carpeta creada de Descargas): 
```
scp ./web_daw.zip rafael@servidor:/home/rafael/Descargas/web_daw.zip
```
- Cambiar el tiempo de espera de conexión de FIlezilla desde Edición opciones a uno superior
- Conectar el Filezilla al servidor
- Descomprimir el archivo con unzip

- Creamos dos carpetas donde poner nuestras paginas:
```
ssh rafael@(ip generada)
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

-Mirar permisos:
```
ll /var/www/
ll /var/www/carpeta1/
ll /var/www/carpeta2/
```

## Asignar la misma IP para cada web

- Ver la configuración de apache
 ```
 ll /etc/httpd/conf.d
 ```

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

## Asignar 1 IP distinta para cada web (En caso de disponer de 2 IPS)

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

- Ponemos dominio diferente:
```
Listen 8080
<VirtualHost *:8080>
        DocumentRoot /var/www/nombre
        ServerName nombre.com
</VirtualHost>
```

- Reiniciamos el servidor
```
sudo apahcectl restart
```

- Abriri el puerto en firewall:
```
sudo firewall-cmd --add-port=8080/tcp --permanent
```

- Reiniciamos firewall:
```
sudo firewall-cmd --reload
```

# Instalación de PHP y sus configuraciones

- Ver modulos:
```
httpd -M
```

- Primero cambiar este archivo a como lo teniamos anteriormente:
```
sudo nano /etc/sysconfig/network-scripts/ifcfg-enp0s3
```

- Cambiar el Gateaway:
```
GATEWAY=192.168.1.2
```

- Reiniciar el servidor:
```
sudo service network restard
```

- Instalar PHP en centos:
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

 Instalar dependencias de PHPMyAdmin

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


- Devolvemos el archivo "ifcfg-enp0s3" a como lo teniamos antes de instalar PHP.


# Añadir una página de PHP con BBDD

- Crear el archivo:
```
sudo nano /var/www/index.php
<?php phpinfo(); ?>
```

- Reiniciamos:
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

# Instalar MySQL

- Instalarlo:
```
sudo yum install mariadb mariadb-server
```

- Pregunatar por el estado:
```
sudo systemctl status mariadb
```

- Ponerla en marcha:
```
sudo systemctl start mariadb
```

- Habilitar BBDD al inicio del servidor:
```
sudo systemctl enable mariadb
```

- Configurar la base de datos:
```
sudo mysql_secure_installation
```
## Instrucciones dentro del gestor de BBDD

- Para ver si va entramos en el gestor de la BBDD:
```
mysql -u root -p
```

- Mostrar database:
```
show DATABASES;
```

- Crear elemento en database:
```
create DATABASE nombre;
```

- Salir database:
```
quit;
```

- Instalar dependencias PHPmyAdmin:
```
sudo yum install php-pecl-zip php-mbstring
```

- Instalar PHPmyAdmin:
```
sudo yum install phpmyadmin
```

- Modoficar archivo de configuracion de phpmyadmin:
```
sudo nano /etc/httpd/conf.d/phpMyAdmin.conf
Destro comentamos <RequireAny> asta  </RequireAny> con #
Ponemos -->  Require all granted
```



# Poner archivo desde terminal al local

```
cd Descargas
scp ./archivo nombre_servidor:/home/rafael/archivo
```

# Configurar seguridad Apache

## Autenticación básica

- Crear en la web de clientes que solo pueda acceder el administrador

- Creamos carpeta para poner a los admin
```
sudo mkdir /var/www/clientes/admin
```

- Creamos un hatml en admin:
```
sudo nano /var/www/clientes/admin/index.html
```

- Creamo una carpeta donde guardamos los passwords:
```
sudo mkdir /etc/httpd/password
```

- Creamos el archivo para passwords:
```
sudo htpasswd -c /etc/httpd/password/passwords-admin admin
```

- Ver admin:
```
cat /etc/httpd/password/passwords-admin
```

- Si queremos crear más passwords ponemos:
```
sudo htpasswd /etc/httpd/password/passwords-admin admin2
```

- Restringir el acceso:
```
sudo nano /etc/httpd/conf.d/clientes.conf
```

- Ponemos
```
<Directory "/var/www/clientes/admin">
    AuthType Basic
    AuthName "Administrador"
    AuthUserFile /etc/httpd/password/passwords-admin
    Require valid-user
</Directory>
```

- Si quisieramos que solo uno pueda acceder ponemos:
```<Directory "/var/www/clientes/admin">
    AuthType Basic
    AuthName "Administrador"
    AuthUserFile /etc/httpd/password/passwords-admin
    Require user admin
</Directory>
```

- Mirar si esta bien puesto:
```
sudo apachectl configtest
```

- Reiniciamos apache:
```
sudo apachectl restart
```

## Autenticación Digest

- Creamos carpeta para poner a los admin
```
sudo mkdir /var/www/proveedores/admin
```

- Creamos un hatml en admin:
```
sudo nano /var/www/proveedores/admin/index.html
```

- Creamos el archivo para passwords:
```
sudo htdigest -c /etc/httpd/password/digest "administradores" admin
```

- Ver el admin:
```
cat /etc/httpd/password/digest
```

- Restringir el acceso:
```
sudo nano /etc/httpd/conf.d/proveedores.conf 
```

- Ponemos:
```
<Directory "/var/www/proveedores/admin">
    AuthType Digest
    AuthName "administradores"
    AuthUserFile /etc/httpd/password/digest         
    Require valid-user
</Directory>
```

- Mirar si esta bien puesto:
```
sudo apachectl configtest
```

- Reiniciamos apache:
```
sudo apachectl restart
```

## Control de acceso

- Creamos otra parte de la web
```
sudo mkdir /var/www/clientes/gestion
```

- Creamo una web dentro de gestion:
```
sudo nano /var/www/clientes/gestion/index.html
```

- Restringir acceso mediante ip:
```
sudo nano /etc/httpd/conf.d/clientes.conf

<Directory "/var/www/clientes/gestion">
    <RequireAll>
     Require all denied
    </RequireAll>
</Directory>
```

- Hacer que solo nos deje entrar con nuestra IP Local:
```
<Directory "/var/www/clientes/gestion">
    <RequireAll>
     # Require all denied
       Require ip ipLocal
    </RequireAll>
</Directory>
```

- Que todos puedan entrar excepto la ip que yo desee:
```
<Directory "/var/www/clientes/gestion">
    <RequireAll>
     # Require all denied
       Require all granted 
       Require not ip RandomIp
    </RequireAll>
</Directory>
```

- Un rango de IPs puedan acceder a la red:
```
<Directory "/var/www/clientes/gestion">
    <RequireAll>
       Require ip 192.168.1
       Require ip 192.168.1.0/255.255.255.0
       Require ip 192.168.1.0/24
    </RequireAll>
</Directory>
```

## Control de acceso a nivel de carpeta(.htaccess)

- Creamos carpeta para htaccess
```
sudo mkdir /var/www/clientes/testhtaccess
```

- Datos.txt
```
sudo nano /var/www/clientes/testhtaccess/datos.txt
```

- Añadimos
```
sudo nano /etc/httpd/conf.d/clientes.conf

<Directory "/var/www/clientes/testhtaccess">
    AllowOverride All
    Options Indexes
</Directory>

```
- Creamos un archivo htaccess, en el cual podremos configurar testhtaccess de forma inmediata sin necesidad de reiniciar apache:
```
sudo nano /var/www/clientes/testhtaccess/.htaccess
```

- Añadimos:
```
Require all denied
```
Y reiniciamos apache

## Configuración de SSL (Secure Sockets Layer) en apache

- Si queremos que nuestra web tenga conexión segura debemos usar SSL

- Instalar srvidor SSl:
```
sudo yum install openssl
```
### Crear clave privada

```
openssl genrsa -out certificado.key 2048
```

### Crear archivo csr

```
openssl req -new -key certificado.key -out certificado.csr
```

- Tenemos que estar en el directorio del usuario

### Crear archivo crt

```
openssl x509 -req -days 90 -in certificado.csr -signkey certificado.key -out certificado.crt
```

### Agregar el certificado al servidor

- Instalar modulo apache que genera conexiones seguras
```
sudo yum install mod_ssl
```

- Copiar los archivos:
```
sudo cp certificado.crt /etc/pki/tls/certs 
sudo cp certificado.key /etc/pki/tls/private
```

- Configurar el archivo ssl para que detecte los certificados:
```
sudo nano /etc/httpd/conf.d/ssl.conf
```

- Cambiamos las lineas:
```
SSLCertificateFile /etc/pki/tls/certs/certificado.crt
SSLCertificateKeyFile /etc/pki/tls/private/certificado.key
```

- Reiniciamos apache:
```
sudo apachectl restart
```

- Abrimos el puerto:
```
sudo firewall-cmd --zone=public --add-service=https --permanent
sudo firewall-cmd --reload
```

- Accedemos por https a la página:
```
https://clientes.com
```

- Vamos al apartado de avanzado y aceptamos riesgo y continuamos

- Configurar el archivo de clientes
```
sudo nano /etc/httpd/conf.d/clientes.conf

<VirtualHost *:80>
        DocumentRoot /var/www/clientes
        ServerName clientes.com
       	Redirect / https://cleintes.com
</VirtualHost>

<VirtualHost *:443>
    DocumentRoot /var/www/clientes
    ServerName clientes.com
    SSLEngine On
    SSLCertificateFile /etc/pki/tls/certs/certificado.crt
    SSLCertificateKeyFile /etc/pki/tls/private/certificado.key
</VirtualHost>
```

- Y reiniciamos apache
- Reiniciamos apache:
```
sudo apachectl restart
```

- Ahora ponemos en el navegador:
```
clientes.com
```

- Solo con poner lo anterior se genera el https automaticamente 

## Más cosas de seguridad
```

```

