# bre01-blog-secu

The is a demo blog project that demonstrates how to patch SQL, XSS, strong auth and CSRF security concerns. The blog is in PHP using MVC design pattern and OOP.

## Étape 1 : les fichiers

Vous trouverez les fichiers du projet dans l’archive secu-blog.zip ici. Parcourez ces fichiers, vous verrez qu’une partie des contenus vous sont déjà fournis. À vous de compléter le reste.

## Étape 2 : base de données

Sur PhpMyAdmin, créez une base de données prenomnom_secu_blog (en utf8_general_ci) et importez-y les fichiers SQL que vous trouverez ici dans l’ordre suivant :

    categories.sql
    users.sql
    posts.sql
    posts_categories.sql
    comments.sql

# Étape 3 : les models

Faites en sorte que vos modèles soient conformes à ce qui est présent dans votre base de données. Vous devrez utiliser la composition pour représenter les jointures (par exemple, un Post a, entre autres, une Category et un User en attribut). La table posts_categories est une pure table de liaison, elle n’a donc pas de modèle.|

```Js

 //  1. Analyser la structure de la BDD et les relations entre les tables. Regarder le concepteur
 //  2. Créer des classes dans models pour chaque table sauf post_categories, les attributs correspondent aux colonnes (+ regarder les types)
 //  3. Mettre des getters et des setters pour chaque attribut


```

![schéma du concepteur de la base de données correspondant au projet](concepteur.png)
