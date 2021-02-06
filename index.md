# This is a library for easy use of the MySql :)
When I started programming, the database was very confusing to me, and I was using `json`, which was really awful.
Later I tried to learn the database !
And today I prepared these methods so that novices can use the database more easily.

_I hope it is useful for you._


# Guide
In the following, I have written a description on how to use it

- ## Attach lib
  - We should use `require_once` to use of library.
  - ### Ex :
      ```php
      require_once 'Sql.php';
      ```

- ## Create an instance and start connection
  - now, we need a handler for using `class`
  - ### Syntax :
      `$DB = new MySQL(Host_Name, Username, Password);`
      
      ----- | -----------
      **Host_Name** | your host name
      **Username** | your username
      **Password** | your password
  - ### Ex :
      ```php
      $DB = new MySQL('localhost', 'root', '');
      ```

- ## Create a new Database
  - now, we need a handler for using `class`
  - ### Syntax :
      `$DB->new_db(Database) : BOOL(true/false)`
  - ### Values :
    - **Database** : a name for new database
  - ### Ex :
      ```php
        if($DB->new_db('MyDB'))
        {
            echo 'New DB Created : MyDB';
        }
        else
        {
            var_dump($DB->error);
        }
      ```
 






