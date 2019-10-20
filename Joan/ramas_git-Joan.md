# GESTIÓ DE RAMES EN GIT

- Creem un nou repositori per a les proves
` git innit <directori> `

- Creem un script de bash ` nano script.sh ` tots els scripts han de començar definint en quin llenguatge están escrits

 ` #!/bin/bash` per definir el tipus d'script que és

- Una volta creats li donem permisos d'execusió

  `chmod +x` +x per afegir el permis d'execusió, x= execusió

  i l'executem amb: `./<arxiu>` o `bash <arxiu>`

- L'afegim a la versió de control ` git add <nom arxiu> ` o ` git add ./ (tota la carpeta) `

  Tots els cambis han d'estar guardar en un commit abans de poder fer la rama.

- Llavors creem la rama ` git branch <nom de la rama> ` i ` git checkout <nom de la rama> ` per a cambiar de rama o ` git checkout -b hotfix ` per a fer-ho tot en una instrucció.

- Un cop tots els cambis a la rama estiguin guardats amb un commit es poden combinar amb la principal amb ` git merge <nom de la rama> ` es combina a la rama en la que s'està actualment

- Si hi han conflictes aquests es tenen que solucionar:

  `git mergetool` mostra les ferramentes per a solucionar els conflictes (utilitzarem meld )

# Altres comandes
 - `git branch -d bugfix` borra la rama  ( -d -> delete)
