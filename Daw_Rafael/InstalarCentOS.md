# Instalación de Apache en Centos
Documentación

- Descargamos la iso de la versión minimal de centos en su página web principal.

- Creamos una maquina virtual en VirtualBox con la iso descargada y configuramos el sistema operativo.

- Al crear el usuario en la instalacíon, marcar la casilla de utilizar este usuario como administrador.

## Instalación de apache

- Al inicio poner nombre de usuario y contraseña

- En centOS:
```
sudo vi /etc/sysconfig/network-scripts/ifcfg-enp<TAB>
```

- Cambiar al modo edición del resultado de la instrucción anterior para activar la edición de configuración con la "i".

- Cambiamos la última instrucción de "no" a "yes".

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
- Apagar la mv:
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

## Cuando coincides las IPS de la maquina virtual y local

- Vamops a configuración/red y cambiamos NAT por Adaptador puente

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

# Colocar la IP generada por el puerto como estática para que siempre sea la misma

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

- Reiniciar el servido:
```
sudo reboot
    o
sudo shutdown -r now
```

# Poner archivo desde terminal al local

```
cd Descargas
scp ./archivo nombre_servidor:/home/rafael/archvo
```
