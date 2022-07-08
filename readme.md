# Laravel + Redis + Horizon Queue System

## Queue monitoring system using Redis as the queue driver integrated with Laravel Horizon to manage jobs running as a Docker container

![Horizon!](https://drive.google.com/uc?export=view&id=1SmsewVokWC0bzA-HBRWM9WPeyyqX7LzK)

Make sure you download the docker desktop based on your operating system

#### Mac

https://docs.docker.com/desktop/mac/install/

#### Windows

https://docs.docker.com/desktop/windows/install/

### Steps to get the application running on your machine.

#### Docker Swarm

1. Clone this repository

   ```
   git clone https://github.com/imadevguyanand/queue-system.git
   ```

2. Sign up for [Sendgrid](https://signup.sendgrid.com/) which is a free email delivery service. We use this service to send emails to the users to demonstrate the queue mechanism in laravel

3. Verify the email account and remember the email used for the signup which we need it later in step 5

4. Once the sign up is completed, navigate to the [settings](https://app.sendgrid.com/settings/api_keys) page and create an API for our application

   ![API!](https://drive.google.com/uc?export=view&id=1cMq9EFQubBfNnwVMMnnrV9x9weU_fYM-)

5. In the local folder make a copy of conf.template.sh called conf.sh.

6. Fill out the variables in in conf.sh.
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
   Ex: /Users/arajendran/Documents/PROJECTS/queue-system

   # Database
   export DB_NAME=Name of the database
   export DB_USER=Database user
   export DB_PASS=Database password

   # Sendgrid configuration
   export MAIL_FROM_NAME=Your Name
   export MAIL_FROM_ADDRESS=Email used to signup for SendGrid
   export MAIL_PASSWORD= The secret key from Sendgrid
   export MAIL_USERNAME=apikey
   export MAIL_HOST=smtp.sendgrid.net
   ```

7. In a terminal window navigate to the queue-system folder and run:

   ```
   local/up.sh
   ```

   This will create the docker environment and it will take several minutes to run. This command will build the docker image and deploy the stack

8. Make sure the container is running by executing the command

   ```
   docker ps
   ```

9. Once the service has been deployed exec into the container by entering:

   ```
   docker exec container_name_or_id -it bash
   ```

10. Change the path to the root of the aplication by running:

    ```
    cd /var/www/html
    ```

11. Install all the packages the application needs. This will take few minutes

    ```
    composer install
    ```

12. Start the Redis server
    ```
    redis-server
    ```
13. Start the Horizon
    ```
    php artisan horizon
    ```
14. Navigate to http://localhost:{APP_PORT_PREFIX}

15. Fill out the form to see the jobs. This will create a user record in the user table and sends out an email to the user

    ![Jobs!](https://drive.google.com/uc?export=view&id=1YFhtqOGbX0KxQ6IrsZkkG17TsLTpLt64)
