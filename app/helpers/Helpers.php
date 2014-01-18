<?php

use Carbon\Carbon;

class Helpers {

	public static function dateEu( $date ){

		$dateExplode = explode('-',$date);

		return $dateExplode[2].'/'. $dateExplode[1].'/'.$dateExplode[0];
	}
	public static function dateNaForm( $date ){

		$dateExplode = explode('-',$date);

		return $dateExplode[2].'-'. $dateExplode[1].'-'.$dateExplode[0];
	}
	public static function createCarbonDate( $date ){

		$dateExplode = explode('-',$date);

		return Carbon::createFromDate($dateExplode[0], $dateExplode[1], $dateExplode[2]);
		
	}
	public static function humanDay( $date ){

		switch ($date) {
			case 0:
			return "Dimanche";
			break;
			case 1:
			return "Lundi";
			break;
			case 2:
			return "Mardi";
			break;
			case 3:
			return "Mercredi";
			break;
			case 4:
			return "Jeudi";
			break;
			case 5:
			return "Vendredi";
			break;
			case 6:
			return "Samedi";
			break;

		}
	}
	public static function build_calendar($month,$year,$dateArray) {
		$user = unserialize(Session::get('user'));
		$sceances = Prof::getSceanceAndCours($user->id);
		$today_date = date("d");
		$today_date = ltrim($today_date, '0');
     // Create array containing abbreviations of days of week.

		$daysOfWeek = array('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche');

     // What is the first day of the month in question?
		$firstDayOfMonth = mktime(0,0,0,$month,1,$year);

     // How many days does this month contain?
		$numberDays = date('t',$firstDayOfMonth);

     // Retrieve some information about the first day of the
     // month in question.
		$dateComponents = getdate($firstDayOfMonth);

     // What is the name of the month in question?
		$monthName = $dateComponents['month'];
		switch ($monthName) {
			case "January":
			$monthName =  "Janvier";
			break;
			case "February":
			$monthName =  "Février";
			break;
			case "March":
			$monthName =  "Mars";
			break;
			case "April":
			$monthName =  "Avril";
			break;
			case "May":
			$monthName =  "Mai";
			break;
			case "June":
			$monthName =  "Juin";
			break;
			case "July":
			$monthName =  "Juillet";
			break;
			case "August":
			$monthName =  "Août";
			break;
			case "September":
			$monthName =  "Septembre";
			break;
			case "October":
			$monthName =  "Octobre";
			break;
			case "November":
			$monthName =  "Novembre";
			break;
			case "December":
			$monthName =  "Décembre";
			break;
		}
     // What is the index value (0-6) of the first day of the
     // month in question.
		$dayOfWeek = $dateComponents['wday']-1;
		if ($dayOfWeek < 0) {
			$dayOfWeek = 6;
		}
     // Create the table tag opener and day headers

		$calendar = "<table class='calendar'>";
		$calendar .= "<caption>$monthName $year</caption>";
		$calendar .= "<tr>";

     // Create the calendar headers

		foreach($daysOfWeek as $day) {

			$calendar .= "<th class='header'><span class='jour'>$day</span></th>";
		} 

     // Create the rest of the calendar

     // Initiate the day counter, starting with the 1st.

		$currentDay = 1;

		$calendar .= "</tr><tr>";

     // The variable $dayOfWeek is used to
     // ensure that the calendar
     // display consists of exactly 7 columns.

		if ($dayOfWeek > 0) {
			for($i = 0;$i<$dayOfWeek;$i++){ 
				$calendar .= "<td class='day old' colspan='$dayOfWeek'>&nbsp;</td>"; 
			}
		}

		$month = str_pad($month, 2, "0", STR_PAD_LEFT);

		while ($currentDay <= $numberDays) {

          // Seventh column (Saturday) reached. Start a new row.

			if ($dayOfWeek == 7) {

				$dayOfWeek = 0;
				$calendar .= "</tr><tr>";

			}

			$currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);

			$date = "$year-$month-$currentDayRel";





			if($currentDayRel == $today_date ){  
				$calendar .= "<td class='day today' ><a data-date='$date' data-day='$day' href=''><span class='number'>$currentDay</span>";
			} 

			else { 
				$calendar .="<td class='day' ><a data-date='$date' data-day='$day' href=''><span class='number'>$currentDay</span>"; 
			}

			if(isset($dateArray[mktime(0, 0, 0, $month, $currentDay, $year)])){
				$calendar.=$dateArray[mktime(0, 0, 0, $month, $currentDay, $year)];
			}
			foreach($sceances as $sceance){

				if($sceance->date === $date){
					$duree = "h-".substr($sceance->duree, 0, 1);

					$calendar .='<ol class="sceances">';

					$calendar .="<li class='$duree oneSceance' data-cours='$sceance->coursSlug' data-sceance='$sceance->sceancesId'>";
					$calendar .="<span>$sceance->coursNom</span>";

					$calendar .='</li>';

					$calendar .='</ol>';


				}

			}
			$calendar.="</a></td>";
          // Increment counters

			$currentDay++;
			$dayOfWeek++;

		}



     // Complete the row of the last week in month, if necessary

		if ($dayOfWeek != 7) { 

			$remainingDays = 7 - $dayOfWeek;
			$calendar .= "<td colspan='$remainingDays'>&nbsp;</td>"; 

		}

		$calendar .= "</tr>";

		$calendar .= "</table>";

		return $calendar;

	}

}