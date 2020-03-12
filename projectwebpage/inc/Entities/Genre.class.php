<?php

Class Genre {

    //Attributes
    private $genreid;
    private $genre;

    //Getters
    public function getGenreid() {
        return $this->genreid;
    }

    public function getGenre() {
        return $this->genre;
    }

    //Setters
    public function setGenreid($genreid){
        return $this->genreid=$genreid;
    }

    public function setGenre($genre){
        return $this->genre= $genre;
    }

}

?>