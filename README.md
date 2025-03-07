Heston
=========
Heston is just FTP Wrapper, writter in PHP with Git-Powered inside it. It means Heston really need Git to be installed first in our working project directory before we can use it. 

Requirement
-----------
* PHP >= 5.3.*

Installation
------------
Via Composer

    {
        "require": {
            "heston/heston": "dev-master"
        }
    }

and type this command below to make sure that Heston is ready to use

    vendor\bin\heston help
    
Basic Usage
-----------
Just specify the URL of the FTP Server, Username - Password, and local directory that contains the files you want to upload. For example, we have a directory called **repo** in our project directory, looks like 

    - MyProject
      * file_1
      * file_2
      - repo
        * repo_file_1
        * repo file_2

Lets say, the URL of our FTP is ftp://ftp.glendmaatita.com in port 21, username and password are root-secret. So we will run a command like this

    vendor\bin\heston ftp://root:password@ftp.glendmaatita.com:21 repo/ "Upload file"
    
The last argument is comment, which is optional

If we want to upload entire of **MyProject** directory, simply change **repo/** to dot, like this
    
    vendor\bin\heston ftp://root:password@ftp.glendmaatita.com:21 . "Upload file"

The files will upload to directory of the FTP's user and automatically committed by Heston with comment you provide before.

License
----

MIT 
    