<?php
/**
 * This file is a part of teamspeak for phpbb
 *
 * @author Matthieu YK <yk@openmailbox.org>
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @link https://bitbucket.org/matthieuy/phpbb-ts3
 */

if (!defined('IN_PHPBB'))
{
    exit;
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
    // General
    'TS3' => 'Teamspeak',
    'TS3_SERVER_STAT' => 'Status server',
    'TS3_SEARCH_PROGRESS' => 'Search in progress...',
    'TS3_JOIN_SRV' => 'Join the server',
    'TS3_ADDRESS' => 'Address',
    'TS3_SERVER_CONFIG' => 'Server settings',
    'TS3_REFRESH_INFO' => 'Refresh informations',
    'TS3_REFRESH_LIST' => 'Refresh list',
    'TS3_LIST' => 'List of users',
    'TS3_LAST_CNX' => 'Last active',
    'TS3_TOP' => 'Top of users',
    'TS3_TIME' => 'Time',
    'TS3_NICKNAME' => 'Nickname',
    'TS3_CHANNEL' => 'Channel',
    'TS3_LOGIN_TIME' => 'Date of connexion',
    'TS3_OS' => 'O.S.',
    'TS3_VERSION' => 'Version',
    'TS3_ANY_USER' => 'Any user',
    'TS3_LIST_ERROR' => 'Could not fetch the list for the moment',
    'TS3_USER_NB' => array(
        1	=> '%d user',
        2	=> '%d users',
    ),

    // ACP
    'ACP_TS3_TITLE' => 'Teamspeak 3',
    'ACP_TS3_QUERY_URL' => 'Query server URL',
    'ACP_TS3_QUERY_URL_HELP' => 'Domain or IP address where launch query (default : 127.0.0.1)',
    'ACP_TS3_QUERY_USER' => 'Query username',
    'ACP_TS3_QUERY_USER_HELP' => '',
    'ACP_TS3_QUERY_PWD' => 'Password of query user',
    'ACP_TS3_QUERY_PWD_HELP' => '',
    'ACP_TS3_QUERY_PORT' => 'Server query port',
    'ACP_TS3_QUERY_PORT_HELP' => 'Port (default : 10011)',
    'ACP_TS3_SERVER_URL' => 'Teamspeak address',
    'ACP_TS3_SERVER_URL_HELP' => 'Public address (to show for users)',
    'ACP_TS3_SERVER_PORT' => 'Teamspeak port',
    'ACP_TS3_SERVER_PORT_HELP' => 'Teamspeak port for users (default : 9987)',
    'ACP_TS3_SERVER_PWD' => 'Server password',
    'ACP_TS3_SERVER_PWD_HELP' => 'Password for connect the server (only use to show for users)',
    'ACP_TS3_COUNT' => 'Show number of user on the homepage',
    'ACP_TS3_SETTING_SAVED' => 'Settings have been saved successfully!',
));
