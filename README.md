# MyCantineApp

## Avant de coder
Il est obligatoire de vérifier que les paramètres d'identification de Git sont corrects.
Pour vérifier ses réglages :
```git config --list```
Si une erreur est constaté dans user.email ou dans user.name alors :
  * ```$ git config --global user.name "John Doe"```
  * ```$ git config --global user.email johndoe@example.com```
(le Mail doit impérativement être le même que sur Github, et le name doit être le même que dans votre logiciel de Git (si vous en utilisez un).

Vérifier sur quelle branche Git vous vous trouvez avec :
  ```git status```
  
Si vous êtes dans un état détaché alors : 
  ```git checkout master```   

Mettre à jour les dépendances du projet avec :
  * ```composer install```
  * ```yarn install```

## Développement
Noms et adresses des routes en Anglais, exemple :
  * mycantine.app/signin, name="sigin.index"
 
Les images doivent se trouver dans le dossier "assets/img/"

Les fichiers Vue dans "assets/vue/"

Un fichier SCSS commun dans "assets/scss", pour ce qui est spécifique à certaines pages, on crée alors un nouveau fichier.

Pour chaque nouvelle page, on créer une nouvelle entrée dans le fichier webpack.config.js, par exemple :

//Signup CSS

    .addEntry('signup', './assets/js/signup.js')

//Signin CSS

    .addEntry('signin', './assets/js/signin.js')
    
## Avant de commit
  * Vérifier le fonctionnement de votre code
  * Nommer vos branches de la bonne façon (voir plus bas)
  * Expliquer dans votre commit les ajouts
  * Pensez à commenter votre code si besoin
 
 ## Nommage des branches
 Nouvelle fonctionnalité : ```feat/nomDeLaNouveauté```
 Bugfixe : ```fix/bugEnQuestion```
 Optimisation du code : ```optim/OptimisationCode```
