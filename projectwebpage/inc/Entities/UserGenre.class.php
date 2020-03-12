<?php

Class UserGenre {

    //Attributes
    private $genreid;
    private $userid;

    //Getters
    public function getGenreid() {
        return $this->genreid;
    }

    public function getUserid() {
        return $this->userid;
    }

    //Setters
    public function setGenreid($genreid){
        return $this->genreid=$genreid;
    }

    public function setUserid($userid){
        return $this->userid= $userid;
    }

}

?>