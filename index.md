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
  - ### Values :
    - **Host_Name** : your host name
      -Saeed
    - **Username** : your username
    - **Password** : your password
  - ### Ex :
      ```php
      $DB = new MySQL('localhost', 'root', '');
      ```


syntax : `$DB = new MySQL(Host_Name, Username, Password);`

```
$DB = new MySQL(Host_Name, Username, Password);
```

Here is a list of methods for guide you to how can to use :


```

```markdown
Syntax highlighted code block

# Header 1
## Header 2
### Header 3

- Bulleted
- List

1. Numbered
2. List

**Bold** and _Italic_ and `Code` text

[Link](url) and ![Image](src)
```

For more details see [GitHub Flavored Markdown](https://guides.github.com/features/mastering-markdown/).

### Jekyll Themes

Your Pages site will use the layout and styles from the Jekyll theme you have selected in your [repository settings](https://github.com/SylixTeam/MySql/settings). The name of this theme is saved in the Jekyll `_config.yml` configuration file.

### Support or Contact

Having trouble with Pages? Check out our [documentation](https://docs.github.com/categories/github-pages-basics/) or [contact support](https://support.github.com/contact) and we’ll help you sort it out.
