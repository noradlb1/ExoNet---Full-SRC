<?php

class Connection{

    public function dbConnect(){
        return new PDO('mysql:host=localhost;dbname=exon_forum', 'username', 'password');
    }
}
?>