<?php
/**
 * File Name: DBInterface.php
 * Author: Jakob Richter
 * Date: 18.09.2015
 * Version @version
 * =================================================================
 *
 * This script is used to
 * =================================================================
 */
namespace Jarisoft\Model;

use Jarisoft\Resources\Event;

class DBManager
{

    private $config_file = "/src/config/config.php";

    private $config;

    private $connection;

    private $eventManager;

    public function __construct(\EventManagerInterface $eventManagerInterface)
    {
        $this->eventManager = $eventManagerInterface;
        $this->config_file = realpath(".") . $this->config_file;
        try {
            $this->config = parse_ini_file($this->config_file, TRUE);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public function isConnected()
    {
        $con = $this->getConnection();
        if (isset($con)) {
            return true;
        } else {
            return false;
        }
    }

    private function getConnection()
    {
        if (! isset($this->connection)) {
            try {
                $server = "mysql:dbname=" . $this->config['db']['database'] . ";host=" . $this->config['db']['host'];
                $this->connection = new \PDO($server, $this->config['db']['username'], $this->config['db']['password']);
                return $this->connection;
            } catch (\PDOException $e) {
                $event = new Event(Event::ERROR);
                $event->setEventMessage($e->getMessage());
                $this->eventManager->notifyListener($event);
            }
            
            return $this->connection;
        } 
        return $this->connection;
    }

    public function insertShortURL(\ShortURL $url)
    {
        $con = $this->getConnection();
        if (isset($con)) {
            $query = "INSERT INTO shortener (id, shortName, target, dateCreated, dateExpired) 
                VALUES (null, :shortName, :target, :dateCreated, :dateExpired)";
            $stmt = $con->prepare($query);
            $stmt->bindParam(':shortName', $url->getShortName());
            $stmt->bindParam(':target', $url->getTarget());
            $stmt->bindParam(':dateCreated', $url->getDateCreated());
            $stmt->bindParam(':dateExpired', $url->getDateExpire());
            $stmt->execute();
            $id = $con->lastInsertId();
            $url->setId($id);
            return $url;
        }
    }

    public function getSingleValue($query)
    {
        $con = $this->getConnection();
        if (isset($con)) {
            try {
            $stmt = $con->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            } catch (\PDOException $e) {
                var_dump($e);
            }
            return $result;
        } else {
            
            $event = new Event(Event::ERROR);
            $event->setEventMessage("Cannot execute SELECTION statement since there is no valid or open database connection");
            $this->eventManager->notifyListener($event);
        }
        
        return null;
    }

    /**
     * Executes a given query with given parameter and returns the number of affected rows or null if no row was affected.
     *
     * @param string $query
     *            must be of the form "SELECT | DELETE | UPDATE ... WHERE parameter1 = ? AND parameter2 = ?
     * @param array $parameter
     *            holds all parameter that are used for this query.
     * @return boolean to indicates the success of the function
     */
    public function executeStatment($query, $parameter)
    {
        $con = $this->getConnection();
        if (isset($con)) {
            $stmt = $con->prepare($query);
            
            if ($stmt->execute($parameter)) {
                $rowCount = $stmt->rowCount();
                if ($rowCount > 0) {
                    return true;
                } else {
                    $event = new Event(Event::WARNING);
                    $event->setEventMessage("Statement '$query' didn't affect any rows. Possible error in your statement.");
                    $this->eventManager->notifyListener($event);
                    return false;
                }
            } else {
                $event = new Event(Event::ERROR);
                $event->setEventMessage("Error Code: " . $stmt->errorCode() . " | " . $stmt->errorInfo());
                $this->eventManager->notifyListener($event);
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     *
     * @param unknown $query            
     * @param unknown $className            
     * @return multitype:|boolean
     */
    public function fetchAllShortURLs($query, $className)
    {
        $con = $this->getConnection();
        if (isset($con)) {
            $stmt = $con->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchObject($className);
            return $result;
        } else {
            $event = new Event(Event::ERROR);
            $event->setEventMessage("Error Code: " . $stmt->errorCode() . " | " . $stmt->errorInfo());
            $this->eventManager->notifyListener($event);
            return false;
        }
    }
}