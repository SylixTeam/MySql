# This is a library for easy use of the MySql :)
When I started programming, the database was very confusing to me, and I was using `json`, which was really awful.
Later I tried to learn the database !
And today I prepared these methods so that novices can use the database more easily.

_I hope it is useful for you._

# Guide
In the following, I have written a description on how to use it
**•** | **Title** | **Description**
----- | --------- | ---------------
1 | Attach lib | require_once lib
2 | Start connection | create handler and connect to database
3 | Create Database | create new database
4 | Create Table | create new table in a database
5 | Insert data | insert new data in database
6 | Update data | update previously registered data
7 | Get data | get data from some column of a row in a table
8 | Get all data | get data from some column of all row in a table
9 | Delete data | delete row from a table
10 | Delete Table | remove a table of database (drop a table)
11 | Delete Database | remove a database (drop a database)
12 | Get tables | get a list of tables in a database
13 | Get databases | get a list of all databases
14 | Existence database | check the existence of the database
15 | Existence table | check the existence of the table in a database
16 |Error Handler | use this method to get errors



> ## [1] Attach lib
  - **We should use `require_once` to use of library.**
  - ### Example :
      ```php
      require_once 'Sql.php';
      ```

> ## [2] Create an instance and start connection
  - **Now, we need a handler for using `class`.**
  - ### Syntax :
      `$DB = new MySQL(Host_Name, Username, Password);`
      
      Value | Description
      ----- | -----------
      Host_Name | your host name
      Username | your username
      Password | your password
  - ### Example :
      ```php
      $DB = new MySQL('localhost', 'root', '');
      ```

> ## [3] Create Database
  - **This way you can create a database.**
  - ### Syntax :
      `$DB->new_db(Database) : BOOL(true/false)`
      
      Value | Description
      ----- | -----------
      Database | a name for new database
  - ### Example :
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

> ## [4] Create Table
  - **This way you can create a table in the database.**
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
  - ### Example :
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

> ## [5] Insert data
  - **Use this method to insert data in a database.**
  - ### Syntax :
      `$DB->put(Database, Table, [ Column_1=>Data_1, Column_2=>Data_2, Column_3=>Data_3) : BOOL(true/false)`
      
      Value | Description
      ----- | -----------
      Database | name of a database that already exists
      Table | name of a table that already exists in `Database`
      Column | column name
      Data | the data you want to save in that `Column`
  - ### Points :
    - if column options have `NOT NULL` ,you should not leave its column empty.
    - You can get last id by : `$DB->id` .
  - ### Example :
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

> ## [6] Update data
  - **Use this method to update previously registered data.**
  - ### Syntax :
      `$DB->update(Database, Table, [ Search_column=>Column_data, [Column_1=>New_data_1, Column_2=>New_data_2] ]) : BOOL(true/false)`
      
      Value | Description
      ----- | -----------
      Database | name of a database that already exists
      Table | name of a table that already exists in `Database`
      Search_column | the name of the column in which the data will be searched
      Column_data | the data we are looking for in the `Search_column`
      Column | a column whose data will change to `New_data`
      New_Data | the data will be updated in the `Column`
  - ### Points :
    - the Column_data is better to be unique.
  - ### Example :
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

> ## [7] Get data
  - **Use this method to get data from some column of a row in a table.**
  - ### Syntax :
      `$DB->get(Database, Table, [ Search_column=>Column_data, [Column_1, Column_2] ]) : Array/False`
      
      Value | Description
      ----- | -----------
      Database | name of a database that already exists
      Table | name of a table that already exists in `Database`
      Search_column | the name of the column in which the data will be searched
      Column_data | the data we are looking for in the `Search_column`
      Column | columns whose data you want
  - ### Points :
    - for get all Columns data use `*` or `ALL_DATA` instead of Columns name.
      - `$DB->get(Database, Table, [ Search_column=>Column_data, ['*'] ]);`
      - `$DB->get(Database, Table, [ Search_column=>Column_data, ['ALL_DATA'] ]);`
  - ### Example :
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

> ## [8] Get all data
  - **Use this method to get data from some column of all row in a table.**
  - ### Syntax :
      `$DB->get(Database, Table, [ [Column_1, Column_2] ]) : Array/False`
      
      Value | Description
      ----- | -----------
      Database | name of a database that already exists
      Table | name of a table that already exists in `Database`
      Column | columns whose data you want
  - ### Points :
    - for get all Columns data use `*` or `ALL_DATA` instead of Columns name.
      - `$DB->get(Database, Table, [ ['*'] ]);`
      - `$DB->get(Database, Table, [ ['ALL_DATA'] ]);`
  - ### Example :
      ```php
        $result = $DB->get('MyDB', 'MyTable', [
            ['first_name', 'last_name', 'bio', 'email']
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

> ## [9] Delete data
  - **Use this method to delete row from a table.**
  - ### Syntax :
      `$DB->Delete(Database, Table, [ Search_Column=>Column_data ] ]) : Int/False`
      
      Value | Description
      ----- | -----------
      Database | name of a database that already exists
      Table | name of a table that already exists in `Database`
      Search_column | the name of the column in which the data will be searched
      Column_data | the data we are looking for in the `Search_column` and Delete it
  - ### Points :
    - you can also Delete multiple sections at once.
      - `$DB->Delete(Database, Table, [ Search_Column_1=>Column_data_1, Search_Column_2=>Column_data_2 ]);`
  - ### Example :
      ```php
        if($DB->Delete('MyDB', 'MyTable', ['first_name'=>'Mr.Saeed','id'=>'2', 'id'=>'3']))
        {
            echo 'Data Deleted successfully!';
        }
 
        else
        {
            var_dump($DB->error);
        }
      ```


> ## [10] Delete Table (Use Carefully)
  - **Use this method to remove a table of database (drop a table).**
  - ### Syntax :
      `$DB->remove_table(Database, Table) : BOOL(true/false)`
      
      Value | Description
      ----- | -----------
      Database | name of a database that already exists
      Table | name of a table that already exists in `Database`
  - ### Example :
      ```php
        if($DB->remove_table('MyDB', 'MyTable'))
        {
            echo 'Table Deleted successfully!';
        }
        else
        {
            var_dump($DB->error);
        }
      ```

- ## [11] Delete Database (Use Carefully)
  - **Use this method to remove a database (drop a database).**
  - ### Syntax :
      `$DB->remove_db(Database) : BOOL(true/false)`
      
      Value | Description
      ----- | -----------
      Database | name of a database that already exists
  - ### Example :
      ```php
        if($DB->remove_db('MyDB'))
        {
            echo 'Database Deleted successfully!';
        }
        else
        {
            var_dump($DB->error);
        }
      ```

> ## [12] Get tables
  - **Use this method to get a list of tables in a database.**
  - ### Syntax :
      `$DB->get_tables(Database) : Array/False`
      
      Value | Description
      ----- | -----------
      Database | name of a database that already exists
  - ### Example :
      ```php
        var_dump($DB->get_tables('MyDB'));
      ```

> ## [13] Get databases
  - **Use this method to get a list of all databases.**
  - ### Syntax :
      `$DB->get_dbs() : Array/False`
      
  - ### Example :
      ```php
        var_dump($DB->get_dbs());
      ```

> ## [14] Existence database
  - **Use this method to check the existence of the database.**
  - ### Syntax :
      `$DB->exists_db(Database) : BOOL(true/false)`
      
      Value | Description
      ----- | -----------
      Database | the name of the database you want to check
  - ### Example :
      ```php
        if($DB->exists_db("MyDB"))
        {
            echo "Database Exists";
        }
        else
        {
            echo "Database Does Not Exists";
        }
      ```

> ## [15] Existence table
  - **Use this method to check the existence of the table in a database.**
  - ### Syntax :
      `$DB->exists_db(Database, Table) : BOOL(true/false)`
      
      Value | Description
      ----- | -----------
      Database | name of a database that already exists
      Table | the name of the table you want to check
  - ### Example :
      ```php
        if($DB->exists_table("MyDB", "MyTable"))
        {
            echo "Table Exists";
        }
        else
        {
            echo "Table Does Not Exists";
        }
      ```

> ## [16] Error Handler
  - **Use this method to get errors.**
  - ### Syntax :
    - Last Error : `$DB->error() : String`
    - All Errors : `$DB->errors() : String`
      
  - ### Example :
      ```php
        echo "Last Error : " . $DB->error;
        echo "All Errors : " . $DB->errors;
      ```



# Support
**if You Upgrade This Library Tell Me About It**
  * Telegram : [Sylix_Developer](https://t.me/Sylix_Developer)
  * Email    : [Developers@sylix.ir](mailto:Developers@sylix.ir)
