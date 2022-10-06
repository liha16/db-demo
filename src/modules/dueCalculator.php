<?php



class DueCalculator{

    private $dueDate;    
    private $lastPeriodDate;

    public function setDueDate($lastPeriodDate) {

        if ($this->validateDate($lastPeriodDate) == true) {
            $this->lastPeriodDate = $lastPeriodDate;
            $this->dueDate = date('Y-m-d', strtotime($lastPeriodDate . ' + 280 days'));
        }
    }

    public function getDueDate() {
        return $this->dueDate;
    }

    public function getCurrentWeek(){
        $now = time(); // or your date as well
        $lastPeriodDate = strtotime($this->lastPeriodDate);
        $datediff =  $now - $lastPeriodDate;
        return round($datediff / (60 * 60 * 24) / 7);
    }

    public function getHTMLForm() {
        return "<form class='dueCalculator' method='get'>
        <label for='lastPeriod'>Select the first day of the last period:</label>
            <input type='date' name='lastPeriod' id='lastPeriod'>
            <input type='submit' value='Calculate!'>
        </form>";
    }

    private function validateDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }
}

