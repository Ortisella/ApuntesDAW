# SET UP DE CENTOOS

- modificar el archivo /etc/sysconfig/network-script/ifcfg-enp0s3 con vi
  - Pera editar texto con vi, pulsar i
- ediary poner yes
- 'esc' y ':wq' para salir de la edición y guardar y salir (w: write, q: quit)
- `sudo service network restart` para reiniciar el adaptador de red y se apliquen los cambios
(podemos comprovar el correcto funcionamiento haciendo un ping a cualquier dirección)

# SET UP DE APACHE

- `sudo yum install httpd` y responder siempre 'yes' a las preguntas
- `systemctl status httpd` para ver el status de apache
- `sudo systemctl start httpd` para iniciar apache
- `ip addr show` nos muestra la **dirección ip** de la maquina virtual
- En la máquina virtual añadir la redirección de puertos de 127.0.0.1 en el puerto 2222 a la <dirección ip> de la máquina en el puerto 22
- ssh joanVicens@<dirección ip> -p 2222 para connectarnos de forma remota al servidor

## POSIBLES PROBLEMAS:
 1. ssh no instalado:
  1. `sudo yum install openssh-server`
 2. Algún problema con el *firewall*:
  1. ssh cortado: `sudo firewall-cmd --zone=public --add-service=ssh --permanent`
  2. http cortado: `sudo firewall-cmd --zone=public --add-service=http --permanen`
  (para cualquier de estos cambios hace falta recargar el *firewall*: `sudo firewall-cmd --reload`

# FUNCIONAMIENTO BÁSICO DE APACHE (HTTPD)

### Comándos útiles
  - Ver la distribución en la que estamos trabajando: `cat /etc/*-release`
  - Ver la versión de apache que está instalada: `httpd -v`
  - Información sobre el estado del servidor apache: `apachectl status`
  - Iniciar el servidor: `apachectl start`
  - Parar el servidor: `apachectl stop`
  - Reiniciar el servidor: `apachectl restart`
  - Reiniciar el servidor sin matar las peticiones en proceso: `apachectl graceful`

 - Para que cada vez que se inicia el sistema también lo haga apache: `sudo systemctl enable httpd`
 - `sudo yum install httpd-manual` para instalar el manual de apache `/manual` en el navegador para acceder a él

## Estructura de apache

**Apache se encuentra en la carpeta /etc/httpd**

* Archivos:
  * conf -> configuracón general de apache
  * conf.d -> configuración parcial para diferentes dominios, etc
  * conf.modules -> configuración del modulos
* Diectorios:
  * logs -> dónde se guardan los logs
  * modules -> dónde se instalan los módulos


### Archivo de configuración /etc/httdp/conf/httpd.conf

* serverRoot: guarda la dirección *root* del servidor
* Listen <num>: el puerto en que el servidor escuhca, por defecto es 80
* ServerAdmin: la dirección de correo del administrador del servidor

* Permisos de acceso
```
<Directory />
  AllowOverride none
  Require all denied
</Directory>
```
  Deniega el acceso al sistema de archivos desde el navegador

* DocumentRoot "/var/www/html": la dirección desde la que se sirven las páginas

* *<IfModule />* La configuración de los módulos

* `apachectl configtest`: comprueva que el arxivo de configuración no tenga errores de sintacxis

* `cat /etc/hostname`: muestra el nombre del servidor

### Cambio de nombre del servidor

 1. cambiar el nombre del servidor: `sudo nano /etc/hostname`y cambir el nombre
 2. `sudo nano /etc/hosts`: cambiar el texto por el nombre del servidor (este archivo vincula direcciones IP con dominios)

## CANVIAR LA ASSIGNACIÓ DE IP
 modificar el arxiu: `/etc/sysconfig/network-scripts/ifcfg-enp0s3`:
 * Canviar:
   * BOOTPROTO a static
 * Afegir:
     * IPADDR a la adressa IP actual
     * NETMASK amb \24
     * GATEWAY amb 192.168.1.2

## AFEGIR UNA WEB A UN DOMINI NOU
1. Crear un nou directori a la carpeta /var/www/
1. copiar la web amb filezilla o `scp ./<nom_arxiu> joanvicens@centos:<adreça>+<nom_arxiu>` al directori (crear diferents directoris per a diferents dominis)
1. crear la configuració de la web `sudo nano /etc/httpd/conf.d/<nom_del_web>.conf`:
    ```
    <VirtualHost *:80>
       DocumentRoot /var/www/<nom_diretori>
       ServerName <nom_domini>
    </VirtualHost>
    ```
    * **NO UTILIZAR TABS EN AQUEST ARXIU!!!!**

1. `sudo apachectl restart` per a reiniciar el servidor amb la nova configuració

SI TENIM VARIES DIRECCIONS IP:
modificar els arxius de config per a que tinguin eixa ip en lloc de ' * '

## AFEGIR UNA WEB A UN PORT
1. Crear el directori com abans
1. Afegir al arxiu de la confiuració (`/etc/httpd/conf.d/<nom_del_web>.conf`):
  + La directiva 'Listen <port>' (normalment si s'utilitza un altre port que no siua el 80 s'utilitza el 8080)
  + El port després de la direeció IP


### Permisos del sistema
* 644 per a arxius
* 755 per a carpetes

### Comandos útils
* `rm -r` per a borrar carpetes amb arxius
* `rmdir` per a borrar caprtes buides
* `apachectl configtest` per a assegurar-nos que la configuració no te errors

## INSTAL·LACIÓ DE PHP

1. llistar dels mòduls instal·lats `httpd -M`

2. afegir un repositori per a instal·lar i actualitzar php `sudo yum install epel-release yum-utils`

3. * `yum-config-manager --enable remi-php72`
   * `sudo yum install php php.common phph.opcache`
   * `sudo yum install php-gd php-curl php-mysqlnd`


o  `sudo yum install php php-mcrypt php-cli php-gd php-curl php-mysql php-ldap php-zip php-fileinfo`

+info: https://www.tecmint.com/install-php-7-in-centos-7/
