# This is a library for easy use of the MySql :)
When I started programming, the database was very confusing to me, and I was using `json`, which was really awful.
Later I tried to learn the database !
And today I prepared these methods so that novices can use the database more easily.

_I hope it is useful for you._


# Guide
In the following, I have written a description on how to use it

- ## [1] Attach lib
  - **We should use `require_once` to use of library.**
  - ### Ex :
      ```php
      require_once 'Sql.php';
      ```

- ## [2] Create an instance and start connection
  - **Now, we need a handler for using `class`**
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

- ## [3] Create Database
  - **This way you can create a database**
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

- ## [4] Create Table
  - **This way you can create a table in the database**
  - ### Syntax :
      `$DB->new_table(Database, Table, [ [Column_1, Option_1], [Column_2, Option_2], [Column_3, Option_3]) : BOOL(true/false)`
      
      Value | Description
      ----- | -----------
      Database | name of a database that already exists
      Table | name for new table
      Column | column name
      Option | some option for column. (default : `VARCHAR(500)`) [_sql code_]
  - ### Points :
    - default option for column `id` is `INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY`, but you can set your custom options.
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

- ## [5] Insert data
  - **Use this method to insert data in a database.**
  - ### Syntax :
      `$DB->put(Database, Table, [ Column_1=>Data_1, Column_2=>Data_2, Column_3=>Data_3) : BOOL(true/false)`
      
      Value | Description
      ----- | -----------
      Database | name of a database that already exists
      Table | name of a table that already exists in Database
      Column | column name
      Data | the data you want to save in that column
  - ### Points :
    - if column options have `NOT NULL` ,you should not leave its column empty.
    - You can get last id by : `$DB->id` .
  - ### Ex :
      ```php
        if($DB->put('MyDB', 'MyTable', [
            //The 'id' will be registered automatically (because we don`t set custom option)
            'first_name'  =>  'Saeed',                //can't be empty and up than 50 characters(because we set 'VARCHAR(50) NOT NULL')
            'last_name'   =>  'Golestani',            //can be empty but can`t be up than 50 characters(because we set 'VARCHAR(50)')
            'bio'         =>  'i`m sad programer :(', //can be empty but can`t be up than 500 characters(because we don`t set custom option and defult is 'VARCHAR(500)')
            'email'       =>  'Developer@Sylix.ir',   //can't be empty and up than 100 characters(because we set 'VARCHAR(100) NOT NULL')
            //The 'registry_date' will be registered automatically (because we set 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
        ]))
        {
            echo 'Saeed Registered | id : ' . $DB->id;
        }
        else
        {
            var_dump($DB->error);
        }
      ```

- ## [6] Update data
  - **Use this method to update previously registered data.**
  - ### Syntax :
      `$DB->update(Database, Table, [ Search_column=>Column_data, [Column_1=>New_data_1, Column_2=>New_data_2] ]) : BOOL(true/false)`
      
      Value | Description
      ----- | -----------
      Database | name of a database that already exists
      Table | name of a table that already exists in Database
      Search_Column | the name of the column in which the data will be searched
      Column_data | the data we are looking for in the `Search_Column`
      Column | a column whose data will change to `New_data`
      New_Data | the data will be updated in the `Column`
  - ### Points :
    - the Column_data is better to be unique.
  - ### Ex :
      ```php
        if($DB->update('MyDB', 'MyTable', [
            'first_name'=>'Saeed', //For search
            [
                'first_name'  =>  'Mr.Saeed', //For Update
                'bio'         =>  'i`m happy programer :(', //For update
            ]
        ]))
        {
            echo 'Updated successfully!';
        }
        else
        {
            var_dump($DB->error);
        }
      ```

- ## [7] Get data(_SELECT_)
  - **Use this method to get data from some column of a row in a table.**
  - ### Syntax :
      `$DB->get(Database, Table, [ Search_column=>Column_data, [Column_1, Column_2] ]) : Array/False`
      
      Value | Description
      ----- | -----------
      Database | name of a database that already exists
      Table | name of a table that already exists in Database
      Search_Column | the name of the column in which the data will be searched
      Column_data | the data we are looking for in the `Search_Column`
      Column | columns whose data you want
  - ### Points :
    - for get all Columns data use `*` or `ALL_DATA` instead of Columns name
      ex :
        `$DB->get(Database, Table, [ Search_column=>Column_data, ['*'] ]);`
        or
        `$DB->get(Database, Table, [ Search_column=>Column_data, ['ALL_DATA'] ]);`
  - ### Ex :
      ```php
        $result = $DB->get('MyDB', 'MyTable', [
            'first_name'=>'Saeed',
            ['first_name', 'bio', 'email']
        ]);

        if($result !== False)
        {
            var_dump($result);
        }
        else
        {
            var_dump($DB->error);
        }
      ```

- ## [8] Get all data(_SELECT_)
  - **Use this method to get data from some column of all row in a table.**
  - ### Syntax :
      `$DB->get(Database, Table, [ 'DB_GET_ALL'=>[Column_1, Column_2] ]) : Array/False`
      
      Value | Description
      ----- | -----------
      Database | name of a database that already exists
      Table | name of a table that already exists in Database
      Column | columns whose data you want
  - ### Points :
    - for get all Columns data use `*` or `ALL_DATA` instead of Columns name
      ex :
        `$DB->get(Database, Table, [ 'DB_GET_ALL'=>['*'] ]);`
        or
        `$DB->get(Database, Table, [ 'DB_GET_ALL'=>['ALL_DATA'] ]);`
  - ### Ex :
      ```php
        $result = $DB->get('MyDB', 'MyTable', [
            'DB_GET_ALL'=>['first_name', 'last_name', 'bio', 'email']
        ]);

        if($result !== False)
        {
            var_dump($result);
        }
        else
        {
            var_dump($DB->error);
        }
      ```
 






