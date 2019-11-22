# Documentación Centos 3
---------------------------------------
# Poner IP estática para que siempre sea la misma
- Realizar en la consola de ubuntu conectada al servidor por ssh:
``` 
sudo nano /etc/sysconfig/network-scripts/ifcfg-enp<TAB>
```
- Cambiar Bootproto=static
- Poner una nueva linea: IPADDR=192.168.1.182
- Poner nueva linea: NETMASK=255.255.255.0
- Poner otro: GATEWAY=192.168.1.1 // o 1.2 En clase de Emilio
- otro: DNS1=8.8.8.8
- otro: DNS2=8.8.4.4

- Reiniciar servidor y comprobar que tenemos la misma IP:
```
sudo reboot
ip addr show
```

# Crear dos dominios para una sola ip(VistualHosts) 
- Abrir filezilla y conectarse al servidor

# Si no funciona filezilla hacer esto:
- Desde consola de ubuntu en descargas, para pasar el archivo al del servidor:
```
scp ./web_daw.zip pablo@miservidor:/home/pablo/web_daw.zip
```
# -------------------------------------
- Descomprimir el .zip desde el servidor, viajar a Descargas:
```
unzip web_daw.zip
```
- Crear dos sitios WEbs, dos carpetas:
```
sudo mkdir /var/www/clientes
sudo mkdir /var/www/proveedores
ll /var/www/
```

-La web descargada copiarla a las dos carpetas creadas, solo lo que contiene(descomprimida), Realizarlo desde el directorio donde se encuentre la carpeta a copiar en el destino (ejemplo: Descargas):
```
sudo cp -R web_daw/* /var/www/clientes/
sudo cp -R web_daw/* /var/www/proveedores/
```

-Para poder editar el index de la web_daw de clientes por ejemplo:
```
sudo nano /var/www/clientes/index.html
```

-Cambiar del archivo index de cada uno "web para clientes" y "web para proveedores"

- Poner PERMISOS si no funciona:
```
644 (rw-r--r--) para archivos
755 (rwxr-xr-x) para carpetas
```
- Configuración del directorio conf.d de Apache:
```
ll /etc/httpd
```
- Configurar archivos:(clientes y proveedores)
```
sudo nano /etc/httpd/conf.d/clientes.conf
sudo apachectl restart
```
- Poner en archivos(clientes y proveedores) para asignarles un nombre de servidor que hace referencia a un documento(Buscará el fichero index):
```
<VirtualHost *:80>
    DocumentRoot /var/www/clientes
    ServerName clientes.com
</VirtualHost>
```

- Abrir otra terminal y poner esto para añadir la misma IP que tenemos para Clientes.com y proveedores.com:
```
sudo nano /etc/hosts
192.168.1.182    clientes.com
192.168.1.182    proveedores.com
```
- Buscar en el navegador clientes.com y proveedores.com y para cada uno aparecerá su documento asignado(Reiniciar apache).

- Si aparece algun error poner esto:
```
sudo apachectl configtest
```

# Virtualbox configurador de red 2 dominios distintas ips
- Añadir otro adaptador puente
- Acceder al servidor y comrpobar ip y apuntar ips adaptadores:
```
ip addr show
```
- Editar de nuevo los archivos conf de clientes y proveedores y añadirles las ips, distinta para acda uno.
```
sudo nano /etc/httpd/conf.d/clientes.conf
//192.168.1.199 sería la nueva ip para proveedores
<VirtualHost 192.168.1.199:80>
    DocumentRoot /var/www/proveedores
    ServerName proveedores.com
</VirtualHost>
```
- Para poner la IP nueva de enp0s8 a statica realizar esto:
- Crear en enp0s8 y rellenarlo con los datos parecidos a enps03
```
sudo nano /etc/sysconfig/network-scripts/ifcfg-enp0s8
TYPE=Ethernet
PROXY_METHOD=none
BROWSER_ONLY=no
BOOTPROTO=static
IPADDR=192.168.1.22 ##Nueva IP adaptador puente
NETMASK=255.255.255.0
GATEWAY=192.168.1.1
DNS1=8.8.8.8
DNS2=8.8.4.4
DEFROUTE=yes
IPV4_FAILURE_FATAL=no
IPV6INIT=yes
IPV6_AUTOCONF=yes
IPV6_DEFROUTE=yes
IPV6_FAILURE_FATAL=no
IPV6_ADDR_GEN_MODE=stable-privacy
NAME=enp0s8
UUID=62fe9b62-35ba-4db9-8131-0aa00ef80357
DEVICE=enp0s8
ONBOOT=yes
```

- Cambiar en la lista de host las ips para clientes y proveedores

- Borrar caché si falla 

- Volver a dejar las ips como antes, reiniciar y eliminar el adaptador puente
```
<VirtualHost *:80>
    DocumentRoot /var/www/clientes
    ServerName clientes.com
</VirtualHost>

127.0.0.1       localhost
127.0.1.1       MateAulas
192.168.1.182   miservidor
192.168.1.182   clientes.com
192.168.1.182   proveedores.com
```
- Eliminar lo de enp0s8 si hubiesemos creado un enp0s8 estática:
```
sudo nano /etc/sysconfig/network-scripts/ifcfg-enp0s8
//Borrar todo lo del directorio//
```
- Reiniciar
```
sudo apachectl restart
```
# Crear directorio trabajadores y acceder por puerto
- Crear directorio y copiar lo de clientes a trabajadores
```
sudo mkdir /var/www/trabajadores
sudo cp -R /var/www/clientes/* /var/www/trabajadores
```
- Modificar index de trabajadores:
```
sudo nano /var/www/trabajadores/index.html
``` 

- Modificar trabajadores config():
```
sudo nano /etc/httpd/conf.d/trabajadores.conf
Listen 8080
<VirtualHost *:8080>##Accede por cualquier ip si hubiera más de una
        DocumentRoot /var/www/trabajadores
        ServerName trabajadores.com
</VirtualHost>

```
- Abrir puerto 8080 en el firewall:
```
sudo firewall-cmd --add-port=8080/tcp --permanent
sudo firewall-cmd --reload
```

- Solo se puede acceder a trabajadores desde el navegador por ip 192.68.1.182:8080, porque accede por puerto, no esta en la lista de hosts.

- Si tuvieramos dos ips, el puerto entra por defecto por los dos, pero si quisieramnos que acceder por un puerto en concreto poner esto:
```
Listen 8080
<VirtualHost 192.168.1.21:8080>##192.168.1.21 seria por la ip que accedería 
        DocumentRoot /var/www/trabajadores
</VirtualHost>

```
- Se podria añadir esta ip/puerto a hosts para entrar por dominio

### Para poner puertos que no sean 8080
```
sudo yum -y install policycoreutils-python
sudo semanage port -a -t http_port_t -p tcp (puerto)
```
- Si da error:
```
sudo semanage port -m -t http_port-t -p tcp (puerto)
sudo apachectl restart
```

# Servidor modulo Apache y php
- Mostrar modulos de Apache:
```
httpd -M
```
- Comprobar que funciona internet si no cambiar a dhcp.
- Cambiar Gateway a 1.2 al final(Solo si estas en clase)
```
sudo nano /etc/sysconfig/network-scripts/ifcfg-enp<TAB>
```
- Instalar cosas:
```
sudo yum install epel-release yum-utils
```
- Luego poner esto:
```
sudo service network restart
sudo yum install http://rpms.remirepo.net/enterprise/remi-release-7.rpm
```
- Poner:
```
sudo yum-config-manager --enable remi-php72
```
- Poner esto:
```
sudo yum install php php-common php-opcache php-mcrypt php-cli
sudo yum install php-gd php-curl php-mysqlnd
```
- Listar contenido:
```
ll /etc/httpd/conf.modules.d
```

