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
  - Now, we need a handler for using `class`
  - ### Syntax :
      `$DB = new MySQL(Host_Name, Username, Password);`
      
      Value | Description
      ----- | -----------
      Host_Name | your host name
      Username | your username
      Password | your password
  - ### Ex :
      ```php
      $DB = new MySQL('localhost', 'root', '');
      ```

- ## Create Database
  - This way you can create a database
  - ### Syntax :
      `$DB->new_db(Database) : BOOL(true/false)`
      
      Value | Description
      ----- | -----------
      Database | a name for new database
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

- ## Create Table
  - This way you can create a table in the database
  - ### Syntax :
      `$DB->new_table(Database, Table, [ [Column_1, Option_1], [Column_2, Option_2], [Column_3, Option_3]) : BOOL(true/false)`
      
      Value | Description
      ----- | -----------
      Database | name of a database that already exists
      Table | name for new table
      Column | column name
      Option | some option for column. (default : `VARCHAR(250)`) [_sql code_]
  - ### Points :
    - default option for column `id` is `INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY` but you can set your custom options.
  - ### Ex :
      ```php
        if($DB->new_table('MyDB', 'MyTable', [
            ['id'                                      ],
            ['first_name'    ,  'VARCHAR(50) NOT NULL' ],
            ['last_name'     ,  'VARCHAR(50)'          ],
            ['bio'                                     ],
            ['email'         ,  'VARCHAR(100) NOT NULL'],
            ['registry_date' ,  'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP']
        ]))
        {
            echo 'New DB Created : MyDB';
        }
        else
        {
            var_dump($DB->error);
        }
      ```


 






