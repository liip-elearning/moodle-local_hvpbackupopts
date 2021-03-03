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
 * Displays the form and processes the form submission.
 *
 * @package local_hvpbackupopts
 * @copyright Liip AG <https://www.liip.ch/>
 * @author Raphael Santos <raphael.santos@liip.ch>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Include config.php.
require_once(__DIR__.'/../../config.php');
require_once($CFG->libdir.'/adminlib.php');

$pluginname = 'hvpbackupopts';

// Globals.
global $CFG, $OUTPUT, $USER, $SITE, $PAGE;

// Ensure only administrators have access.
$homeurl = new moodle_url('/');
require_login();
if (!is_siteadmin()) {
    redirect($homeurl, "This feature is only available for site administrators.", 5);
}

// Include form.
require_once(dirname(__FILE__).'/classes/'.$pluginname.'_form.php');

$title = get_string('pluginname', 'local_'.$pluginname);
$heading = get_string('pluginname', 'local_'.$pluginname);
$url = new moodle_url('/local/'.$pluginname.'/');
$context = context_system::instance();

$PAGE->set_pagelayout('admin');
$PAGE->set_url($url);
$PAGE->set_context($context);
$PAGE->set_title($title);
$PAGE->set_heading($heading);
admin_externalpage_setup('local_'.$pluginname);

$backuphvplibs = !isset($CFG->mod_hvp_backup_libraries) ? 1 : intval($CFG->mod_hvp_backup_libraries);

$form = new hvpbackupopts_form(null, array('backuphvplibs' => $backuphvplibs));

if ($form->is_cancelled()) {
    redirect($homeurl);
} else if ($data = $form->get_data()) {
    if (!isset($data->backuphvplibs)) {
        set_config('mod_hvp_backup_libraries', 0);
    } else {
        set_config('mod_hvp_backup_libraries', $data->backuphvplibs);
    }
}

echo $OUTPUT->header();
echo $OUTPUT->heading($heading);

$form->display();

echo $OUTPUT->footer();

