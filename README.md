# VGCollection
A simple web app that helps keep track of collections of any kind (such as video games!)

## What You Need
You should have a working local server with access to some kind of MySQL database. I personally use MAMP Pro.

### What the database should look like
Your database should have a sample table that looks something like this:

| id  | name | release_date  | description | user_rating  | region | labels | genres | developers | publishers |
| --- | ---- | ------------  | ----------- | ------------ | ------ | ------ | ------ | ---------- | ---------- |
| 1 | game1 | 6/18/2018  | desc | 4 | US | unplayed | fighting | dev1 | pub1 |
| 2 | game2 | 2/3/2017  | long | 9 | JP | beaten | rpg | dev2 | pub2 |

A sample SQL file is included in case you want to import such a table to your database and save some time. It includes one game ([140, to be exact](https://store.steampowered.com/app/242820/140/)) as an example. Please feel free to play around with this table.
