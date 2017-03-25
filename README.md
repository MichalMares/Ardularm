# Ardularm

Ardularm is a school project which focuses on making an inexpensive alarm based on the Arduino platform.

## Motivation

This is a proof-of-concept. Arduino is very powerful!

## Wiring

Wiring can be seen in `Ardularm (wiring).fzz` (via Fritzing) or as in PNG format in `Ardularm (wiring).png`.   
Used components are:
* Arduino UNO Rev3
* Ethernet Shield R3
* RFID Reader RC522
* Passive Infrared Sensor HC-SR501 
* Generic RGB Diode

(Other components might work as well - not tested.)

## Installation

To run this project on your own, there are a few steps necessary:

1. Wire up your Arduino with all the components.
2. Fill in the variables in `Arduino\Ardularm\Ardularm.ino` under the comment "user-configurable".
3. Fill in the settings file with the right credentials for your database in `Server\config.template.php` and save it as `Server\config.php`.
4. Run the `Server\create.php` script. This will create all the tables needed for the project and necessary values.
5. Create a `Server\.htpasswd` file with your desired user name and password (https://faq.oit.gatech.edu/content/how-do-i-do-basicauth-using-htaccess-and-htpasswd).
6. Upload content of `Server` on your server.
7. Wire up your Arduino UNO according to Wiring section of this document.
8. Upload `Arduino\Ardularm\Ardularm.ino` on your Arduino UNO.
9. Enjoy your safety.

## How to use Ardularm?

**How to turn Ardularm on/off?**   
Trusted card has to be used to toggle the state. When the alarm is on the diode turns read, when off it is green.

**How to add my card into trusted?**   
First, MasterTag has to be detected and the diode turns blue. Then you can scan your card and it will be added as trusted. BEWARE: If your card is already trusted, it will be removed.

**How to view the log?**   
Log is located on the server at `../dash.php`.

## License

[MIT](https://github.com/MichalMares/Ardularm/blob/arduino/LICENSE.txt) @ [Michal Mareš](https://github.com/MichalMares)
