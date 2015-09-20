<?php
use Jarisoft\Model\DBManager;

class URLShortener
{

    
    private $dbManager;

    private $config;
    
    private $eventManager;

    public function __construct(EventManagerInterface $eventManagerInterface, $configArray)
    {
        $this->eventManager = $eventManagerInterface;
        $this->config = $configArray;
        $this->dbManager = new DBManager($this->eventManager, $configArray);
    }

    /**
     * Generates a shortened string for a given $target url and stores it inside the database.
     *
     * The generated string (here $short) follows several rules:
     * 
     * - if strlen($target) > 4 then strlen($target) > strlen($short) else strlen($short) = 4
     * 
     * - $target !== $short
     * 
     * - length of $short is 4
     * 
     * - $short contains only numbers and capitalised consonants.
     *
     * The function assumes that the $target url exists. Aim of the function is
     * to generate a string that is similar to the target url. 
     * The return value is of type ShortURL which holds
     * several information about the generated URL.
     *
     * @param string $url
     *            the target
     * @return ShortURL
     */
    public function generateShortURL($target)
    {
        $newTarget = preg_replace('/[aeiou,.\/\\\-_&=:\s]+/i', '', $target);
        $newTarget = strtoupper($newTarget);
        $newTarget = str_shuffle($newTarget);
        
        /*
         * If string has more than 4 character pick the first 4 character.
         * else if string has less than 4 character fill missing character.
         */
        
        if (strlen($newTarget) > 4) {
            $newTarget = substr($newTarget, 0, 4);
            
        } else if (strlen($newTarget) < 4) {
            $newTarget = $newTarget . $this->generateRandomString(4-strlen($newTarget));
        }
        
        if ($this->exists($newTarget)) {
            $newTarget = $this->randomizer($newTarget);
        }
        
        $short = new ShortURL($this->config['shortener']['targetURL']);
        $short->setTarget($target);
        $short->setShortName($newTarget);
        
        $short->setDateCreated(time());
        $short->setDateExpire($short->getDateCreated() + (4*24*60*60));
        
        
        $this->dbManager->insertShortURL($short);
        return $short;
    }

    /**
     * @param unknown $word
     * @return string
     */
    private function randomizer($word) {
        $count = 0;
        $newTarget = $word;
        do {
            $newTarget = str_shuffle($newTarget);
            $count++;
        } while ($this->exists($newTarget) && $count < 4);
        if ($count === 4 && $this->exists($newTarget)) {
            // if we didn't had any luck we run the whole thing with a new generated word
            return $this->randomizer($this->generateRandomString(4));
        } else {
            return $newTarget;
        }
    }
    
    
    private function exists($string) {
       $result = $this->dbManager->getSingleValue("SELECT id FROM shortener WHERE shortName='$string'");
        if ($result != null) {
            return true;
        } else {
            return false;
        }
    }
    
    
    private function generateRandomString($length) {
        $exceptedChars = "BCDFGHJKLMNPQRSTVWXYZ0123456789";
        $returnString = "";
        for ($i = 0; $i < $length; $i++) {
            $idx = rand(0, strlen($exceptedChars) - 1);
            $returnString .= $exceptedChars[$idx];
        }
        return $returnString;
    }
    
    public function getTargetURL($shortURL)
    {   
        $sql = "SELECT target FROM shortener WHERE shortName='$shortURL' AND dateExpired > " . time() . " LIMIT 1";
        $target = $this->dbManager->getSingleValue($sql);
        return $target;
    }
    
    public function getTargetURLObject($shortURL) {
        $sql = "SELECT * FROM shortener WHERE shortName='$shortURL' AND dateExpired > " . time() . " LIMIT 1";
        $target = $this->dbManager->fetchAllShortURLs($sql, "ShortURL");
        return $target;
    }
    
    public function getShortenURL($target) {
        $sql = "SELECT * FROM shortener WHERE target='$target' AND dateExpired > " . time() . " LIMIT 1";
        $shortURLs = $this->dbManager->fetchAllShortURLs($sql, "ShortURL");
        return $shortURLs;
    }
    
    public function targetURLExists($target) {
        $result = $this->dbManager->getSingleValue("SELECT id FROM shortener WHERE target='$target'");
        if ($result != null) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllShortURLs()
    {
        $list = $this->dbManager->fetchAllShortURLs("SELECT * FROM shortener", "ShortURL");
        return $list;
    }
    
    public function getAllActiveShortURLs() {
        $list = $this->dbManager->fetchAllShortURLs("SELECT * FROM shortener WHERE dateExpired > " . time(), "ShortURL");
        return $list;
    }
    
    public function countActiveShortURLs() {
        $count = $this->dbManager->getSingleValue("SELECT COUNT(*) FROM shortener WHERE dateExpired > " . time());
        return $count;
    }
}