# Ardularm

Ardularm is a school project which focuses on making an inexpensive alarm based on the Arduino platform.

## Motivation

This is a proof-of-concept. Arduino is very powerful!

## Wiring

TO-DO

## Installation

To run this project on your own, there are a few steps necessary:

1. Fill in the settings file with the right credentials for your database. TO-DO
2. Run the `server\create.php` script. This will create all the tables needed for the project and necessary values.
3. Create a `server\.htpasswd` file (https://faq.oit.gatech.edu/content/how-do-i-do-basicauth-using-htaccess-and-htpasswd) with your desired user name and password.
4. Upload content of `server` on your server.
5. Set the values at the beginning of the code in `Arduino\Ardularm\Ardularm.ino`.
6. Wire up your Arduino UNO according to Wiring section of this document.
7. Upload `Arduino\Ardularm\Ardularm.ino` on your Arduino UNO.
8. Enjoy your safety.

## License

See LICENSE.txt
