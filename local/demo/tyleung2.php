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
 * Handles the logic for the kieran template
 *
 * @package     local
 * @subpackage  feedback_kboyle
 * @copyright   Kieran Boyle kboyle@ualberta.ca
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
/**
 * From http://stackoverflow.com/questions/24617350/how-to-create-a-custom-form-in-moodle
 * Credit to: Hipjea
 * Retrieved: Oct. 15, 2016
 */


global $PAGE, $CFG, $DB;
require_once('../../config.php');
require_once($CFG->dirroot.'//local/demo/sample_form.php');

require_login();
require_capability('local/demo:add', context_system::instance());
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('pluginname', 'local_demo'));
$PAGE->set_heading(get_string('pluginname', 'local_demo'));
$PAGE->set_url($CFG->wwwroot.'/local/demo/view.php');


if ($_GET['food']) {
	echo $OUTPUT->header();
	echo $_GET['food'];
	echo $OUTPUT->footer();
} else {
	echo $OUTPUT->header();
	echo $OUTPUT->footer();
}

?>
