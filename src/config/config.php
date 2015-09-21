; This configuration file is used to store information such as database 
; connection details

[db]
username = %username%
password = %password%
host = localhost
database = urlshortener

[shortener]
targetURL = %http://www.serveraddress.com
; if following line is off we do 
; not allow redirection to a redirecting page
redirect = on