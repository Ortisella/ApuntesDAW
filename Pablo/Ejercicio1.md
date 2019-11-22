# Ejercicio1 documentación
Documentación

-Crear una carpeta en documentos
```
mkdir Ejercicio1
```
-Ubicarse en la carpeta del ejercicio e inicializarla a git.
```
cd Ejercicio1
git init
```
-Crear un script de bash y entrar con un editor de texto para escribir en el.
```
nano script.sh
```
-Dentro del editor escribir la instrucción. Para que acepte el lenguaje bash
```
#!/bin/bash
echo Introduzca un número
read numero1
echo Introduzca otro número
read numero2
num=$((numero1 + numero2))
echo "La suma de $numero1 y $numero2 es $num"
```
-Dar permisos al script para que pueda ejecutarse.
```
chmod +x script.sh
``` 
-Ejecutar el script para comprobar que se ejecuta correctamente:
```
./script.sh
```
-Primero añadir el archivo y luego guardar los cambios en el repositorio local:
```
git add script.sh
git commit -am "primer commit"
```
-Crear una rama nueva donde realizar una modificación de script.sh:
```
git branch rama1
```
-Viajar a la rama1 para modificar el script:
```
git checkout rama1
nano script.sh
```
-Modificar el script con:
```
#!/bin/bash
echo Introduzca un número entero
read numero1
echo Introduzca otro número
read numero2
echo Introduzca otro número
read numero3
num=$((numero1 + numero2 + numero3))
echo "La suma de $numero1, $numero2 y $numero3 es $num"
```
-Ejecutar para comprobar que se ejecuta correctamente:
```
./script.sh
```
-Guardar los cambios con commit:
```
git commit -am "suma de 3 números"
```
-Volver a la rama master:
```
git checkout master
```
-Ejecutar el script para comprobar que se trata del sin modificar que suma solo dos números:
```
./script.sh
```
-Modificar el script original en una nueva rama "rama2":
```
git branch rama2
git checkout rama2
nano script.sh
```
-Como la rama se creó desde master el script es el original, así que modificamos desde el original:
```
#!/bin/bash
echo Suma de enteros. Siga las instrucciones:
echo Introduzca el primer número
read numero1
echo Introduzca otro número
read numero2
num=$((numero1 + numero2))
echo "La suma de $numero1 y $numero2 es $num"
```
-Ejecutar para comprobar que se ejecuta correctamente:
```
./script.sh
```
-Guadar los cambios con commit en local:
```
git commit -am "mensaje previo"
```
-Volver a la rama master:
```
git checkout master
```
-Integrar la rama2 en la rama master
```
git merge rama2
```
-Integrar la rama1 en la rama master:
```
git merge rama1
```
-Instalar meld para solucionar el conflicto y usar mergetool:
```
sudo apt-get install meld
git mergetool
```
-Guardar la resolución del conflicto con commit:
```
git commit
```
-Ejecutar para comprobar:
```
./script.sh
```
-Borrar la rama1 y la rama2
```
git branch -d rama1
git branch -d rama2
```
-Realizar un log del repositorio:
```
git log
```