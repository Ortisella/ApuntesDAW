# APUNTES: DESARROLLO DE APLICACIONES WEB


## Índice
- [MARKDOWN CHEATSHEET](#markdown-cheatsheet)
    - [Enlaces internos](#enlaces-internos)
    - [Títulos](#títulos)
    - [Énfasis](#énfasis)
    - [Listados](#listados)

- [FUNCIONAMIENTO DE GIT](#funcionamiento-de-git)

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

## __Instalación de Flameshot__
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
