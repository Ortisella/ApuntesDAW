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

## Cuando las IPS son distintas de la maquina virtual y local.

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

-----------------------

Para revisar que los archivos de configuración estén bien:
```
sudo apachectl configtest
```

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
### Cambiar el nombre del host

- Revisar el nombre del servidor:
```
cat /etc/hostname 
```
- Cambiar el nombre del servidor:
```
sudo nano /etc/hostname
```
---

# Cambiar el nombre del los hosts para un acceso más sencillo
## En caso del primer ejemplo de que las ips no sean iguales (Conexión NAT)

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

## En el caso de establecer la conexión por el puente

- Añadir en el archivo hosts la ip proporcionada por el puente con el nombre que nosotros queramos tanto en el servidor como en local.

```
sudo nano /etc/hosts
```
- Salir del servidor en local:
```
sudo reboot
```

- Entrar en el servidor desde local:
```
ssh cristian@(ip generada por el puerto de envios)
```

- Ya podriamos acceder al servidor desde el navagador local con el nombre del host que hayamos puesto en la direccion generada por el puente de envios.
```
servidor/
```


-------------------------------------------
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

-----
## Instalar ZIP
```
sudo yum install unzip
```
-----

## Colocar la IP generada por el puerto como estática para que siempre sea la misma
```
sudo nano /etc/sysconfig/network-scripts/ifcfg-enp0s3
```
- Cambiar BOOTPROTO de DHPC A static
- Crear una linea con IPADDR=(ip generada por el puerto)
- Crear una linea con NETMASK=(con la mascara generada por el puerto)(255.255.255.0)
- Crear una linea con GATEWAY=192.168.1.1
- Crear una linea con DNS1=8.8.8.8
- Crear una linea con DNS2=8.8.4.4
- Reiniciar el servidor para volver a ver la IP que genera y debería ser la misma siempre

----

# Simular 2 webs distintas soportadas por el mismo servidor

- Salir de ssh
- Entrar en Descargas
- Y descargar el archivo del aula virtual en el directorio
- Una vez lo tengamos en Descargas ejecutar la siguiente intrucción para copiar por ssh el archivo establecemos la ruta del servidor (ojo, lo normal es no tener la carpeta creada de Descargas): 
```
scp ./web_daw.zip cristian@servidor:/home/cristian/Descargas/web_daw.zip
```
- Cambiar el tiempo de espera de conexión de FIlezilla desde Edición opciones a uno superior
- Conectar el Filezilla al servidor
- Descomprimir el archivo con unzip

- A continuación creamos 2 carpetas en el servidor para cada web en la carpeta dedicada a webs
```
ssh cristian@(ip generada)
sudo mkdir /var/www/clientes
sudo mkdir /var/www/proveedores
```

- Ahora copiamos el contenido la web que hemos pasado y descomprimido previamente a cada una de las dos carpetas
```
cd Descargas
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

## Crear los VirtualHost de cada web en los archivos de configuración de apache
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

 ## Asignar IPS para las web
 - Desde local vamos a editar el archivo hosts

 - Añadimos las IPS (previamente compradas) para clientes y proveedores, pero como solo tenemos la del servidor pues ponemos esa para los 2
 ```
192.168.1.181 clientes.com
192.168.1.181 proveedores.com
 ```

 - Y reiniciamos apache

 - Ahora ya podemos acceder a cada web por sus accesos en el navegador
 ```
 clientes.com
 proveedores.com
 ```
------
## Generar 1 IP para cada web ( En caso de disponer de 2 IPS )
- Cerramos la maquina virtual
- Añadirmos otro adaptador puente en el virtualBox desde la configuracion web
- Volvemos a iniciar la máquina virtual

- Vemos que IPS nos ha generado
```
ip addr show
```

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

- Y ponemos que una de ellas apunte a la ultima IP generada

-----

## Crear una pagina nueva con un puerto distinto por si tenemos solo una IP

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
# Instalación de PHP y sus configuraciones
- Comporbar que modulos tenemos instalados:

```
httpd -M
```

- Primero cambiar este archivo a como lo teniamos anteriormente:
```
sudo nano /etc/sysconfig/network-scripts/ifcfg-enp0s3
```

- Cambiar el Gateway a:
```
GATEWAY=192.168.1.2
```

- Reiniciar la red (Si ha generado una red distinta, habra que cambiarla de todos los sitios): 
```
sudo service network restart
```

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

- Devolvemos el archivo "ifcfg-enp0s3" a como lo teniamos antes de instalar PHP.

















