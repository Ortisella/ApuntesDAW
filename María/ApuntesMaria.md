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
    - [Instalación de Visual Studio Code](#instalación-de-visual-studio-code)

- [TRABAJO EN ENTORNO VIRTUALIZADO](#trabajo-en-entorno-virtualizado)
    - [Instalación de VirtualBox](#instalación-de-virtualbox)
    
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


---
---
## Trabajo en entorno virtualizado


 ### __Instalación de VirtualBox__
Primero vamos a necesitar instalar las dependencias para que no dé un fallo la instalación: 
```
sudo apt install libcurl4 libqt5opengl5 libqt5printsupport5
```
Descargamos VirtualBox y el *extension pack* desde la página oficial de descargas https://www.virtualbox.org/wiki/Linux_Downloads y ejecutamos el archivo .deb descargado:
```
sudo dpkg -i {archivo .deb}
```



___________________
_____________________


