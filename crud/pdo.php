<?php
$pdo = new PDO('mysql:host=localhost;port=8889;dbname=misc', 
   'marcus', 'lee');
// See the "errors" folder for details...
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

