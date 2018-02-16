# WordPress Boilerplate
## ACF Pro + Webpack + SCSS + BootStrap 4 + Composer + Docker

### This project has been moved to https://github.com/sackrin/fusion-wp and is no longer maintained

This project aims to provide a simple to use boilerplate for WordPress by bringing in multiple modern web technologies for client side, server side and hosting. This project approaches WordPress from a professional development perspective and is aimed at developers. It is not intended to be used by non developers or people new to WordPress. It is designed to create a philosophy for modern WordPress development using NodeJS, composer, docker and be continuous integration ready.

## Quick Start Guide

For local development update the docker-compose configuration file found within .docker/local (if needed) and then perform the following actions. Remember that local will spin up an internal apache and mysql server unique to your project. They will be mapped against port 80, 443 and 3306 on your computer. If you already have services listening on theses addresses you will encounter errors. Either close existing services or change the mapping within the docker compose configuration file.

### Start up on a local machine

1. Run composer install
2. Run npm install
3. Run npm run build:dev
4. Run sudo docker-compose -f .docker/local/compose.yml build
5. Run sudo docker-compose -f .docker/local/compose.yml up
6. Access and perform the setup at http://localhost
7. Activate the boilerplate theme

### Development Services

1. HTTP will be accessible via http://localhost
2. HTTPS will be accessible via https://localhost
3. MySQL will be accessible via 127.0.0.1 on port 3306
4. S3 Dashboard will be accessible via https://localhost:9000

### Theme Development

All theme development is done within the \theme folder. When deployed the theme folder will be moved or symlinked (depending on the deployment) to public/wp-content/themes/boilerplate. These settings can be changed within the docker-compose.yml files and the Dockerfile however it is recommended to leave as default.

### SCSS and JS development

All JS and SCSS development is done within the src folder. When webpack is run a dist folder will be created within the theme folder. A webpack helper class will include the compiled JS and CSS assets within your theme.

Be sure to run npm install and then npm run build:dev when you first setting up your project

### Adding plugins

The project is set up to easily work with deployments such as AWS or Google cloud where uploads, plugins, cache is better stored in persistent storage and shared with multiple instances. This is of course only optional. If you wish to install custom plugins place them within the storage/plugins folder. They will automatically be copied to /public/wp-content during deploy.

To add plugins for local add them to storage/plugins

### File uploads

To better work with AWS and Google persistent storage all uploads can be found within the /storage/uploads folder. This folder will be copied to /public/wp-content/uploads when deployed.
