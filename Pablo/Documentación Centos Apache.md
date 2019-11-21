# Documentación instalación de SO Centos en virtualBox e instalación de Apache.
- Intalar la iso minimal de Centos.

- Crear una máquina virtual en VBox con la ISO de Centos, dejar todo predeterminado, excepto lo de añadir el disco duro. 

- Crear un usuario y contraseña root. Marcar el usuario como administrador

Instalar apache en Centos:
```
sudo vi /etc/sysconfig/network-scripts/ifcfg-enp0s3
```
- cambiar al modo edición con "i"
- Cambiar la última instrucción de no a yes
- Salir del modo edición "ESC"
- Para guardar :wq
- Reiniciar el servidor:
```
sudo service network restart
```
- Comprobar con un "ping" para ver que funciona y para detener la ejecución "control+C"

-Instalar apache:
```
sudo yum install httpd 
```
- Preguntar el estado de Apache:
```
systemctl status httpd
```

- Arrancar el servidor:
```
sudo systemctl start httpd
```

Conexión por SSH

- Menu de la maquina virtual de vBox, en el apartado red, comprobar que estamos conectados por nav.

- Para comprobar nuestra IP en la máquina virtual y en el própio ordenador:
```
ip addr show
```
- Comprobar ip en la máquina virtual.

- Necesitamos estar en la misma IP para la conexión ssh.

- En configuración de red, apartado avanzados, se puede hacer un reenvio de puertos.

- Creamos una nueva regla de reenvios.

```
Protocolo: TCP
IP anfitrión: 127.0.0.1 (ip ordenador)
Puerto anfitrión: 2222
IP invitado: 10.0.2.15 (ip de la maquina)
Puerto invitado: 22
```
- Ejecutar en la consola del ordenador la conexión a la máquina virtual mediante el puente.
```
ssh pablo@127.0.0.1 -p 2222
```
---------
Si aparece algun error:

-Instalar el servidor de ssh:
```
sudo yum install openssh-server
```

-Abrir el firewall para conexiones http:
```
sudo firewall-cmd --zone=public --add-service=http --permanent
```
-Abrir el firewall para conexiones ssh:
```
sudo firewall-cmd --zone=public --add-service=ssh --permanent
```
-Reiniciar el firewall:
```
sudo firewall-cmd --reload
```
---------------------------
-Para ver la version de apache(consola local):
```
httpd -v o httpd -V
```
-Establecer una regla de reenvios, y buscar en el navegador local 127.0.0.1:3333 (ejempo puerto anfitrión) para ver la página de apache.

-Para ver estado de apache desde local:
```
apachectl status
```
-Para parar o iniciar o reiniciar el servidor apache hacer desde local:
```
apachectl stop
apache start
apache restart
```
-Hacer que el sistema arranque el servidor de apache cuando inicie:
```
sudo systemctl enable httpd
```
-Instalamos el manual
```
sudo yum install httpd-manual
```
-Reiniciamos apache y accedemos al manual mediante:
```
apachectl restart
127.0.0.1/3333/manual/
```
```
cd /etc/httpd
ll
```
- En conf esta el archivo de configuración de apache.
- En conf .d podemos crear archivos de configuración parciales.
- En conf modules .d la configuración de los modulos.
- En logs las respuestas del servidor.
- En modules para acceder a los modulos.
-----
-Instalación de nano
```
sudo yum install nano
```
-Podemos ver el archivo de configuración de apache con nano.
```
sudo nano /etc/httpd/conf/httpd.conf
```
------
-Para revisar que los archivos de configuración esten bien:
```
sudo apachectl configest
```
-----
-Revisar el nombre del servidor:
```
cat /etc/hostname
```
-Cambiar el nombre del servidor:
```
sudo nano /etc/hostname
```
-Cambiar el aarchivo de hosts para relacionar IPs con URLS, por ejemplo que 127.0.0.1 se llame servidor y podamos acceder mediante el nombre "servidor" en el navegador, para que funcione hay que reiniciar:
```
sudo nano /etc/hosts
sudo reboot
```
-Ahora que estamos fuera de la conexión servidor, configuramos el archivo hosts de local:
```
sudo nano /etc/hosts
"y ponemos el mismo nombre dereferencia de la dirección 127.0.0.1 (servidor)"
```
-Volvermos a conectarnos al servidor por ssh:
```
ssh pablo@servidor -p 2222
```
-Ahora podemos acceder al servidor con el navegador mediante:
```
servidor: 3333
```