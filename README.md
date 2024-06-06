# IoD App by TriLora Flyers
Hello, we are Alfonso, Fernando, Giuseppe and Ardit, students attending Master Degree in Computer Science - Security Engeneering at University of Bari. This system was developed for the exam of IoT Security.<br>

<p float="center">
    <img src="IoD-App/readme/g_logo.png" alt="alt text" width="200" center/>
</p>

### How does it work?
Web application made with [Laravel framework](https://laravel.com/).
Once coordinates of three gateway are sent to the system, it will start a session.
The session is shown by a map (using [Leaflet javascript library](https://leafletjs.com/)) and it will contain:
- Waypoints for the gatways
- Coverage radius of each gateway (can be activated or deactivated)
- Waypoints of the current drone position
- Waypoints of computed position using LoRa protocol

The data will be sent by a node collocated on a drone. The position of the drone will be computed by knowing the power of the signal reviced by the sigle gateways.

Each time a packet is recived by the gateway, it will do a POST request to our webapp, which will do the appropriate tasks in order to show the data on the session page.

This process is shown by the following figure
![alt text](IoD-App/readme/System%20Architecture.svg?raw=true)
___
# How to run the system
Note that the .env file containing all the credentials was send to our supervisor. Ask him to get the copy that was used for this project. (or you can make a copy of the example and configure it by your own)
## Tips
Avoid downloading the PHP and MySQL installer. They will be installed automatically with XAMPP. If you have them already installed, you will need to check:
- For MySQL, change the DB_HOST and DB_PORT in .env file;
- For PHP you will need to swap the version used by the project.
### Versions
- PHP 8.2.12
- Laravel Framework 9.52.16
- Composer 2.7.4
- XAMPP 3.3.0
- Python (numpy library required for the triangulation)
### Setup the project
1. Download composer [link](https://laravel.com/)
2. Open the terminal inside the folder where you want to clone the repository:
   ```
   git clone https://github.com/AlfonsoPioPretorino/IoD-App.git
   ```
4. Now navigate in the project folder by typing:
   ```
   cd IoD-App
   ```
5. Run the following command to install all the dependencies:
   ```
   composer install
   ```
6. Download and run XAMPP [link](https://www.apachefriends.org/).
7. In the project folder type the following command:
   ```
   php artisan serve
   ```
8. The system should be up and running
