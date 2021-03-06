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
 * Helper lib
 *
 * @package    tool_crawler
 * @copyright  2016 Brendan Heywood <brendan@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Render a link
 *
 * @param string $url a URL link
 * @param string $label the a tag label
 * @param string $redirect The final URL if a redirect was served
 * @return html output
 */
function tool_crawler_link($url, $label, $redirect = '') {
    $html = html_writer::link(new moodle_url('url.php', array('url' => $url)), $label) .
            ' ' .
            html_writer::link($url, '↗', array('target' => 'link')) .
            '<br><small>' . htmlspecialchars($url) . '</small>';

    if ($redirect) {
        $linkhtmlsnippet = html_writer::link($redirect, htmlspecialchars($redirect, ENT_NOQUOTES | ENT_HTML5));
        $html .= "<br>" . get_string('redirect', 'tool_crawler', array('redirectlink' => $linkhtmlsnippet));
    }

    return $html;
}

/**
 * Get a html code chunk
 *
 * @param integer $row row
 * @return html chunk
 */
function tool_crawler_http_code($row) {
    $msg = isset($row->httpmsg) ? $row->httpmsg : '?';
    $code = $row->httpcode;
    $cc = substr($code, 0, 1);
    $code = "$msg<br><small class='link-$cc"."xx'>$code</small>";
    return $code;
}

/**
 * Formats a number according to the current user’s locale.
 *
 * @param float $number Numeric value to format.
 * @param int $decimals Number of decimals after the decimal separator. Defaults to 0.
 * @return string String with number formatted as per user’s locale.
 */
function tool_crawler_numberformat(float $number, int $decimals = 0) {
    $decsep = get_string('decsep', 'langconfig');
    $thousandssep = get_string('thousandssep', 'langconfig');

    return number_format($number, $decimals, $decsep, $thousandssep);
}

/**
 * Generates a nice table for the URL detail page.
 *
 * @param array $data table
 * @return html output
 */
function tool_crawler_url_gen_table($data) {
    $table = new html_table();
    $table->head = array(
        get_string('lastcrawledtime', 'tool_crawler'),
        get_string('linktext', 'tool_crawler'),
        get_string('idattr', 'tool_crawler'),
        get_string('response', 'tool_crawler'),
        get_string('size', 'tool_crawler'),
        get_string('url', 'tool_crawler'),
        get_string('mimetype', 'tool_crawler'),
    );
    $datetimeformat = get_string('strftimerecentsecondshtml', 'tool_crawler');
    $table->data = array();
    foreach ($data as $row) {
        $text = trim($row->title);
        if (!$text || $text == "") {
            $text = get_string('unknown', 'tool_crawler');
        }
        $code = tool_crawler_http_code($row);
        $size = $row->filesize * 1;
        $data = array(
            userdate($row->lastcrawled, $datetimeformat),
            $row->text,
            str_replace(' #', '<br>#', $row->idattr),
            $code,
            display_size($size),
            tool_crawler_link($row->target, $text, $row->redirect),
            $row->mimetype,
        );
        $table->data[] = $data;
    }
    return html_writer::table($table);
}

/**
 * Generates and returns a full HTML page with details about a URL.
 *
 * @param string $url The URL.
 * @return string A HTML page about the URL.
 */
function tool_crawler_url_create_page($url) {
    global $PAGE, $OUTPUT, $DB;

    require_login(null, false);
    $context = context_system::instance();
    require_capability('tool/crawler:viewreports', $context);

    $navurl = new moodle_url('/admin/tool/crawler/url.php', array(
        'url' => $url
    ));
    $PAGE->set_context($context);
    $PAGE->set_url($navurl);
    $PAGE->set_pagelayout('admin');
    $PAGE->set_title(get_string('urldetails', 'tool_crawler') );

    $page = $OUTPUT->header();

    $page .= $OUTPUT->heading(get_string('urldetails', 'tool_crawler'));
    $urldetailshelp = get_string('urldetails_help', 'tool_crawler');
    $urldetailshelp = htmlspecialchars($urldetailshelp, ENT_NOQUOTES | ENT_HTML401);
    $urldetailshelp = preg_replace('/(\r\n?|\n)/', '<br>', $urldetailshelp);
    $page .= '<p>' . $urldetailshelp . '</p>';

    $urlrec = $DB->get_record('tool_crawler_url', array('url' => $url));
    $page .= '<h2>' . tool_crawler_link($url, $urlrec->title, $urlrec->redirect) . '</h2>';

    $page .= '<h3>' . get_string('outgoingurls', 'tool_crawler') . '</h3>';

    $data  = $DB->get_records_sql("
         SELECT concat(l.a, '-', l.b) AS id,
                l.text,
                l.idattr,
                t.url target,
                t.title,
                t.redirect,
                t.httpmsg,
                t.httpcode,
                t.filesize,
                t.lastcrawled,
                t.mimetype,
                t.external,
                t.courseid,
                c.shortname
           FROM {tool_crawler_edge} l
           JOIN {tool_crawler_url} f ON f.id = l.a
           JOIN {tool_crawler_url} t ON t.id = l.b
      LEFT JOIN {course} c ON c.id = t.courseid
          WHERE f.url = ?
       ORDER BY f.lastcrawled DESC
    ", array($url));

    $page .= tool_crawler_url_gen_table($data);

    $page .= '<h3>' . get_string('incomingurls', 'tool_crawler') . '</h3>';

    $data  = $DB->get_records_sql("
         SELECT concat(l.a, '-', l.b) AS id,
                l.text,
                l.idattr,
                f.url target,
                f.title,
                f.redirect,
                f.httpmsg,
                f.httpcode,
                f.filesize,
                f.lastcrawled,
                f.mimetype,
                f.external,
                f.courseid,
                c.shortname
           FROM {tool_crawler_edge} l
           JOIN {tool_crawler_url} f ON f.id = l.a
           JOIN {tool_crawler_url} t ON t.id = l.b
      LEFT JOIN {course} c ON c.id = f.courseid
          WHERE t.url = ?
       ORDER BY f.lastcrawled DESC
    ", array($url));

    $page .= tool_crawler_url_gen_table($data);

    $page .= $OUTPUT->footer();

    return $page;
}
