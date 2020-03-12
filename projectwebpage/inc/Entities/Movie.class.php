<?php

Class Movie {

    //Attributes
    private $movieid;
    private $title;
    private $releaseyear;

    //Getters
    public function getMovieid() {
        return $this->movieid;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getReleaseYear() {
        return $this->releaseyear;
    }

    //Setters
    public function setMovieid($movieid){
        return $this->movieid=$movieid;
    }

    public function setTitle($title){
        return $this->title= $title;
    }

    public function setReleaseYear($year){
        return $this->releaseyear= $year;
    }

}

?>