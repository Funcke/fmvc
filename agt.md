---
description: "We only serve models here \U0001F481‍♂️\U0001F481‍♀️"
---

# Chill your \(Data-\)base, bro 👥

## Database Access

FMVC provides an abstracted connection to SQL Databases. This abstraction is called: `Core/Data/SqlDataBase`. This abstraction enables automatic configuration from a pool of previously defined connections. Those connections can be specified in `config/db.json`:

```javascript
{
 "default": {
  "protocol": "mysql",
  "host": "localhost",
  "username": "root",
  "password": "root",
  "port": "3306",
  "databse": "my_db"
 }
}
```

### Configure a database connection

Internally, FMVC used PDO to provide a generic approach to connecting to all kinds of databases. To generate the corresponding connection string, the framework loads the components from the configuration specified by the string passed to it's constructor:

```php
use Core\Data\SqlDataBase;
$conn = new SqlDataBase("default");
```

Depending on the type of the database \(especially SQLite3\) the format of the connection string differs. Here are the two supported formats:

* Normal SQL-databases:

```javascript
{
  "default": {
    "protocol": "mysql|pgsql|mssql",
    "host": "localhost",
    "username": "root",
    "password": "root",
    "port": "3306",
    "databse": "my_db"
 }
}
```

* SQLite:

```javascript
{
    "default": {
        "protocol": "sqlite",
        "host": "file.db",
        "username": "",
        "password": "",
        "port": "",
        "database": ""
    }
}
```

## Connect with your peers... aaahm sorry, I mean database

Now that we have the credentials, we are ready to connect to our database. Luckily, our database class does that for us.

A connection is cool, yeah, but what a database really does for us is providing access to persistent data. `Core/Data/SqlDataBase` also has some for that in it's pocket:

### exec \(or: I'll just want to know if you got my message\)

`exec(string $query): int` provides a point to execute ddl statements like insert, update or delete statements. This method will only pass on the status returned from the query.

```php
use Core\Data\SqlDataBase;
$base = new SqlDataBase("local");
echo $base->execute(
    "Insert into users(nr, name, stuff) values(1, 'name', 'stuff')"
);
```

This query would return 1 as 1 dataset was affected.

### query aka. fuck it, I'll take like a bazillion

`query(string $query): array` is the interface point for all your DataQueryLanguage stuff. Does not matter if you want one or - maybe you already guessed it - a bazillion datasets. Just pass your query to this baby and it will fulfill your wildest data dreams ...or return an empty array, if you fucked it up.

```php
use Core\Data\SqlDataBase;
$base = new SqlDataBase("local");
print_r( $base->query(
    "SELECT * from users"
));
```

In this case print\_r would output all datasets found in the users table.

We hope you got some insight into how FMVC works with databases. Have fun!

