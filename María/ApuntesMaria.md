# APUNTES: DESARROLLO DE APLICACIONES WEB


## Índice
- [MARKDOWN CHEATSHEET](#markdown-cheatsheet)
    - [Enlaces internos](#enlaces-internos)
    - [Títulos](#títulos)
    - [Énfasis](#énfasis)
    - [Listados](#listados)
    - [Incluir imágenes](#incluir-imágenes)
    - [Blockquotes](#blockquotes)
    - [Saltos de línea](#saltos-de-línea)

- [FUNCIONAMIENTO DE GIT](#funcionamiento-de-git)
    - [Crear cuenta e instalar GitHub](#crear-cuenta-e-instalar-github)
    - [Clonar repositorio remoto](#clonar-repositorio-remoto)
    - [Instrucciones básicas de GitHub](#instrucciones-básicas-de-github)
    - [Ramas](#ramas)

- [ÁREA DE TRABAJO EN UBUNTU](#área-de-trabajo-en-ubuntu)
    - [Crear usuario](#crear-usuario)
    - [Instrucciones básicas de terminal](#instrucciones-básicas-de-terminal)
    - [Hosts y hostnames](#hosts-y-hostnames)
    - [Instalación de Visual Studio Code](#instalación-de-visual-studio-code)
    - [Instalación de VirtualBox](#instalación-de-virtualbox)

- [CENTOS](#centos)
    - [Instalación en entorno virtualizado](#instalación-en-entorno-virtualizado)
    - [Instrucciones básicas de Apache en CentOS](#instrucciones-basicas-de-apache-en-centos)
    - [Conexión SSH con IPs diferentes](#conexión-ssh-con-ips-diferentes)
    - [Conexión SSH con IPs que coinciden](#conexión-ssh-con-ips-que-coinciden)
    - [Poner la IP estática](#poner-la-ip-estática)
    - [Subir archivos a servidor CentOS](#subir-archivos-a-servidor-centos)
    - [Módulo de Apache para gestionar PHP](#módulo-de-apache-para-gestionar-php)
    - [Simular que tenemos varios dominios en el mismo servidor](#simular-que-tenemos-varios-dominios-en-el-mismo-servidor)
    - [Simular que tenemos varios dominios en la misma IP](#simular-que-tenemos-varios-dominios-en-la-misma-ip)
    - [Simular que tenemos varios dominios en varias IP](#simular-que-tenemos-varios-dominios-en-varias-ip)
    - [Simular que tenemos varios dominios en puertos distintos](#simular-que-tenemos-varios-dominios-en-puertos-distintos)

    
---
---
## Markdown cheatsheet


### __Títulos__
Se escriben # delante del título. La correspondencia es de: # H1, ## H2, ### H3, #### H4, ##### H5, ###### H6

### __Enlaces internos__
Para poner enlaces como en un índice que referencien secciones del documento se escribe entre [] el nombre del enlace y entre () el nombre de ese enlace sustituyendo los espacios por guiones y con un # delante. Hay que tener cuidado porque los acentos sí se aceptan en (). Luego los títulos se deberán llamar tal cual el enlace. Ejemplo:
```
[Título de la sección](#título-de-la-sección)
```

### __Énfasis__
- Negrita: ```**palabra**``` o ```__palabra__``` : __palabra__ 
- Cursiva: ```*palabra*``` o ```_palabra_``` : *palabra*
- Tachado: ```~~palabra~~``` : ~~palabra~~

### __Listados__
- ```*```, ```-```, ```+``` para listas sin ordenar.
- Números seguidos de un punto para listas ordenadas: ```1.```...  ```2.```...
- Para listados dentro de algún punto se hace con tabulación.  

### __Incluir imágenes__
Para poner imágenes tenemos que poner un ! seguido de [] con el nombre que aparecerá si no puede cargarse la imagen y () la ruta de la imagen:
```
![alt imagen](ruta imagen)
```
### __Blockquotes__
Para escribir texto enmarcado en un cuadro como si fuera una cita textual o algo importante, se escribe el símbolo ```>``` justo delante del texto:
```
>{texto}
```
### __Saltos de línea__
Para que el texto comience un nuevo párrafo se tienen que escribir dos espacios seguidos justo antes de hacer el salto de línea. De forma que: *final de parrafo + espacio + espacio + intro + comienzo del siguiente párrafo*. 

---
---
## Funcionamiento de Git

### __Crear cuenta e instalar GitHub__
Crear una cuenta en GitHub (github.com) con *Sign up* rellenando los campos de nombre de usuario, dirección de correo y contraseña. 

Crear una carpeta mediante el terminal donde clonaremos y pondremos lo del repositorio en el equipo:
```
mkdir {nombre de la carpeta}
```
Instalar git mediante el terminal:
```
sudo apt install git
```
Si aparece un error _"no se pudo bloquear /var/lib/dpkg/lock"_ ..., introducir la siguiente instrucción:
```
sudo fuser -vki /var/lib/dpkg/lock
```
y volver a instalar git:

```
sudo apt install git
```
Para crear o importar un nuevo repositorio tan sólo se tienen que seguir las instrucciones que la página oficial nos indica. 

### __Clonar repositorio remoto__

Cogemos del repositorio la url-clave que aparece tras pulsar el botón *Clone or download*. Tenemos dos opciones, coger la versión SSH o la versión HTTPS. Una vez copiada, escribimos en la terminal de nuestro equipo (El usuario y la contraseña que nos pide, son los de GitHub):
```
git clone {url-clave}
```
A continuación generamos una clave SSH para poder enlazar nuestra cuenta de GitHub a lo que realicemos por terminal. De todo lo que nos pide, sólo introducimos nuestro email, lo demás son todo intros vacias. Para generarla:     
```   
ssh-keygen -t rsa -b 4096 -C {correo con el que ingresas en github}
```
Una vez generada la clave, la mostramos:
```
cat ~/.ssh/id_rsa.pub
```
![clave ssh a copiar](/images/clave-ssh.png)

Luego la copiamos en *Edit user*  >> *Settings*  >> *SSH and PGP keys* de la página GitHub:
![imagen Edit user y settings](/images/settings-github.png)
![imagen ssh and pgp keys](/images/ssh-key.png)

Instalamos ahora Openssh-server escribiendo en el terminal:
```
sudo apt install openssh-server
```
Arrancamos el agente SSH en segundo plano: 
```
eval "$(ssh-agent -s)"
```
Añadimos la clave al agente:
```
ssh-add ~/.ssh/id_rsa
```
> ---
>En caso de haber clonado el repositorio mediante HTTPS, hay que cambiar la url-clave del repositorio para que admita git+ssh en vez de https. Para ello vemos cuál es nuestra *url origin*, la url que apunta al repositorio:
>```
>git remote show origin
>```
>De ahi cogemos la dirección y la usamos con:
>```
>git remote set-url origin git+ssh://{dirección url}
>```
> ---

### __Instrucciones básicas de GitHub__
- Ver estado del repositorio local
    ```
    git status
    ```
- Añadir algún archivo modificado o creado al control de versiones:
    ```
    git add {nombre del archivo}
    ```
- Hacer un *commit* (comprometer) los cambios al repositorio local añadiendo una nota que explique lo que hemos hecho:
    ```
    git commit -am "mensaje"
    ```
- Hacer un *commit* que suba todos los cambios al repositorio:
    ```
    git commit -a
    ```
- Subir (*push*) los cambios del repositorio local a la rama principal del repositorio remoto:
    ```
    git push origin master
    ```
- Subir los cambios del repositorio local a la rama que queramos: 
    ```
    git push {nombre de la rama}
    ```
- Actualizar (*pull*) el repositorio local con los cambios desde la rama principal del repositorio remoto:
    ```
    git pull origin master
    ```
- Actualizar el repositorio local con los cambios de la rama que queramos: 
    ```
    git pull {nombre de la rama}
    ```
- Crear un repositorio vacío o reinicializa alguno ya existente para el control de versiones:
    ```
    git init
    ```

### __Ramas__

- Crear una rama:
    ```
    git branch {nombre de la rama}
    ```
- Cambiarse a una rama en concreto:
    ```
    git checkout {nombre de la rama}
    ```
- Crear una rama y cambiarse a ella:
    ```
    git checkout -b {nombre de la rama}
    ```
- Cambiarse a la rama origen o principal:
    ```
    git checkout master
    ```
- Integrar los cambios de una rama específica a la rama en la que estoy:
    ```
    git merge {nombre de la rama específica}
    ```
- Mostrar todas las ramas existentes en el repositorio. De color verde aparece aquella en la que nos encontramos: 
    ```
    git branch
    ```
- Para borrar una rama:
    ```
    git branch -d {nombre de la rama}
    ```
- Ver qué herramientas de ayuda al merge hay:
    ```
    git mergetool
    ```
    >---
    >*Meld* es una de las herramientas para conflictos a la hora de hacer el merge de algún archivo. Se puede instalar escribiendo en el terminal:
    >```
    >sudo apt install meld
    >```
    >![imagen mergetool](/images/mergetool.png)
    >
    >Cuando un archivo nos da conflicto nos aparece algo como:   
    > *<<<* HEAD  
    > *Lo que tengo en la rama*  
    > = = = =   
    > *Lo que tengo que decidir si incluir o no porque da conflicto*  
    > *>>>* hotfix  
    >
    >---






---
---
## Área de trabajo en Ubuntu

### __Crear usuario__
Después de la instalación del sistema, en la terminal añadiremos el nombre que tendrá el nuevo usuario personalizado:
```
sudo adduser {nombre del usuario}
```
Ahora necesitamos hacer un superusuario del usuario. Para que se haga efectivo tenemos que cerrar después la sesión:
```
sudo usermod -aG sudo {nombre del usuario}
```

### __Instrucciones básicas de terminal__
- ```ls``` lista el directorio en el que estamos.
- ```ls -l``` lista el directorio en el que estamos pero con más detalle.
- ```ls -al``` lista con detalle todo lo del directorio en el que estamos, incluso lo oculto.
- ```clear``` limpia la vista de la terminal, borra todo lo escrito hasta ahora.
- ```mkdir {nombre de la carpeta}``` crea una carpeta.
- ```cd {nombre de la carpeta}``` para entrar en una carpeta.
- ```cd ..``` para volver a la carpeta anterior en el directorio. 
- ```cd /``` para volver a la carpeta raíz del sistema.
- ```sudo dpkg -i {nombre del archivo a instalar}``` para instalar un archivo ya descargado en el equipo.
- Pulsar *ctrl+c* para parar todo lo que esté ejecutando el terminal. 
- ```unzip {nombre del archivo}``` para descomprimir un archivo por terminal.
- ```cat {nombre del archivo}``` lee por consola el archivo indicado.
- ```nano {nombre del archivo}``` para modificar un archivo por terminal con el editor Nano. El mismo comando sirve para crear un archivo si el nombre que indicamos no existe previamente. 
- ```rm {nombre archivo}``` para borrar un archivo.

### __Hosts y hostnames__
Para sacar el nombre del servidor: 
```
cat /etc/hostname
```
Si queremos cambiar el nombre del servidor o añadir uno nuevo:
```
sudo nano /etc/hostname
```
Para ver mis hosts:
```
cat /etc/hosts
```
Para cambiar un host a un nombre más recordable (se pueden tener tantos como se quiera):
```
sudo nano /etc/hosts
```

### __Instalación de Visual Studio Code__
En el terminal tenemos que actualizar dependencias con: 
 ```
 sudo apt update
 ```
 Luego instalamos la última versión disponible para nuestro sistema escribiendo en el terminal:
 ```
 sudo apt install code
 ```
 Si lo queremos actualizar a una última versión disponible tendremos que escribir en terminal los siguientes comandos:
 ```
 sudo apt update
 sudo apt upgrade
 ```

### __Instalación de Flameshot__
Para instalar el programa con el que poder hacer capturas de pantalla en Ubuntu tendremos que escribir en el terminal:
```
sudo apt install flameshot
```

 ### __Instalación de VirtualBox__
Primero vamos a necesitar instalar las dependencias para que no dé un fallo la instalación: 
```
sudo apt install libcurl4 libqt5opengl5 libqt5printsupport5
```
Descargamos VirtualBox y el *extension pack* desde la página oficial de descargas https://www.virtualbox.org/wiki/Linux_Downloads y ejecutamos el archivo .deb descargado:
```
sudo dpkg -i {archivo .deb}
```

---
---
## CentOS

### __Instalación en entorno virtualizado__
Descargamos la iso de la última versión *minimal* de https://mirror.umd.edu/centos/7/isos/x86_64/ y la instalamos en VirtualBox. Cuando se nos pida crear un usuario, lo hacemos administrador. 

A partir de aquí, dejaremos la terminal de nuestro equipo y usaremos la de CentOS. 

Hay que recordar que CentOs no se conecta a la red una vez instalado, por lo que habrá que cambiar el archivo *ifcfg-enpOs3*. Para ello, escribimos en el terminal:
```
sudo vi /etc/sysconfig/network-scripts/ifcfg-enp{y pulsamos el tabulador para que termine el nombre del archivo correspondiente en nuestro equipo}
```
En *ONBOOT* pone *no*, tenemos que cambiarlo a *yes*, situando el cursor en el lugar a escribir y tecleando una ```i``` para entrar en el modo edición. Para guardar y salir tenemos que escribir ```:wq```. 

Acto seguido, necesitamos reiniciar el servicio de red escribiendo en el terminal:
```
sudo service network restart
```

Para instalar Apache escribimos en el terminal (y contestamos que sí a todas las preguntas):
```
sudo yum install httpd
```

Para ver si está instalado: 
```
systemctl status httpd
```

Ahora tenemos que arrancar el servidor:
```
sudo systemctl start httpd
```
Para que el servidor arranque automáticamente al inicio (no hace falta que cuando escribamos la instrucción esté en marcha): 
```
sudo systemctl enable httpd
```

### __Instrucciones básicas de Apache en CentOS__
- Podemos ver qué distribución estamos usando remotamente con: ```cat /etc/*-release```
- Y para ver la versión de Apache (v saca información pero V saca muchos más datos): ```httpd -v```
- El estado de Apache lo obtenemos escribiendo: ```apachectl status```
- Para parar el servidor: ```sudo apachectl stop```
- Para reiniciar el servidor parando todas las tareas que se están realizando por atrás: ```sudo apachectl restart```
- Para reiniciar el servidor esperando a que acaben las tareas todavía no terminadas: ```sudo apachectl graceful```
- Instalar manual de Apache para poder consultarlo: 
    >```sudo yum install httpd-manual```  
    Reiniciamos el servidor con ```apachectl restart```  
    y accedemos a él escribiendo en la url de algún navegador web ```{IP}:{puerto}/manual/```
- Instalación del servidor de SSH: ```sudo yum install openssh-server```
- Reiniciar CentOS: ```sudo shutdown -rf now```
- Apagar CentOS: ```sudo shutdown now```
- Reiniciar la máquina virtual: ```sudo reboot```
- Para ver los archivos de Apache:
    >```cd /etc/httpd```  
    ```ll```   
    Allí vemos que:  
    >- En *conf* esta el archivo de configuración de apache
    >- En *conf.d* podemos crear archivos de configuración parciales
    >- En *conf modules.d* está la configuración de los módulos
    >- En *logs* encontramos las respuestas del servidor
    >- En *modules* podemos acceder a los módulos  
    >- Si cambiamos algo del archivo de configuración y da errores, podemos comprobarlo con: ```sudo apachectl configtest```

- Para salir del terminal del servidor y volver al terminal del equipo cuando los tenemos enlazados: ```exit```

### __Conexión SSH con IPs diferentes__
Para poder conectarnos por SSH necesitamos saber la IP tanto de la máquina virtual como de nuestro equipo, para ello podemos escribir en ambas terminales: 
```
ip addr show
```
Ahora entramos a la *Configuración* de CentOS en VirtualBox y en el apartado de *Red*, asegurándonos de que estamos conectados mediante NAT. 

Para conectar ambos sistemas por SSH debemos tenerlos en la misma IP, eso lo conseguimos entrando en la configuración de Red, en *Avanzadas* y *Reenvío de puertos*. Creamos nuevas reglas uniendo las IP anfitrión e invitado por los mismos puertos:  

![imagen IPs diferentes en mismo puerto](images/reenvio-puertos.png)  

En la terminal del equipo ahora podemos usar la terminal de CentOS indicando el puente:
```
ssh {usuario de centos}@{IP anfitrión} -p {puerto anfitrión}
```
Si hemos tenido algún problema para conectar por SSH, necesitamos abrir el firewall en la máquina virtual:
```
sudo firewall-cmd --zone=public --add-service=http --permanent  

sudo firewall-cmd --zone=public --add-service=ssh --permanent
```
Y reiniciamos el firewall:
```
sudo firewall-cmd --reload
```

### __Conexión SSH con IPs que coinciden__
En este caso, para usar la conexión SSH debemos estar en la misma IP tanto en máquina virtual como en nuestro equipo. 

Tenemos que cambiar la interfaz de red (*Configuración* de VirtualBox + *Red*) de NAT a BRIDGE o Adaptador Puente. 

Podemos ver ambas IPs en los dos terminales con:
```
ip addr show
```
Cuando ambas IPs coinciden, podemos usar el terminal de CentOS en el de nuestro equipo escribiendo:
```
ssh {nombre de usuario de CentOS}@{IP}
```
Necesitamos también habilitar el puerto 80 para el servidor:
```
sudo firewall-cmd --zone=public --add-service=http --permanent 

sudo firewall-cmd --zone=public --add-service=ssh --permanent
```
Debemos reiniciar el firewall:
```
sudo firewall-cmd --reload
```

### __Poner la IP estática__
Desde el terminal del servidor entramos al archivo *ifcfg-enpOs3* para editarlo con ```i``` y guardando con ```:wq```. Cambiamos *BOOTPROTO* y añadimos las líneas de *IPADDR* con la IP actual, *NETMASK* con lo que hay atrás de la / en la IP (24 = 255.255.255.0),*GATEWAY* , *DNS1* y *DNS2*:

![imagen ip estatica](images/config-ip-estatica.png)


### __Subir archivos a servidor CentOS__
Para ver una interfaz con lo que tenemos en el servidor, necesitaremos instalar Filezilla en la terminal de nuestro equipo. Se trata de un programa para conectarse por remoto al servidor:
```
sudo apt install filezilla
```
En el *Gestor de archivos* creamos un *Nuevo sitio* poniendo nuestra IP, el puerto 22, protocolo SFTP, modo de acceso normal, usuario y contraseña: 

![Gestor Filezilla](images/gestor-filezilla.png)
![Nuevo Sitio Filezilla](images/nuevo-sitio-filezilla.png)

Si en el terminal del servidor creamos una carpeta (```mkdir {nombre carpeta}```), en Filezilla veremos que aparece en la parte del servidor. Para pasar archivos del equipo al servidor, tan sólo tenemos que arrastrarlos desde la parte izquierda que representa nuestro equipo, a la derecha que representa el servidor. 

### __Módulo de Apache para gestionar PHP__
En la terminal del servidor, podemos ver cuáles son los módulos que tenemos instalados:
```
http -m
```
Añadimos el repositorio donde se actualiza todo lo referente a php:
```
sudo yum install epel-release yum-utils
```
Es necesario reiniciar la red:
```
sudo service network restart
```
Ahora ya podemos instalar PHP y el resto de librerías relacionadas que necesitamos: 
```
sudo yum install http://rpms.remirepo.net/enterprise/remi-release-7.com  

sudo yum-config-manager --enable remi=php72

sudo yum install php php-common php-opcache php-mcrypt
php-cli

sudo yum install php-gd php-curl php-mysqlnd
```

Para la versión instalada de PHP:
```
php -v
```

En la configuración de los módulos ahora vemosque hay un archivo php porque ya está instalado:
```
ll /etc/httpd/conf.modules.d
```

### __Simular que tenemos varios dominios en el mismo servidor__
En Filezilla, conectamos con el servidor y copiamos la web comprimida de local al servidor mediante el terminal y la carpeta donde está la web en local:
```
scp ./{archivo .zip donde tenemos toda la web} {usuario de CentOS}@{IP} {ruta donde queremos poner la web en el servidor}/{archivo .zip donde tenemos toda la web}
```
>Si el servidor no conecta en Filezilla, dentro de *Edición* + *Opciones* + *Aumentar el tiempo de espera* y añadimos más segundos. 

Ya en la terminal de CentOS podemos ver las carpetas del servidor y sus permisos que tienen los archivos de la web, los cuales tendrían que ser 644 (rw-r--r--) para archivos y 755 (rwxr-xr-r) para carpetas:
```
ll /var/www
```

Allí dentro podemos crear las carpetas para las webs que queramos. Por ejemplo: 
```
sudo mkdir /var/www/clientes

sudo mkdir /var/www/proveedores
```
Desde el terminal en local pasamos todos los archivos alojados en local al servidor para cada una de las webs:
```
sudo cp -R {nombre carpeta de la web en local}/* /var/www/{nombre carpeta del servidor que la alojará}
```
Ahora, desde el terminal del servidor, podemos modificar los archivos que contienen para cada una de las webs:
```
sudo nano /var/www/{carpeta que contiene la web en servidor}/index.html
```
Cuando vayamos a ver cualquiera de las webs en el navegador, las veremos indicando la dirección IP y la carpeta que la aloja en la url del navegador. 

### __Simular que tenemos varios dominios en la misma IP__
Debemos crear hosts virtuales dentro del directorio de configuración:
```
sudo nano /etc/httpd/conf.d/{archivo de configuración de la carpeta.. por ejemplo: clientes.conf}
```
Allí dentro escribimos para que reciba peticiones de cualquier IP al puerto 80, la ruta donde se encuentra y el dominio en el que irá:
```
<VirtualHost *:80>
{4 espacios} DocumentRoot /var/www/clientes
{4 espacios} ServerName clientes.com
</VirtualHost>
```
Como los dos dominios pertenecen a la misma IP en el terminal local editamos el archivo *hosts* (```sudo nano /etc/hosts```) y ponemos la IP del dominio simulando que lo hemos comprado. Ejemplo: 
```
192.168.1.178 clientes.com
```
Después tendremos que reiniciar Apache desde el terminal de CentOS:
```
sudo apachectl restart
```
Si entramos en *clientes.com* mediante el navegador, veremos nuestra web para clientes.. y lo mismo para el resto de webs alojadas en el servidor con la misma IP. 

### __Simular que tenemos varios dominios en varias IP__
Con el servidor apagado (lo apagamos con ```sudo shutdown now```), en VirtualBox creamos otro adaptador en *Configuración* + *Red* + *Adaptador 2* + *Adaptador puente*: 

![adaptador 2 virtualbox](images/adaptador2.png)

Volvemos a encender el servidor y vemos con ```ip addr show``` que el servidor tiene dos IPs.  

Tenemos que modificar el archivo de configuración de uno de los dominios para ponerle un host virtual diferente, para que no tenga el mismo que ningún otro de los dominios de nuestro servidor:
```
<VirtualHost {IP distinta}:80>
{4 espacios} DocumentRoot /var/www/clientes
{4 espacios} ServerName clientes.com
</VirtualHost>
```
Reiniciamos el servidor (```sudo apache restart```) y con el terminal local eidtamos los hosts (```sudo nano /etc/hosts```) y cambiaos las IPs para cada dominio como corresponde, para que nos salgan bien en la barra del navegador, si no irá a la misma web porque dirige a la página *index.html* que tiene el servidor. 

### __Simular que tenemos varios dominios en puertos distintos__
Cambiamos el archivo de configuración del dominio para que el VirtualHost tenga un puerto diferente, y en la primera línea tenemos que forzar la escucha: 
```
Listen {nuevo puerto}
<VirtualHost {IP}:{nuevo puerto}>
{4 espacios} DocumentRoot /var/www/clientes
{4 espacios} ServerName clientes.com
</VirtualHost>
```
Necesitamos reiniciar el servidor para que se haga efectivo: 
```
sudo apachectl restart
```
Ahora es necesario abrir el puerto en el firewall: 
```
sudo firewall-cmd --add-port={nuevo puerto que hemos escrito antes en VirtualHost}/tcp --permanent
```
Relanzamos el firewall:
```
sudo firewall-cmd --reload
```



---
---