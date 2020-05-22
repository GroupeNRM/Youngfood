<?php

namespace App\Entity;

class UserSearch {

    /**
     * @var string|nul
     */
    private $email;

    
    /**
     * @var string|nul
     */
    private $firstname;

    
    /**
     * @var string|nul
     */
    private $lastname;

    /**
     * @return string|nul
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string|nul $email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|nul
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string|nul $firstname
     *
     * @return self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string|nul
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string|nul $lastname
     *
     * @return self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }
}