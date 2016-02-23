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


global $CFG, $PAGE, $DB;
 
require_once('../../config.php');

require_login();
require_capability('local/ryantest:add', context_system::instance());
require_once($CFG->dirroot.'/local/ryantest/ryan_form.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('pluginname', 'ryantest'));
$PAGE->set_heading(get_string('pluginname', 'ryantest'));
$PAGE->set_url($CFG->wwwroot.'/local/ryantest/ryan.php');
$kieran_form = new create_kieran_instance();

//echo $OUTPUT->header();
//$kieran_form->display();

/*
* This code is for loading the kieran page and displaying the contents
* and is responsible for  for redirecting and displaying the header and
* the footer
*  
*/
if ($kieran_form->is_cancelled()) {
	redirect($CFG->wwwroot.'/local/ryantest/view.php');
} elseif ($data = $kieran_form->get_data()) {
	$check = $data->test1;
	redirect($CFG->wwwroot.'/local/ryantest/view.php');//'/local/rubricrepo_kboyle/kieran.php?id='.$data->test1);
} else {
	echo $OUTPUT->header();
	$kieran_form->display();
	echo $OUTPUT->footer();
}
?>
