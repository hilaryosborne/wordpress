# Only for Docker use

This directory is provided for easier use with the docker engine for both local development and deployment. The local folder is intended for use by a local docker installation. The build directory is intended for building and pushing images to repositories. The deploy folder intended for use to deploy the app to a docker swarm using traefik loadbalancer.

Feel free to modify as you see fit

## Preparing docker files

Before using your docker-compose yml files you will need to change the image name. If you do not do this you will get conflicts with any other docker projects you have running on your computer and it will be difficult to deploy an image to a repository.

Within each yml file change the "image: projectname.com:latest" to your actual repository URL or, if you do not have a docker repository, just change projectname.com to your actual project's domain.

## Building an image

Use the following command to build a staging image
```
sudo docker-compose -f .docker/build/staging build
```

Use the following command to build a production image
```
sudo docker-compose -f .docker/build/production build
```