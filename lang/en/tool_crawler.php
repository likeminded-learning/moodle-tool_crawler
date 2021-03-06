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
 * Defines the lang strings of tool_crawler plugin
 *
 * @package    tool_crawler
 * @author     Brendan Heywood <brendan@catalyst-au.net>
 * @copyright  Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();
$string['autocreate'] = 'Auto create';
$string['bigfilesize'] = 'Size of Big files';
$string['bigfilesizedesc'] = 'How big a file needs to be to get flagged as oversize. In MB';
$string['botcantgettestpage'] = 'Bot could not request test page';
$string['botpassword'] = 'Bot password';
$string['botpassworddesc'] = 'The password of the moodle user to crawl as. This user should have site wide view permission, but very limited edit permissions, and be configured to use basic auth.';
$string['bottestpagenotreturned'] = 'Bot test page wasn\'t returned';
$string['bottestpageredirected'] = 'Bot test page was redirected to {$a->resredirect}';
$string['botuser'] = 'Bot user';
$string['botusermissing'] = 'Bot user missing';
$string['botusername'] = 'Bot username';
$string['botusernamedesc'] = 'The username of the moodle user to crawl as';
$string['broken'] = 'Broken links / URLs';
$string['broken_header'] = '<p>Duplicate URLs will only be searched once.</p>';
$string['clicrawlashelp'] = 'Crawl a URL as the robot and parse it.

Useful for when a page has been corrected and you want to instantly reflect this.

Options:
-h, --help      Print out this help
-u, --url       URL to crawl and process

Example:
$sudo -u www-data php crawl-as.php --url=http://ford.com/
';
$string['clierror'] = 'Error: {$a}';
$string['cliscrapeashelp'] = 'Scrape the URL as the robot would see it, but do not process/queue it.

Options:
-h, --help      Print out this help
-u, --url       URL to scrape

Example:
$sudo -u www-data php scrape-as.php --url=http://ford.com/
';
$string['configmissing'] = 'Config missing';
$string['course'] = 'Course';
$string['courseurl'] = 'Course URL';
$string['curcrawlstart'] = 'Current crawl started at';
$string['crawlend'] = 'Crawl end';
$string['crawlstart'] = 'Crawl start';
$string['cronticks'] = 'Cron ticks';
$string['duration'] = 'Duration';
$string['event:crawlstart'] = 'Link check crawl started';
$string['event:crawlstartdesc'] = 'Link check crawl started {$a}';
$string['eventrobotcleanupcompleted'] = 'Linkchecker robot cleanup completed';
$string['eventrobotcleanupstarted'] = 'Linkchecker robot cleanup started';
$string['excludeexturl'] = 'Exclude external URLs';
$string['excludeexturldesc'] = 'One URL regex per line, each is matched against the full URL';
$string['excludemdldom'] = 'Exclude moodle DOM\'s';
$string['excludemdldomdesc'] = 'One css / xpath expression per line, these parts of the DOM will be removed before links are extracted';
$string['excludemdlparam'] = 'Exclude moodle URL params\'s';
$string['excludemdlparamdesc'] = 'One param key per line. URLs using this will still be crawled but with these params removed to avoid duplicates.';
$string['excludemdlurl'] = 'Exclude moodle URLs';
$string['excludemdlurldesc'] = 'One URL regex per line, each is matched excluding the wwwroot';
$string['excludecourses'] = 'Exclude courses';
$string['excludecoursesdesc'] = 'One course shortcode regex per line';
$string['found'] = 'Found';
$string['frompage'] = 'From page';
$string['frompageurl'] = 'From page URL';
$string['good'] = 'Good';
$string['hellorobot'] = 'Hello robot: \'{$a->botusername}\'';
$string['hellorobotheading'] = 'Hello robot!';
$string['idattr'] = 'HTML context';
$string['incomingurls'] = 'Incoming URLs';
$string['incourse'] = 'In course';
$string['lastcrawledtime'] = 'Last crawled time';
$string['lastcrawlend'] = 'Last crawl ended at';
$string['lastcrawlproc'] = 'Last crawl process';
$string['lastqueuesize'] = 'Last queue size';
$string['linktext'] = 'Link text';
$string['maxcrontime'] = 'Cron run limit';
$string['maxcrontimedesc'] = 'The crawler will keep crawling until this limit is hit on each cron tick. In seconds';
$string['maxtime'] = 'Max execution time';
$string['maxtimedesc'] = 'The timeout for each crawl request';
$string['mimetype'] = 'Mime type';
$string['missing'] = 'Missing';
$string['neverfinished'] = 'Never finished';
$string['neverrun'] = 'Never run';
$string['no'] = 'No';
$string['notyetknown'] = 'Not yet known';
$string['numberurlsfound'] = 'Found {$a->reports_number} {$a->repoprt_type}  URLs';
$string['numlinks'] = 'Total links';
$string['numurls'] = 'Total URLs';
$string['oversize'] = 'Big / slow links';
$string['oversize_header'] = '<p>Big files with multiple incoming links to them will be duplicated.</p>';
$string['outgoingurls'] = 'Outgoing URLs';
$string['progress'] = 'Progress';
$string['progresseta'] = '{$a->percent}; ETA is {$a->eta}';
$string['pluginname'] = 'Link crawler robot';
$string['queued'] = 'Queued URLs';
$string['queued_header'] = '<p>The title and course are only known if the URL has been seen on a previous crawl.</p>';
$string['recent'] = 'Recently crawled URLs';
$string['recentactivity'] = 'Days of recent activity';
$string['recentactivitydesc'] = 'A course is crawled only if it has been viewed in the last X days.
At ' . '{$a->days}' . ' day(s) of recent activity, this will include ' . '{$a->count}' . ' courses total.';
$string['recent_header'] = '';
$string['redirect'] = 'Redirect: {$a->redirectlink}';
$string['response'] = 'Response';
$string['retentionperiod'] = 'Retention period for bad URLs';
$string['retentionperioddesc'] = 'How many days to keep bad URLs in database.';
$string['retry'] = 'Retry';
$string['resetprogress'] = 'Reset Progress';
$string['resetprogress_header'] = 'Reset Crawler Progress';
$string['resetprogress_warning'] = 'Warning. You are about to reset the Crawler. Are you sure you want to do this?';
$string['resetprogress_warning_button'] = 'Reset Crawler';
$string['robotcleanup'] = 'Robot cleanup';
$string['robotstatus'] = 'Robot status';
$string['seedurl'] = 'Seed URL';
$string['seedurldesc'] = 'Where the crawler will start';
$string['settings'] = 'Settings';
$string['size'] = 'Size';
$string['slowurl'] = 'Slow URL';
$string['status'] = 'Robot status';
$string['strftimerecentsecondshtml'] = '%h %e,&nbsp;%H:%M:%S';
$string['useraccount'] = 'User account';
$string['unknown'] = 'Unknown';
$string['url'] = 'URL';
$string['urldetails'] = 'URL details';
$string['urldetails_help'] = 'This shows all incoming and outgoing links for this URL.
Links which have been blacklisted or which are in excluded DOM elements will not be shown.';
$string['uselogs'] = 'Use log tables';
$string['uselogsdesc'] = 'Use the table mdl_logstore_standard_log to only crawl links that are part of courses with recent activity. Setting to yes enables the recentactivity setting.';
$string['useragent'] = 'Bot user agent string';
$string['useragentdesc'] = 'The User agent string it use in the http headers + the version of this plugin';
$string['whenqueued'] = 'When queued';
$string['reportpagetitle'] = 'Report: {$a} - Link Crawler';
/*
 * Privacy provider (GDPR)
 */
$string["privacy:no_data_reason"] = "The Basic authentication plugin does not store any personal data.";
$string['yes'] = 'Yes';
/*
 * Capabilities
 */
$string['crawler:viewreports'] = 'View link crawler reports';
$string['crawler:changesettings'] = 'Change link crawler settings';
