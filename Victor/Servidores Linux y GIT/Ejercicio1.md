# Ejercicio 1

Crea una carpeta para realizar el ejercicio
```
sudo mkdir Ejercicio1
```

Inicializa un repositorio git en la carpeta creada
```
git init
```
- La salida debe de ser parecida a la siguiente: ```Inicializado repositorio Git vacío en /home/victor/Proyectos/Ejercicio1/.git/```

Crea un script de bash que solicite dos números al usuario y luego imprima la suma

- Crear fichero
```
sudo nano script.sh
```
- Código del script
```
#!bin/bash

echo Introduzca un numero
read numero1

echo Introduzca otro numero
read numero2

resultado=$(($numero1 + $numero2))

echo La suma de $numero1 y $numero2 es $resultado


```

- Al ejecutar el script ``` sh script.sh ``` el resultado es:
```
Introduzca un numero
1
Introduzca otro numero
2
La suma de 1 y 2 es 3
```

Guarda los cambios en el repositorio local (commit) con el mensaje "primer commit"
- Primero hay que añadir los ficheros creados al repositorio
```
sudo git add script.sh
sudo git add Ejercicio1.md
```

- Despues procedemos a hacer el commit
```
sudo git commit -am "primer commit"
```

- Y el resultado es:
```
[master (commit-raíz) 11ecb53] primer commit
 2 files changed, 55 insertions(+)
 create mode 100644 Ejercicio1.md
 create mode 100644 script.sh
```

Crea una nueva rama para realizar la modificación
```
sudo git checkout -b rama1
```
- El resultado es el siguiente:
```
M	Ejercicio1.md
Cambiado a nueva rama 'rama1'
```

Modifica el script
```
#!bin/bash

echo Introduzca un numero
read numero1

echo Introduzca otro numero
read numero2

echo Introduzca otro numero
read numero3

resultado=$(($numero1 + $numero2 + $numero3))

echo La suma de $numero1, $numero2 y $numero3 es $resultado
```

- El resultado de ejecutarlo es el siguiente:
```
Introduzca un numero
1
Introduzca otro numero
2
Introduzca otro numero
3
La suma de 1, 2 y 3 es 6
```

Guarda los cambios
```
sudo git commit -am "suma de 3 numeros"
```
- El resultado es
```
[rama1 d74ff49] suma de 3 numeros
 2 files changed, 64 insertions(+), 2 deletions(-)
```

Regresa a la rama master
```
sudo git checkout master
```
- El resultado es:
```
Cambiado a rama 'master'
```

Al ejecutar el script desde esta rama ``` sh script.sh```, el resultado es:
```
Introduzca un numero
1
Introduzca otro numero
2
La suma de 1 y 2 es 3
```

Crea una nueva rama para realizar mas modificaciones
```
sudo git checkout -b rama2
```
- El resultado es:
```
Cambiado a nueva rama 'rama2'
```

Modifica el script ``` sudo nano script.sh ```
```
#!bin/bash

echo Suma de enteros. Siga las instrucciones:
echo Introduzca el primer numero
read numero1

echo Introduzca otro numero
read numero2

resultado=$(($numero1 + $numero2))

echo La suma de $numero1 y $numero2 es $resultado
```

Guarda los cambios en el repositorio local
```
sudo git commit -am "mensaje previo"
```
- El resultado es:
```
[rama2 8906566] mensaje previo
 2 files changed, 98 insertions(+), 1 deletion(-)
```

Regresa a la rama master
```
sudo git checkout master
```
- El resultado es:
```
Cambiado a rama 'master'
```

Integra la segunda rama en la rama master
```
sudo git merge rama2
```
- Resultado:
```
Auto-fusionando Ejercicio1.md
CONFLICTO (contenido): Conflicto de fusión en Ejercicio1.md
Fusión automática falló; arregle los conflictos y luego realice un commit con el resultado.
```
- Solución:
```
sudo git mergetool
sudo git commit
```
- Resultado de la solución:
```
[master 9f4ec7c] Merge branch 'rama2'
```

Borra la segunda rama
```
sudo git branch -d rama2
```
- Resultado:
```
Eliminada la rama rama2 (era a73cc88)
```

Integra la primera rama en la rama master
```
sudo git merge rama1
```
- Resultado:
```
Auto-fusionando script.sh
Auto-fusionando Ejercicio1.md
CONFLICTO (contenido): Conflicto de fusión en Ejercicio1.md
Fusión automática falló; arregle los conflictos y luego realice un commit con el resultado.
```
- Solución:
```
sudo git mergetool
sudo git commit
```
- Resultado de la solución
```
[master 96cf12b] Merge branch 'rama1'
```

Borra la primera rama
```
sudo git branch -d rama1
```
- El resultado es:
```
Eliminada la rama rama1 (era d74ff49)
```

Al ejecutar otra vez el script (``` sh script.sh```), el resultado es el siguiente:
```
Suma de enteros. Siga las instrucciones:
Introduzca el primer numero
1
Introduzca otro numero
2
Introduzca otro numero
3
La suma de 1, 2 y 3 es 6
```

Mostrar el log:
```
sudo git log
```
- Resultado:
```
commit 96cf12b2d5b8db04b264cd0269cf316da7692369 (HEAD -> master)
Merge: 16c5689 d74ff49
Author: Victor Calatayud <victor.calatayud.espinosa@gmail.com>
Date:   Fri Sep 20 19:04:37 2019 +0200

    Merge branch 'rama1'

commit 16c5689428f336f6d4eb914900bdf021891ab0f4
Author: Victor Calatayud <victor.calatayud.espinosa@gmail.com>
Date:   Fri Sep 20 18:58:52 2019 +0200

    Modificada las instrucciones

commit 9f4ec7c8b22beb4f7645b6f561fe6ac1f0f18fef
Merge: 7238721 a73cc88
Author: Victor Calatayud <victor.calatayud.espinosa@gmail.com>
Date:   Fri Sep 20 18:56:35 2019 +0200

    Merge branch 'rama2'

commit 7238721ee08979961e4a6c881657b50a914a68af
Author: Victor Calatayud <victor.calatayud.espinosa@gmail.com>
Date:   Fri Sep 20 18:52:36 2019 +0200

    Modificada las instrucciones

commit a73cc889dc564b67197f96b89f89445a8c728229
Author: Victor Calatayud <victor.calatayud.espinosa@gmail.com>
Date:   Fri Sep 20 18:50:16 2019 +0200

    Modificada las instrucciones

commit 89065664634e09da2762a79186e4a8edf9a2592c
Author: Victor Calatayud <victor.calatayud.espinosa@gmail.com>
Date:   Fri Sep 20 18:47:30 2019 +0200

    mensaje previo

commit d74ff49cf3ead79623d432e84186e9a8f3c635fc
Author: Victor Calatayud <victor.calatayud.espinosa@gmail.com>
Date:   Fri Sep 20 18:38:29 2019 +0200

    suma de 3 numeros

commit 11ecb53244a2ac1aa963fb2f4b84a0cdf37b279d
Author: Victor Calatayud <victor.calatayud.espinosa@gmail.com>
Date:   Fri Sep 20 18:31:03 2019 +0200

    primer commit
(END)

```
