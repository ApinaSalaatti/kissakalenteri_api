<?php namespace App;

class Counter {
    private $db;

    public function __construct($db, $imageDir) {
        $this->db = $db;
    }

    public function newVisitor() {
        $year = date("Y");
        $d = $this->db->query("SELECT visitors FROM visitors WHERE year=$year");
        $row = $image->fetch_assoc();
        if($row && isset($row["visitors"])) {
            // Got it
            $newCount = intval($row["visitors"]) + 1;
            $this->db->query("UPDATE visitors SET visitors = $newCount WHERE year=$year");
        }
        else {
            $this->db->query("INSERT INTO visitors (year, visitors) values($year, 1)");
        }
    }

    public function getVisitors() {
        $year = date("Y");
        $d = $this->db->query("SELECT visitors FROM visitors");
        $retval = [];
        while ($row = $result->fetch_array()) {
            $retval[$row["year"]] = $row["visitors"];
        }

        return $retval;
    }
}