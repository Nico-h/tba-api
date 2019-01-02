#Launch the project

Go to project folder and launch the docker container

`docker build -t tba-env .`

Run the api

`docker run -dit -p 8080:80 -p 4306:3306 --name tba-api tba-env`

Open browser at http://localhost:8080/index.php to test the container

Connect to the container

`docker exec -it tba-api /bin/bash`

Start mysql

`service mysql start`

Initialize DB

`./docker-conf/setup.sh`

##API Routes

GET /touraments : list all tournaments

GET /tournament/{id}/games : list all games of a tournament

POST /tournament : create a new tournament

GET /player/{id} : get player info

GET /game/{id} : get game info

POST /game : create a new game

GET /stats/{tournamentType}/{area}/{round}/{odd} : get stats


###Some docker commands

Existing images: `docker images`

Build an image where the Dockerfile is: `docker build -t my_image_name .`

Existing containers (running and quiet): `docker ps -a`

Run a container (put the image_name at the end of the command): `docker run -dit -p local_port:exposed_port --name my_container_name my_image_name`

Delete images: `docker rmi my_image`

Delete container: `docker rm my_container`

SSH to a container: `docker exec -it container_name /bin/bash`