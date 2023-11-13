<?php
class Track {
    public $pdo = null;
    public $stmt = null;
    public $error = "";

    public function __construct() {
        $dbHost = "localhost";
        $dbName = "BUS SYSTEM";
        $dbCharset = "utf8";
        $dbUser = "root"; 
        $dbPassword = ""; 

        define('DB_HOST', $dbHost);
        define('DB_NAME', $dbName);
        define('DB_User', $dbUser);
        define('DB_Password', $dbPassword);
        define('DB_CHARSET', $dbCharset);

        try {
            $this->pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
                DB_User,
                DB_Password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    public function __destruct() {
        if ($this->stmt !== null) {
            $this->stmt = null;
        }
        if ($this->pdo !== null) {
            $this->pdo = null;
        }
    }

    public function query($sql, $data = null) {
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute($data);
    }

    public function update($id, $lng, $lat) {
        $this->query(
            "REPLACE INTO `gps_track` (`rider_id`, `track_time`, `track_lng`, `track_lat`) VALUES (?,?,?,?)",
            [$id, date("Y-m-d H:i:s"), $lng, $lat]
        );
        return true;
    }

    function get($id = null) {
        $sql = "SELECT * FROM gps_track" . ($id == null ? "" : " WHERE rider_id = ?");
        $data = $id == null ? null : [$id];
        $this->query($sql, $data);
        return $this->stmt->fetchAll();
    }
}

$_track = new Track();

?>


