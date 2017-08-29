# WordPress Webpack + SCSS + BootStrap 4 + Composer + Docker

This project aims to provide a simple to deploy WordPress boilerplate with inbuilt composer and docker support.

## Launching the docker environment

### Local development

For local development use the docker-compose.local



For staging use the docker-compose.stage
For production use the docker-compose.prod

## Theme Development

All theme development is done within the theme folder. When deployed the theme folder will be copied/moved/symlinked to public/wp-content/themes/boilerplate.

## SCSS and JS development

All JS and SCSS development is done within the src folder. When webpack is run a dist folder will be created within the theme folder. A webpack helper class will include the compiled JS and CSS assets within your theme.

Be sure to run yarn install and then yarn build:dev when you first setup your project

## Adding plugins

The project is set up to easily work with deployments such as AWS or Google cloud where uploads, plugins, cache is better stored in persistent storage and shared with multiple instances. This is of course only optional. If you wish to install custom plugins place them within the storage/plugins folder. They will automatically be copied to /public/wp-content during deploy

## File uploads

To better work with AWS and Google persistent storage all uploads can be found within the /storage/uploads folder. This folder will be copied to /public/wp-content/uploads when deployed.

## Mounting persistent storage

Mount your persistent volumes individually to /public/wp-content/plugins, /public/wp-content/uploads etc

## Adding ACF Key

TODO

## Customizing BootStrap

TODO

## Adding fonts

TODO

## Private networks

Add the following to the container instance

networks:
  - docker-net

Add the following to the docker-compose

networks:
  docker-net:
    external: true
