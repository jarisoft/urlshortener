<?php

class ShortURL
{

    private $id;

    private $shortName;

    private $target;

    private $dateCreated;

    private $dateExpired;

    private $host;

    public function __construct($targetHost)
    {
        $this->host = $targetHost;
    }

    public function isExpired()
    {
        return (time() < $this->dateExpired);
    }

    /**
     *
     * @return the unknown_type
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param unknown_type $id            
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @return the unknown_type
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     *
     * @param unknown_type $shortName            
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;
        return $this;
    }

    /**
     *
     * @return the unknown_type
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     *
     * @param unknown_type $target            
     */
    public function setTarget($target)
    {
        $this->target = $target;
        return $this;
    }

    /**
     *
     * @return the unknown_type
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     *
     * @param unknown_type $dateCreated            
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     *
     * @return the unknown_type
     */
    public function getDateExpire()
    {
        return $this->dateExpired;
    }

    /**
     *
     * @param unknown_type $dateExpire            
     */
    public function setDateExpire($dateExpire)
    {
        $this->dateExpired = $dateExpire;
        return $this;
    }

    public function getFullShortUrl()
    {
        if (strlen($this->host) === 0) {
            return $_SERVER['HTTP_REFERER'] . "/" . $this->getShortName();
        } else {
            return $this->host . "/" . $this->getShortName();
        }
    }

    public function getDateExpiredFormatted()
    {
        $date = new DateTime();
        $date->setTimestamp($this->getDateExpire());
        return $date->format('Y-m-d H:i:s');
    }

    public function getDateCreatedFormatted()
    {
        $date = new DateTime();
        $date->setTimestamp($this->getDateCreated());
        return $date->format('Y-m-d H:i:s');
    }
}