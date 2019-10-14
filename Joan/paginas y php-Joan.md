## CANVIAR LA ASSIGNACIÓ DE IP
 modificar el arxiu: `/etc/sysconfig/network-scripts/ifcfg-enp0s3`:
 * Canviar:
   * BOOTPROTO a static
 * Afegir:
     * IPADDR a la adressa IP actual
     * NETMASK amb \24
     * GATEWAY amb 192.168.1.1

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
    * NO UTILIZAR TABS EN AQUEST ARXIU!!!!

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
