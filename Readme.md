# fmvc
A small Model-View-Controller framework.
It aimes heavily on separating code parts to create small, interchangeable components

## How-To Create a route
1. Create class extending Controller base-class in _controller_
2. define routes in config/routes.json just like the examples (attention: identifiers have to be passed as Method parameter and not as URI extension)
3. just use

## Create a view
1. create a php file with content to be displayed in _views_
2. edit base.php as you like. It resembles the basic page layout

## Assets
Stetic assets such as CSS or JS are delivered normally and just have to be inlcuded in the header of base.php

## Database
The DataBase-class provides automated connection to the database.
The corresponding informations have to be put into config/db.json
 -> currently supported are automatic INSERT and SELECT statements
## _Only compatible with apache webserver_
