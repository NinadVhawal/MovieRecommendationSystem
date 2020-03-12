<?php


Class User {

    //Attributes
    private $userid;
    private $gender;
    private $age;
    private $occupation;
    private $email;
    private $password;
    private $phone;

    //Getters
    public function getUserid() {
        return $this->userid;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getAge() {
        return $this->age;
    }

    public function getOccupation() {
        return $this->occupation;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getPhone() {
        return $this->phone;
    }
  
    //Setters

    public function setUserid($uid){
        return $this->userid=$uid;
    }

    public function setGender($gender){
        return $this->gender= $gender;
    }

    public function setAge($age){
        return $this->age=$age;
    }

    public function setOccupation($occupation){
        return $this->occupation=$occupation;
    }

    public function setEmail($email){
        return $this->email=$email;
    }

    public function setPassword($pass){
        return $this->password=$pass;
    }

    public function setPhone($phn){
        return $this->phone=$phn;
    }
}

?>