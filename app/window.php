<?php namespace App;
	
class Window {
    private $db;

    public function __construct($db, $imageDir) {
        $this->db = $db;
        $this->dir = $imageDir;
    }
    
    private function validDate($year, $day) {
        $currY = intval(date("Y"));
        $currM = intval(date("m"));
        $currD = intval(date("d"));
        
        // Previous years' stuff is all open
        if($year < $currY) {
            return true;
        }
        else if($year == $currY) {
            // Check that it's December already. :)
            if($currM == 12) {
                // Check that the day is not a FUTURE DAY!
                if($day <= $currD) {
                    return true; // YAY!
                }
            }
        }
        
        return false;
    }
    
    private function getImageRecord($year, $day) {
        $image = $this->db->query("SELECT * FROM window_images WHERE year=$year AND day=$day");
        $row = $image->fetch_assoc();
        return $row;
    }

    private function showData($filename) {
        if(!$filename) {
            throw new HttpErrorCodeException(404);
        }
        else {
            $filename = $this->dir . $filename;
            if(file_exists($filename)) {
                $imginfo = getimagesize($filename);
                $cType = $imginfo['mime'];
                header("Content-type: $cType");
                readfile($filename);
            }
            else {
                throw new HttpErrorCodeException(404);
            }
        }
    }
    
    public function get($params) {
        $year = intval($params['year']);
        $day = intval($params['day']);

        if($this->validDate($year, $day)) {
            $image = $this->getImageRecord($year, $day);
            $filename = $image["filename"];
            $this->showData($filename);
        }
        else {
            throw new HttpErrorCodeException(403);
        }
    }
    
    public function thumb($params) {
        $year = intval($params['year']);
        $day = intval($params['day']);
        
        if($this->validDate($year, $day)) {
            $image = $this->getImageRecord($year, $day);
            $filename = $image["thumb_filename"];
            $this->showData($filename);
        }
        else {
            throw new HttpErrorCodeException(403);
        }
    }
    
    public function catOfTheDay() {
        $currY = intval(date("Y"));
        $currM = intval(date("m"));
        $currD = intval(date("d"));
        
        if($currM == 12 && $currD < 25) {
            $params = array(
                'year' => $currY,
                'day' => $currD
            );
            $this->get($params);
        }
        else {
            throw new HttpErrorCodeException(404);
        }
    }
}