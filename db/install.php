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
 * Tool tweak inport tweak
 *
 * @package    tool_tweak
 * @copyright  2023 Marcus Green
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Install some example tweaks
 */
function xmldb_tool_tweak_install() {
    global $DB, $CFG;
    $filecontent = file_get_contents($CFG->dirroot."/admin/tool/tweak/db/tweaks.json");
    $rows = json_decode($filecontent);
    foreach ($rows as $row) {
        if (!$row->tweakname) {
            continue;
        }
        $pagetypes = $row->pagetype;
        unset($row->pagetype);
        $tweakid = $DB->insert_record('tool_tweak', $row);
        foreach ($pagetypes as $pagetype) {
            $DB->insert_record('tool_tweak_pagetype', ['tweak' => $tweakid, 'pagetype' => $pagetype]);
        }
    }

}
