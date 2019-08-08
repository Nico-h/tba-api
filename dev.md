Build the apache2_php7 image based on apache2 dockerfile

`docker build -t tba_apache2_php7 ./docker-conf/apache2`

Run the apache2_php7 container based on apache2_php7 image

`docker run -dit -p 8008:80 -v /var/www/html:/var/www/html --name apache2_php7 tba_apache2_php7`

Apache2 is now running on port 8008

Notes: en essayant de construire l'image à partir du dépot Alpine,
je ne parviens pas à lancer le process en foreground. Alpine ne
contient que httpd, apache2ctl et les commandes a2 ne sont pas
disponibles non plus. Je rajoute php dans cette image, je ne sais
pas comment créer une image utilisable uniquement avec php seul.

Build the mysql image based on mysql dockerfile

`docker build -t tba_mysql ./docker-conf/mysql`

Run the mysql container based on mysql image

`docker run -dit -p 4306:3306 --name mysql tba_mysql`

Notes: il faut eteindre mysql en local pour ne pas utiliser 2 fois
le port 3306

Notes: on ne peut pas se connecter depuis le conteneur apache2 qui
contient l'app sur le conteneur mysql avec l'adresse localhost ou
127.0.0.1. On doit utiliser l'ip du host du conteneur c'est à dire
l'IP en local, par exemple 172.20.0.1

Notes:

Notes: pour relancer un .env il faut supprimer le fichier et 
refaire composer update