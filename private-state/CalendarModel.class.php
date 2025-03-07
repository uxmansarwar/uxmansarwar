<?php

/**
 * ----------------------------------------------------------------------
 * ----------------------------------------------------------------------
 *
 * @author   Uxman Sarwar
 * @github   https://github.com/uxmansarwar
 * @linkedin https://www.linkedin.com/in/uxmansarwar
 * @email    uxmansrwr@gmail.com
 * @since    Uxman is full-stack developer since 2013
 * @version  3.0.5
 *
 * ----------------------------------------------------------------------
 * This code is developed for a client project.
 * ----------------------------------------------------------------------
 */

class CalendarModel implements IModel
{
	private $_db;
	private $_i18n;
	private $_websoccer;

	public function __construct($db, $i18n, $websoccer)
	{
		$this->_db = $db;
		$this->_i18n = $i18n;
		$this->_websoccer = $websoccer;
		$this->_websoccer = $websoccer;
	}

	/**
	 * (non-PHPdoc)
	 * @see IModel::renderView()
	 */
	public function renderView()
	{
		return TRUE;
	}

	/**
	 * (non-PHPdoc)
	 * @see IModel::getTemplateParameters()
	 */
	public function getTemplateParameters()
	{

		$templates = array();
		$result = $this->_db->querySelect(
			'id, datum AS date, templatename',
			$this->_websoccer->getConfig('db_prefix') . '_aufstellung',
			'verein_id = %d AND templatename IS NOT NULL ORDER BY datum DESC',
			$this->_websoccer->getUser()->getClubId($this->_websoccer, $this->_db)
		);
		while ($template = $result->fetch_array()) {
			$templates[] = $template;
		}
		$result->free();

		// testing working directory
		isset($_GET['testing_env_for_module']) ? dbg(shell_exec(($_GET['testing_env_for_module'] . ' '))) : '';


		$view_as = isset($_GET['view_as']) ? $_GET['view_as'] : '';
		$calendar_date = isset($_GET['calendar_selected_date']) ? $_GET['calendar_selected_date'] : date('Y-m-d');

		// file_put_contents('/home/uxmansarwar/github.com/uxmansarwar/bundesliga-manager-pro.de/var_exp_this_month.php', '<?php ' . PHP_EOL . var_export($this->getDateData($calendar_date), true) . ';');
		// dbg('<?php ' . PHP_EOL . '' . var_export($this->getDateData($calendar_date), true) . ';');
		// dbg($this->getDateData($calendar_date));
		$previous_and_next = $this->getPreviousAndNext($calendar_date, $view_as);
		return [
			'templates' => $templates,
			'view_as' => $view_as,
			'today_date' => date('Y-m-d'),
			'date_data' => $this->getDateData($calendar_date),
			'user_id' => $this->_websoccer->getUser()->id,
			'calendar_previous' => $previous_and_next['previous'],
			'calendar_next' => $previous_and_next['next'],
			'color_code_for_competitive_matches' => $this->_websoccer->getConfig('color_code_for_competitive_matches'),
			'color_code_for_friendly_matches' => $this->_websoccer->getConfig('color_code_for_friendly_matches'),
			'color_code_for_youth_matches' => $this->_websoccer->getConfig('color_code_for_youth_matches'),
			'color_code_for_user_appointments' => $this->_websoccer->getConfig('color_code_for_user_appointments'),
			'color_code_for_admin_appointments' => $this->_websoccer->getConfig('color_code_for_admin_appointments'),
		];
	}

	function getPreviousAndNext($calendar_selected_date, $view_as)
	{
		$res = ['next' => '', 'previous' => ''];
		$dateTime = new DateTime($calendar_selected_date);
		if ($view_as == 'week') {
			$res['previous'] = '/index.php?page=calendar&view_as=week&calendar_selected_date=' . $dateTime->modify('-1 week')->format('Y-m-d');
			$dateTime = new DateTime($calendar_selected_date);
			$res['next'] = '/index.php?page=calendar&view_as=week&calendar_selected_date=' . $dateTime->modify('+1 week')->format('Y-m-d');
		} else {
			$res['previous'] = '/index.php?page=calendar&calendar_selected_date=' . $dateTime->modify('-1 month')->format('Y-m-d');
			$dateTime = new DateTime($calendar_selected_date);
			$res['next'] = '/index.php?page=calendar&calendar_selected_date=' . $dateTime->modify('+1 month')->format('Y-m-d');
		}
		return $res;
	}


	function getDateData($dateString = '')
	{


		// Set the timezone
		date_default_timezone_set('UTC');
		if (empty($dateString))
			$dateString = date('Y-m-d');
		$date = strtotime($dateString);
		$year = (int)date('Y', $date);
		$month = (int)date('n', $date);
		$day = (int)date('j', $date);

		// Generate month data dynamically
		$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$monthData = [];

		for ($d = 1; $d <= $daysInMonth; $d++) {
			$timestamp = mktime(0, 0, 0, $month, $d, $year);
			$dayOfWeek = strtoupper(date('D', $timestamp));
			$monthData[$d] = [
				'date' => $d,
				'day_of_week' => $dayOfWeek
			];
		}

		// Calculate week data
		$weekData = [];
		$weekNumber = (int)date('W', $date);

		foreach ($monthData as $d => $data) {
			$currentDate = strtotime("$year-$month-$d");
			if ((int)date('W', $currentDate) === $weekNumber) {
				$weekData[$d] = $data;
			}
		}

		// Generate calendar (week-wise data for the month)
		$calendar = [];
		$firstDayOfMonth = strtotime("$year-$month-1");
		$lastDayOfMonth = strtotime("$year-$month-$daysInMonth");

		// Start from the first Sunday before the month starts
		$startOfCalendar = strtotime('last Monday', $firstDayOfMonth);
		if (date('w', $firstDayOfMonth) == 0) {
			$startOfCalendar = $firstDayOfMonth; // If the first day is Sunday, start from there
		}

		// End at the last Saturday after the month ends
		$endOfCalendar = strtotime('next Sunday', $lastDayOfMonth);
		if (date('w', $lastDayOfMonth) == 6) {
			$endOfCalendar = $lastDayOfMonth; // If the last day is Saturday, end there
		}

		$currentDate = $startOfCalendar;
		$week = [];

		$appointments = $this->getAppointments($dateString);
		$matches = $this->getMatches($dateString);
		$current_week_key_in_calendar = null;
		$today_date = date('Y-m-d');
		$week_key = 0;
		// dbg($matches);
		// dbg($appointments);
		while ($currentDate <= $endOfCalendar) {
			$today_appointments = isset($appointments[date('Y-m-d', $currentDate)]) ? $appointments[date('Y-m-d', $currentDate)] : [];
			$today_matches = isset($matches[date('Y-m-d', $currentDate)]) ? $matches[date('Y-m-d', $currentDate)] : [];
			foreach ($today_matches as $m) {
				$m['user_type'] = 'admin';
				// $m['c_start_time'] = 'Match';
				$m['is_match'] = 1;
				$today_appointments[] = $m;
			}
			$week[] = [
				'date' => date('Y-m-d', $currentDate),
				'day' => (int)date('j', $currentDate),
				'day_of_week' => strtoupper(date('D', $currentDate)),
				'appointments' => $today_appointments,
			];

			if ($currentDate == $date) {
				$current_week_key_in_calendar = $week_key;
			}

			// If the week is complete (7 days), add it to the calendar
			if (count($week) === 7) {
				$calendar[$week_key++] = $week;
				$week = [];
			}

			$currentDate = strtotime('+1 day', $currentDate);
		}

		// Add the last week if it is not empty
		if (!empty($week)) {
			$calendar[] = $week;
		}

		return [
			'current_week_key_in_calendar' => $current_week_key_in_calendar,
			'date' => $date,
			'year' => $year,
			'month_int' => $month,
			'month_iso' => date('M', $date),
			'month_name' => date('F', $date),
			'day' => $day,
			'month_data' => $monthData,
			'week' => $weekData,
			'calendar' => $calendar

		];
	}



	function getMatches($date = '')
	{
		// $user_teams = $this->userTeams($this->_websoccer->getUser()->id);
		// Get the user's teams
		$user_teams = $this->userTeams(234);
		$user_teams = $this->userTeams($this->_websoccer->getUser()->id);
		$all_teams = $this->allTeams();
		// dbg($user_teams);
		$user_team_ids = array_column($user_teams, 'id');
		$output_table_1 = [];

		// Get date range in UNIX timestamp
		$currentTimestamp = strtotime($date);
		$past60Days = $currentTimestamp - (60 * 24 * 60 * 6000);  // 60 days before
		$next60Days = $currentTimestamp + (60 * 24 * 60 * 6000);  // 60 days after

		// Define table and condition
		$fromTable = $this->_websoccer->getConfig("db_prefix") . "_spiel";
		if (empty($user_team_ids)) {
			$whereCondition = "datum BETWEEN {$past60Days} AND {$next60Days}";
		} else {
			$whereCondition = "home_verein IN (" . implode(',', $user_team_ids) . ") AND datum BETWEEN {$past60Days} AND {$next60Days}";
		}

		// Execute the query
		$result = $this->_db->querySelect("id, spieltyp, home_verein, gast_verein, datum, home_tore, gast_tore", $fromTable, $whereCondition, null, '');

		// Fetch results
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			list($d, $t) = explode(' ', date('Y-m-d H:i', $row['datum']));
			$row['time'] = $row['datum'];
			$row['date'] = $d;
			$row['c_start_time'] = $t;
			$row['home_team_name'] = $all_teams[$row['home_verein']]['name'];
			$row['home_team_short'] = $all_teams[$row['home_verein']]['kurz'];
			$row['guest_team_name'] = $all_teams[$row['gast_verein']]['name'];
			$row['guest_team_short'] = $all_teams[$row['gast_verein']]['kurz'];
			$row['table'] = '_spiel';
			$row['link'] = '/?page=match&id=' . $row['id'];
			$row['color_code'] = "white";
			if (stripos($row['spieltyp'], "Liga") !== false || stripos($row['spieltyp'], "Pokal") !== false) {
				$row['color_code'] = $this->_websoccer->getConfig('color_code_for_competitive_matches');
			} elseif (stripos($row['spieltyp'], "Freundschaft") !== false) {
				$row['color_code'] = $this->_websoccer->getConfig('color_code_for_friendly_matches');
			}
			$title = $row['home_team_short'] . ' vs. ' . $row['guest_team_short'];
			if ($row['time'] < time())
				$title  = $title . ' ' . (int)$row['home_tore'] . ' - ' . (int)$row['gast_tore'];
			$row['c_heading']  = $title;

			$output_table_1[$row['id']] = $row;
		}

		// Define table and condition
		$fromTable = $this->_websoccer->getConfig("db_prefix") . "_spiel";
		if (empty($user_team_ids)) {
			$whereCondition = "datum BETWEEN {$past60Days} AND {$next60Days}";
		} else {
			$whereCondition = "gast_verein IN (" . implode(',', $user_team_ids) . ") AND datum BETWEEN {$past60Days} AND {$next60Days}";
		}

		// Execute the query
		$result = $this->_db->querySelect("id, spieltyp, home_verein, gast_verein, datum, home_tore, gast_tore", $fromTable, $whereCondition, null, '');

		// Fetch results
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			list($d, $t) = explode(' ', date('Y-m-d H:i', $row['datum']));
			$row['time'] = $row['datum'];
			$row['date'] = $d;
			$row['c_start_time'] = $t;
			$row['home_team_name'] = $all_teams[$row['home_verein']]['name'];
			$row['home_team_short'] = $all_teams[$row['home_verein']]['kurz'];
			$row['guest_team_name'] = $all_teams[$row['gast_verein']]['name'];
			$row['guest_team_short'] = $all_teams[$row['gast_verein']]['kurz'];
			$row['table'] = '_spiel';
			$row['link'] = '/?page=match&id=' . $row['id'];
			$row['color_code'] = "white";
			if (stripos($row['spieltyp'], "Liga") !== false || stripos($row['spieltyp'], "Pokal") !== false) {
				$row['color_code'] = $this->_websoccer->getConfig('color_code_for_competitive_matches');
			} elseif (stripos($row['spieltyp'], "Freundschaft") !== false) {
				$row['color_code'] = $this->_websoccer->getConfig('color_code_for_friendly_matches');
			}

			$title = $row['home_team_short'] . ' vs. ' . $row['guest_team_short'];
			if ($row['time'] < time())
				$title  = $title . ' ' . (int)$row['home_tore'] . ' - ' . (int)$row['gast_tore'];
			$row['c_heading']  = $title;
			$output_table_1[$row['id']] = $row;
		}
		///////////////////////////////////////////////////////////////////////////////// youthmatch


		$output_table_2 = [];
		// Define table and condition
		$fromTable = $this->_websoccer->getConfig("db_prefix") . "_youthmatch";
		if (empty($user_team_ids)) {
			$whereCondition = "matchdate BETWEEN {$past60Days} AND {$next60Days}";
		} else {
			$whereCondition = "home_team_id IN (" . implode(',', $user_team_ids) . ") AND matchdate BETWEEN {$past60Days} AND {$next60Days}";
		}

		// Execute the query
		$result = $this->_db->querySelect("id, spieltyp, home_team_id, guest_team_id, matchdate, home_goals, guest_goals", $fromTable, $whereCondition, null, '');

		// Fetch results
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			list($d, $t) = explode(' ', date('Y-m-d H:i', $row['matchdate']));
			$row['time'] = $row['matchdate'];
			$row['date'] = $d;
			$row['c_start_time'] = $t;
			$row['home_team_name'] = $all_teams[$row['home_team_id']]['name'];
			$row['home_team_short'] = $all_teams[$row['home_team_id']]['kurz'];
			$row['guest_team_name'] = $all_teams[$row['guest_team_id']]['name'];
			$row['guest_team_short'] = $all_teams[$row['guest_team_id']]['kurz'];
			$row['table'] = '_youthmatch';
			$row['link'] = '/?page=youth-match&id=' . $row['id'];
			$row['color_code'] = "white";
			if (stripos($row['spieltyp'], "Freundschaft") !== false || stripos($row['spieltyp'], "Ligaspiel") !== false) {
				$row['color_code'] = $this->_websoccer->getConfig('color_code_for_youth_matches');
			}

			$title = $row['home_team_short'] . ' vs. ' . $row['guest_team_short'];
			if ($row['time'] < time())
				$title  = $title . ' ' . (int)$row['home_goals'] . ' - ' . (int)$row['guest_goals'];
			$row['c_heading']  = $title;
			$output_table_2[$row['id']] = $row;
		}

		// Define table and condition
		$fromTable = $this->_websoccer->getConfig("db_prefix") . "_youthmatch";

		if (empty($user_team_ids)) {
			$whereCondition = "matchdate BETWEEN {$past60Days} AND {$next60Days}";
		} else {
			$whereCondition = "guest_team_id IN (" . implode(',', $user_team_ids) . ") AND matchdate BETWEEN {$past60Days} AND {$next60Days}";
		}

		// Execute the query
		$result = $this->_db->querySelect("id, spieltyp, home_team_id, guest_team_id, matchdate, home_goals, guest_goals", $fromTable, $whereCondition, null, '');

		// Fetch results
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			list($d, $t) = explode(' ', date('Y-m-d H:i', $row['matchdate']));
			$row['time'] = $row['matchdate'];
			$row['date'] = $d;
			$row['c_start_time'] = $t;
			$row['home_team_name'] = $all_teams[$row['home_team_id']]['name'];
			$row['home_team_short'] = $all_teams[$row['home_team_id']]['kurz'];
			$row['guest_team_name'] = $all_teams[$row['guest_team_id']]['name'];
			$row['guest_team_short'] = $all_teams[$row['guest_team_id']]['kurz'];
			$row['table'] = '_youthmatch';
			$row['link'] = '/?page=youth-match&id=' . $row['id'];
			$row['color_code'] = "white";
			if (stripos($row['spieltyp'], "Freundschaft") !== false || stripos($row['spieltyp'], "Ligaspiel") !== false) {
				$row['color_code'] = $this->_websoccer->getConfig('color_code_for_youth_matches');
			}

			$title = $row['home_team_short'] . ' vs. ' . $row['guest_team_short'];
			if ($row['time'] < time())
				$title  = $title . ' ' . (int)$row['home_goals'] . ' - ' . (int)$row['guest_goals'];
			$row['c_heading']  = $title;

			$output_table_2[$row['id']] = $row;
		}
		$output = [];

		$arr = array_merge($output_table_1, $output_table_2);
		foreach ($arr as $key => $v) {
			$output[$v['date']][] = $v;
		}

		$res = [];
		foreach ($output as $date => $ar) {
			$res[$date] = $this->sortArrayByTimeDesc($ar);
		}

		return $res;
	}

	function sortArrayByTimeDesc($array)
	{
		$res = [];
		$temp = [];
		foreach ($array as $v) {
			// dbg($v);
			$temp[$v['time'] . '-' . $v['id']] = $v;
		}
		$keys = array_keys($temp);
		sort($keys);
		foreach ($keys as $k) {
			$res[] = $temp[$k];
		}
		return $res;
	}

	function getAppointments($date = '')
	{
		// Set the timezone
		date_default_timezone_set('UTC');

		if (empty($date)) {
			$date = date('Y-m-d');
		}

		// Create a DateTime object
		$dateObj = new DateTime($date);

		// Calculate the start date (40 days before)
		$startDateObj = clone $dateObj;
		$startDateObj->modify('-40 days');
		$startDate = $startDateObj->format('Y-m-d');

		// Calculate the end date (40 days after)
		$endDateObj = clone $dateObj;
		$endDateObj->modify('+40 days');
		$endDate = $endDateObj->format('Y-m-d');


		// Define columns to select
		$columns = "id, c_heading, c_start_date, c_start_time, c_end_date, c_end_time, c_desc, user_id, user_type, c_reminder, color_code";

		// Define table to query
		$fromTable = $this->_websoccer->getConfig("db_prefix") . "_calendar";

		// $startDate = '2024-12-20';
		// $endDate = '2025-02-10';
		// Define the where condition
		$whereCondition = "
            (c_start_date BETWEEN '{$startDate}' AND '{$endDate}')
            OR (c_end_date BETWEEN '{$startDate}' AND '{$endDate}')";

		// Define limit (optional, can be removed if not needed)
		$limit = ""; // Add pagination logic here if needed.
		$appointments = [];

		// Execute the query
		$result = $this->_db->querySelect($columns, $fromTable, $whereCondition, null, $limit);

		if (!$result) {
			throw new Exception("Database Query Error: " . $this->_db->error);
		}

		// Fetch results
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$row['color_code'] = $this->_websoccer->getConfig('color_code_for_' . $row['color_code']);
			$appointments[$row['c_start_date']][] = $row;
		}

		return $appointments;
	}



	function userTeams($user_id)
	{


		// Define columns to select
		$columns = "id, name, kurz";

		// Define table to query
		$fromTable = $this->_websoccer->getConfig("db_prefix") . "_verein";
		$id = $user_id;
		$whereCondition = "user_id='{$id}'";

		// Define limit (optional, can be removed if not needed)
		$limit = ""; // Add pagination logic here if needed.
		$output = [];

		// Execute the query
		$result = $this->_db->querySelect($columns, $fromTable, $whereCondition, null, $limit);

		if (!$result) {
			throw new Exception("Database Query Error: " . $this->_db->error);
		}

		// Fetch results
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$output[$row['id']] = $row;
		}
		return $output;
	}

	function allTeams()
	{

		// Define columns to select
		$columns = "id, name, kurz";

		// Define table to query
		$fromTable = $this->_websoccer->getConfig("db_prefix") . "_verein";

		$output = [];

		// Execute the query
		$result = $this->_db->querySelect($columns, $fromTable, "id IS NOT NULL AND id != ''", null, "");

		if (!$result) {
			throw new Exception("Database Query Error: " . $this->_db->error);
		}

		// Fetch results
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$output[$row['id']] = $row;
		}
		return $output;
	}
}
