<?php 

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This page is for the partial search of students, who you then can assign a booklet-id.
 *
 * @package     local
 * @subpackage  memplugin
 * @copyright   
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

global $PAGE, $CFG, $DB;
require_once('../../config.php');

require_login();
require_capability('local/memplugin:add', context_system::instance());
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('pluginname', 'local_memplugin'));
$PAGE->set_heading(get_string('pluginname', 'local_memplugin'));
$PAGE->set_url($CFG->wwwroot.'/local/memplugin/search.php');

$bid = intval($_GET['booklet_id']);
$page = intval($_GET['page']);

$datstudents = array();
/** Retrieve Teacher's courses.
Note: enrolled, with no role. this is too generic, later make this so it retrieves only where user has teacher+ privilige.*/
$enrolled = enrol_get_users_courses($USER->id, true,'*', 'visible DESC, sortorder ASC');

/** Retrieves each student enrolled in the list of all courses the teacher is enrolled in. */
foreach($enrolled as $course) {
	//https://docs.moodle.org/dev/Enrolment_API
	//get_enrolled_users(context $context, $withcapability = '', $groupid = 0, $userfields = 'u.*', $orderby = '', $limitfrom = 0, $limitnum = 0)
	//id is also key. so array_merge overrides is ok.
	$tmp = get_enrolled_users(context_course::instance($course->id),'', 0, 'u.*');
	$datstudents = array_merge($datstudents, $tmp);
}
// todo get booklet id as well, and parse it into search_add_to_db
$searchable_students = '<script>var data = '.json_encode($datstudents).';
						var bid = '.$bid.';
						var page = '.$page.';
						window.onload = init(data, bid, page);
						</script>';

display_search($searchable_students);

$img = $DB->get_record_sql('SELECT pdf_file_id, pdf_file
							FROM {mem_booklet_data}, {mem_pdf_files} 
							WHERE {mem_booklet_data}.booklet_id=?
							AND {mem_pdf_files}.page_num=0
							AND {mem_pdf_files}.booklet_id={mem_booklet_data}.booklet_id', array($bid));

/**
Display search method prints everything on screen to actually display everything, and links the Javascript file.
*/

//TODO: page 0 is the one that has the name and id on it.
// also show a page0 of current booklet reeceived in a <img>

function display_search($js) {
	global $OUTPUT, $img, $bid;
	echo $OUTPUT->header();
	echo '<link rel="stylesheet" type="text/css" href="css/marking_canvas.css">
			<script src="js/search.js" type="text/javascript"></script>';
	echo '<table class="search"><tr><td>
			<div class="img">
			<img alt="Page 0 of Booklet ID ='.$bid.'" src="data:image/png;base64,'.base64_encode($img->pdf_file).'"/>
			</div>
			</td><td>
				Find student: <input id="inputid" name="selectname" onchange="newSearch()"></input>
				<button type="button" id="search_btn_id" onclick="newSearch()">Search</button>
				<div id="aside"></div>
			</td></tr></table>';

	echo $js;
	echo $OUTPUT->footer();
}
?>
