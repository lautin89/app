<?php
class Calendar {
	var $y;
	var $m;
	var $currentDayList;
	var $preMon;
	var $preYear;
	var $preDayList;
	var $nextMon;
	var $nextYear;
	var $nextDayList;

	function __construct($month = null, $year = null) {
		if (is_null($year)) {
			$this->y = date("Y");
		} else {
			$this->y = $year;
		}

		if (is_null($month)) {
			$this->m = date("n");
		} else {
			$this->m = $month;
		}
		
		$this->checkInput();
	}
	
	public function checkInput() {
		if ($this->m < 1) {
			$this->m = 12;
			$this->y = $this->y - 1;
		} elseif ($this->m > 12) {
			$this->y = $this->y + 1;
			$this->m = 1;
		}
	}
	

	function currentDayList() {
		$current_days = date("t", mktime(0, 0, 0, $this->m, 1, $this->y));
		$this->currentDayList = range(1, $current_days);
	}

	function setPreMon() {
		if ($this->m <= 1) {
			$this->preMon = 12;
			$this->preYear = $this->y - 1;
		} else {
			$this->preMon = $this->m - 1;
			$this->preYear = $this->y;
		}
	}

	function getPreMon() {
		$preDays = date("t", mktime(0, 0, 0, $this->preMon, 1, $this->preYear));
		$preFirstWeek = date("w", mktime(0, 0, 0, $this->preMon, $preDays, $this->preYear));
		if ($preFirstWeek == 6) {
			$this->preDayList = array();
		} else {
			$this->preDayList = range($preDays - $preFirstWeek, $preDays);
		}
		foreach ($this->preDayList as $key=>$day) {
			$this->preDayList[$key] = "-".$day;
		}
	}

	function setNextMon() {
		if ($this->m > 12) {
			$this->nextMon = 1;
			$this->nextYear = $this->y + 1;
		} else {
			$this->nextMon = $this->m + 1;
			$this->nextYear = $this->y;
		}
	}

	function getNextMon() {
		$nextMonWeek = date("w", mktime(0, 0, 0, $this->nextMon, 1, $this->nextYear));
		if ($nextMonWeek == 7) {
			$this->nextDayList = array();
		} else {
			$this->nextDayList = range(1, 7 - $nextMonWeek);
		}
		foreach ($this->nextDayList as $key=>$day) {
			$this->nextDayList[$key] = "-".$day;
		}
	}

	function getDays() {
		$this->setPreMon();
		$this->getPreMon();
		$this->currentDayList();
		$this->setNextMon();
		$this->getNextMon();
		return array(
			"year" => $this->y,
			"month" => $this->m,
			"dayList" => array_merge($this->preDayList, $this->currentDayList, $this->nextDayList)
		);
	}

}

