# User Management System

## Description
User Management System is a system with user authentication and permission levels. It allows users to register, log in, and perform various actions based on their permission levels. 
It also includes a ticketing system and a tracking system for user actions.

## Features

### Authentication
- Login
  - Remember me
  - Show/Hide password
  - Restore password (once per day with a message displaying the next available restore time)
  - Change password
- Security
  - Three or more failed attempts result in a one-hour ban
- Logging
  - Logs user IP, browser details, login attempts (successful & failed), and timestamps

### User Permissions
- Three permission levels:
  - **Level 1** (Highest):
    - View and change any user's password and email
    - Ban users for a specific time
    - Remove bans for failed attempts or restore password time
    - Delete any user
  - **Level 2**:
    - View and change any user's password and email
    - Ban users for a specific time
  - **Level 3**:
    - View user email
    - Change own password

### Ticket System
- **Create Ticket** (Permission required: Level 1-2)
  - Title, Description, Status
  - Associate with a user
- **View Ticket** (Permission required: Level 1-3)
  - Add comments
  - Edit own comments
  - Edit other users' comments (Level 1-2 required)
  - Edit title and description (Level 1 required)
  - Change status (Level 1-2 required)
- **Delete Ticket** (Permission required: Level 1)

### Tracking System
- Tracks user actions for login and ticket system
- Dynamic interface to view user actions by selecting a user

## Technologies Used
- CodeIgniter 3 (PHP framework)
- PHP
- Bootstrap (CSS framework)
- jQuery & JavaScript

## Installation
1. Install [XAMPP](https://www.apachefriends.org/index.html).
2. Start Apache and MySQL servers.
3. Clone or download the project into your `htdocs` folder:
   ```sh
   git clone https://github.com/repoName/user-management-system.git///// Add the repo link
   ```
The downloaded folder should be named "ums" in order to run the project. Otherwise you need to set the configuration: 
- Go to aplication/config/config.php and set $config['base_url'] = 'http://localhost/ums/';
If the project folder is named some other way change the path with the name of the folder

4. Open the browser and go to:
   ```
   http://localhost/ums
   ```
5. Ensure the database is set up correctly in `localhost/phpmyadmin`.
For the purpose create a database named "user-management-system" and IMPORT the "user-management-system-db.sql" file from the root directory in the project. 
That way the DB and the UMS Codeigniter project will be synchronized.

6. Configure database settings in `application/config/database.php` if necessary.
- Go to aplication/config/database.php and set 'database' => 'user-management-system'

7.Have in mind that registered users have "permission_level" = 3 by default. When you register, 
you need to change the "permission_level" to 1 manually in the localhost/phpmyadmin database in order to have full access to the project functionality.

## License
This project is licensed under the MIT License.
