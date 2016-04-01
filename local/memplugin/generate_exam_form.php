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
 * Handles the logic of generating new exams. Gives a user the ability
 * to upload a PDF document and then generate a desired number of duplicate
 * exams. Also allows the user to append a number of 'emergency' blank pages. 
 *
 * @package     local
 * @subpackage  memplugin
 * @copyright   Elyse Hill ehill@ualberta.ca
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once $CFG->dirroot.'/lib/formslib.php';
require_once $CFG->dirroot.'/lib/datalib.php';
require_login();

class create_generate_exam_instance extends moodleform{
	function definition(){
		global $CFG, $DB, $USER;
		$mform = $this ->_form;
	    $attributes_heading = 'size="24"';
	    $attributes_radio_text = 'size="11"';	

		//General: Set the name of an exam and upload a PDF
		$mform->addElement('header', 'nameforyourheaderelement', get_string('genheader', 'local_memplugin'));
	    $mform->addElement('textarea', 'name', get_string('makeexam', 'local_memplugin'),'wrap="virtual" rows="1" cols="120" resize="none" style="resize:none"');
		$mform->addElement('filepicker', 'userfile', get_string('file','local_memplugin'), null, array('maxbytes' => $maxbytes, 'accepted_types' => 'application/pdf'));

		//Copy Options: How many booklets and how many blank pages.
		$mform->addElement('header', 'nameforyourheaderelement', get_string('copyheader', 'local_memplugin'));
		$mform->addElement('textarea','exam_count',get_string('examcopies', 'local_memplugin'),'size="1"');
		$mform->addElement('textarea','extra_count',get_string('emergencypgs', 'local_memplugin'),'size="1"');
		//$mform->addElement('html', '<div id="examcopies"><b>'.get_string('examcopies', 'local_memplugin').'</b> <br> <input type="number" value="0" min="0"</input> <br> <br></div>');
		//$mform->addElement('html', '<div id="emergencypgs"><b>'.get_string('emergencypgs', 'local_memplugin').'</b> <br> <input type="number" value="0" min="0"</input> <br></div>');
		$howtogenerate = get_string('howtogenerate', 'local_memplugin');


		//Generate Options: One large file or many small files
		$downarray   =  array();
		//$downarray[] =& $mform->createElement('radio','yesno', '', get_string('multicopy', 'local_memplugin'), 'false');
		$downarray[] =& $mform->createElement('radio','yesno', '', get_string('largecopy', 'local_memplugin'));
		$mform->addGroup($downarray, 'downarray', 'How would you like to download?', array(' '), false);
		$mform->closeHeaderBefore('exam_submit');
		$mform->addElement('submit', 'exam_submit', get_string('generatebutton', 'local_memplugin'));

	}
}


?>



