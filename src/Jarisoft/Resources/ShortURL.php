<?php

/**
 * This class is a simple container and holds all information that maps a 
 * shortURL to a target. 
 * 
 * In this appliaction shortURLs have a life cycle and once they are out of 
 * date they cannot be accessed any more.
 * 
 * 
 * @author jakob
 * @version 0.0.1
 */
class ShortURL
{

    private $id;

    private $shortName;

    private $target;

    private $dateCreated;

    private $dateExpired;

    private $host;

    /**
     * Constructor with optional url as parameter of the server that this application is
     * on.
     *
     * @param string $targetHost            
     */
    public function __construct($targetHost = "")
    {
        $this->host = $targetHost;
    }

    /**
     * Checks if this ShortURL is expired
     *
     * @return boolean true if expired otherwise false;
     */
    public function isExpired()
    {
        return (time() < $this->dateExpired);
    }

    /**
     * Returns the Id of this ShortURL
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the Id of this ShortURL
     *
     * @param int $id            
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Returns the ShortURL that will be append to the running host.
     *
     * Example: http://www.example.com/SQQS
     * Here shortName is SQQS and http://www.example.com/ is the host name.
     *
     * @return string the shortName
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     *  Sets the shorter URL tag 
     *  @see getShortName()
     * @param string $shortName            
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;
        return $this;
    }

    /**
     * Returns the targetURL for this ShortURL object. 
     * 
     * The targetURL is the URL that this ShortURL points to.
     * 
     * @return string the target url
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Sets the target url for this ShortURL.
     * 
     * @param string $target            
     */
    public function setTarget($target)
    {
        $this->target = $target;
        return $this;
    }

    /**
     * Get unix timestamp of when this ShortURL was created.
     * 
     * @return unix timestamp
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set the unix timestamp for this ShortURL of when it was created.
     * @param int $dateCreated            
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * Gets the expired date as unix timestamp.
     * 
     * @return the int as unix timestamp
     */
    public function getDateExpire()
    {
        return $this->dateExpired;
    }

    /**
     * Set the expired date for this ShortURL . 
     * @param int $dateExpire as unix timestamp
     */
    public function setDateExpire($dateExpire)
    {
        $this->dateExpired = $dateExpire;
        return $this;
    }

    /**
     * Returns the full url that will be produced by host + / + shortURL
     * @return string 
     */
    public function getFullShortUrl()
    {
        if (strlen($this->host) === 0) {
            return $_SERVER['HTTP_REFERER'] . "/" . $this->getShortName();
        } else {
            return $this->host . "/" . $this->getShortName();
        }
    }

    /**
     * Formats the expired date and returns it.
     */
    public function getDateExpiredFormatted()
    {
        $date = new DateTime();
        $date->setTimestamp($this->getDateExpire());
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Formats the creation date and returns it. 
     */
    public function getDateCreatedFormatted()
    {
        $date = new DateTime();
        $date->setTimestamp($this->getDateCreated());
        return $date->format('Y-m-d H:i:s');
    }
}