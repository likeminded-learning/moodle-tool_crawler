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

require_once("../../../config.php");

global $CFG;
require_once($CFG->dirroot . '/lib/excellib.class.php');

$report = required_param('report', PARAM_ALPHA);

// Calculate file name
$time             = str_replace(' ', '_', userdate(time()));
$downloadfilename = clean_filename("{$report}_link_report_({$time})");
// Creating a workbook
$workbook = new MoodleExcelWorkbook("-");
// Sending HTTP headers
$workbook->send($downloadfilename);
// Adding the worksheet
$myxls = $workbook->add_worksheet($report);

// this has potential to get pretty big...
raise_memory_limit(MEMORY_HUGE);

switch ($report)
{
    case 'broken':
        $data = $DB->get_records_sql(
            "SELECT concat(b.id, '-', l.id, '-', a.id) AS id,
              b.url target,
              b.httpcode,
              b.httpmsg,
              b.lastcrawled,
              b.id AS toid,
              l.id AS linkid,
              l.text,
              a.url AS from_url,
              a.title,
              a.redirect,
              a.courseid,
              c.fullname 
            FROM {tool_crawler_url}  b
              LEFT JOIN {tool_crawler_edge} l ON l.b = b.id
              LEFT JOIN {tool_crawler_url}  a ON l.a = a.id
              LEFT JOIN {course} c ON c.id = a.courseid
            WHERE b.httpcode != 200
            ORDER BY httpcode DESC,
            c.shortname ASC");

        // Write column names
        $col = 0;
        $myxls->write_string(0, $col++, get_string('lastcrawledtime', 'tool_crawler'));
        $myxls->write_string(0, $col++, get_string('response', 'tool_crawler'));
        $myxls->write_string(0, $col++, get_string('linktext', 'tool_crawler'));
        $myxls->write_string(0, $col++, get_string('broken', 'tool_crawler'));
        $myxls->write_string(0, $col++, get_string('frompage', 'tool_crawler'));
        $myxls->write_string(0, $col++, get_string('frompageurl', 'tool_crawler'));
        $myxls->write_string(0, $col++, get_string('course', 'tool_crawler'));
        $myxls->write_string(0, $col++, get_string('courseurl', 'tool_crawler'));

        // Write data
        $col = $row = 0;
        foreach ($data as $key => $row_data)
        {
            $col = 0;
            $row++;

            // last crawled
            $myxls->write_date($row, $col++, $row_data->lastcrawled);
            // response
            $myxls->write_string($row, $col++, $row_data->httpmsg);
            // link text
            $myxls->write_string($row, $col++,
                (!empty($row_data->text)
                    ? trim($row_data->text)
                    : get_string('missing', 'tool_crawler')));
            // target url
            $myxls->write_url($row, $col++, $row_data->target);
            // from title
            $myxls->write_string($row, $col++, $row_data->title);
            // from url
            $myxls->write_url($row, $col++, $row_data->from_url);
            // course name
            $myxls->write_string($row, $col++,
                (!empty($row_data->fullname)
                    ? $row_data->fullname
                    : '-'));
            // course url
            $myxls->write_url($row, $col++, new moodle_url('/course/view.php', ['id' => $row_data->courseid]));
        }

        // discard potentially huge array
        unset($data);

        break;

    default:
        throw new Exception("Invalid report url parameter '{$report}'");
}

$workbook->close();
