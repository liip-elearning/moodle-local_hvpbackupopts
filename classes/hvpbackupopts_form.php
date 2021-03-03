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
 * Main form for H5P Backup Options.
 *
 * @package local_hvpbackupopts
 * @copyright Liip AG <https://www.liip.ch/>
 * @author Raphael Santos <raphael.santos@liip.ch>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
require_once($CFG->libdir.'/formslib.php');

/**
 * Form to set H5P backup options.
 */
class hvpbackupopts_form extends moodleform {

    /**
     * Define the form.
     */
    public function definition() {
        global $USER, $CFG;
        $mform = $this->_form;

        // Header.

        $mform->addElement('html', '<p>'.get_string('pluginname_help', 'local_hvpbackupopts').'</p>');

        $backuphvplibsislocked = isset($CFG->config_php_settings['mod_hvp_backup_libraries']);

        // Options.
        if ($backuphvplibsislocked) {
            $mform->addElement('html', '<div class="alert alert-info">' . get_string('configoverride', 'admin'));
        }
        $backuphvplibs = $mform->addElement('checkbox', 'backuphvplibs', '', get_string('backuphvplibs', 'local_hvpbackupopts'));
        $mform->setDefault('backuphvplibs', $this->_customdata['backuphvplibs']);
        if ($backuphvplibsislocked) {
            $mform->addElement('html', '</div>');
            $backuphvplibs->freeze();
        }

        // Buttons.
        $buttonarray = array();
        $buttonarray[] = $mform->createElement('submit', 'send', get_string('save', 'core'));
        $buttonarray[] = $mform->createElement('cancel');

        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
        $mform->closeHeaderBefore('buttonar');
    }
}
