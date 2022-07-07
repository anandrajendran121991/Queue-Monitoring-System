## Laravel + Docker Using Apache Base Image

Make sure you download the docker desktop based on your operating system

#### Mac

https://docs.docker.com/desktop/mac/install/

#### Windows

https://docs.docker.com/desktop/windows/install/

### Steps to get the application running on your machine.

#### Docker Swarm

1. Clone this repository

   ```
   git clone https://github.com/imadevguyanand/laravel-docker-boilerplate.git
   ```

2. In the local folder make a copy of conf.template.sh called conf.sh.

3. Fill out the variables in in conf.sh.
   Some notes and example values are below:

   ```
   # Local Variables
   export HOST_ADDRESS= Should either be "docker.for.win.localhost" or "docker.for.mac.localhost" depending on what system you are using

   # The port you want the app to run on your system
   export APP_PORT_PREFIX= the port your application will be on is APP_PORT_PREFIX + 080
   Ex: if APP_PORT_PREFIX=57 then your application will be on localhost:57080

   # Directory you want the logs, sessions, cache and views to go in
   export MOUNT_DIR= path to your mount folder (if it doesn't exist the set-up script will create it).

   # Path to this project root,
   export APP_DIR= path to the project on your local machine.
   Ex: /Users/arajendran/Documents/PROJECTS/laravel-docker-boilerplate
   ```

4. In a terminal window navigate to the laravel-docker-boilerplate folder and run:

   ```
   local/up.sh
   ```

   This will create the docker environment and it will take several minutes to run. This command will build the docker image and deploy the stack

5. Make sure the container is running by executing the command

   ```
   docker ps
   ```

   ![Deploy!](https://drive.google.com/uc?export=view&id=1ixtu2HjbyrBQC7TjhOXiW1RJeACSwzW3)

6. Once the service has been deployed exec into the container by entering:

   ```
   docker exec container_name_or_id -it bash
   ```

7. Change the path to the root of the aplication by running:

   ```
   cd /var/www/html
   ```

8. Install all the packages the application needs. This will take few minutes

   ```
   composer install
   ```

9. Navigate to http://localhost:{APP_PORT_PREFIX}
