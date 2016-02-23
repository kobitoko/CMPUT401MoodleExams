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
 * Initial page for the plug-in
 *
 * @package     local
 * @subpackage  demo_plug-in
 * @copyright   Eric Cheng ec10@ualberta.ca
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

global $PAGE, $CFG, $DB;
require_once('../../config.php');
require_once($CFG->dirroot.'/local/demo/sample_form.php');

require_login();
require_capability('local/demo:add', context_system::instance());
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('pluginname', 'local_demo'));
$PAGE->set_heading(get_string('pluginname', 'local_demo'));
$PAGE->set_url($CFG->wwwroot.'/local/demo/view.php');

$form = new sample_form();

//Tell the page what to do for the submit button. Set up if statements. 
//Always check for actions first before displaying anything!!
//This way when action taken, we can redirect before displaying page.
if ($_POST['food_submit']) {
	$data = $form->get_data();
	// put custom put or post methods or variables into our html header, put ? in the end at the page.
	// ? variableName, and then get the id of the form element to get their value.
	redirect($CFG->wwwroot.'/local/demo/test.php?food_choice='.$data->food_select);
	//multiple variables you concatenate with & e.g. food_choice=2&test=3 
	//prevent PUT injection: something like the die[moodle]or else 
	// if u try access that page directly without coming from moodle it will not let it.
	
} else {
	echo $OUTPUT->header();
	$form->display();
	echo $OUTPUT->footer();
}

?>
