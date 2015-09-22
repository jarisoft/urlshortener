# urlshortener
Implementation of a url shortening service. 

This project was build using MVC pattern and uses some other design patterns such observer pattern. 

# What it does
This service provides the opportunity to create shorter URLs by a given url.
You can look up an URL and see if it is already used as target URL or as short url. 
This service also checks if a given URL exists and if its a redirecting target. 


The front-end is very simple. It uses bootstrap and jquery. The focus was more on the back-end side. 

Currently the service is hosted under http://local.jarisoft.eu/ for demonstration purposes 
but will be removed from there within the next few days.

# Please note
This application is expecting to find a configuration-file called "config.php" in 
"/src/config/". Currently there is a config.txt included that must be renamed config.php and edited according 
to your own needs.

 