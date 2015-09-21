; This configuration file is used to store information such as database 
; connection details

[db]
username = %username%
password = %password%
host = %dbhost%
database = urlshortener

[shortener]
targetURL = %server%
; if following line is off we do 
; not allow redirection to a redirecting page
redirect = on
