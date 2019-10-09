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
