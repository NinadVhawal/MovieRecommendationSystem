<?php

Class Rating {

    //Attributes
    private $rating;
    private $review;
    private $email;

    //Getters
    public function getRating() {
        return $this->rating;
    }

    public function getReview() {
        return $this->review;
    }

    public function getEmail() {
        return $this->email;
    }

    //Setters
    public function setRating($rating){
        return $this->rating=$rating;
    }

    public function setReview($review){
        return $this->review= $review;
    }

}

?>