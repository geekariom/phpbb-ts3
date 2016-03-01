<?php
/**
 * This file is a part of teamspeak for phpbb
 *
 * @author Matthieu YK <yk@openmailbox.org>
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @link https://bitbucket.org/matthieuy/phpbb-ts3
 */

namespace matthieuy\teamspeak\services;

use phpbb\auth\auth;
use phpbb\cache\service;
use phpbb\config\config;
use phpbb\db\driver\factory;
use phpbb\user;

/**
 * Class Teamspeak
 *
 * @package matthieuy\teamspeak\services
 */
class Teamspeak
{
    private $config;
    private $auth;
    private $cache;
    private $db;
    private $user;

    /**
     * Constructor (DIC)
     * @param config  $config
     * @param auth    $auth
     * @param service $cache
     */
    public function __construct(config $config, auth $auth, service $cache, factory $db, user $user)
    {
        $this->config = $config;
        $this->auth = $auth;
        $this->cache = $cache->get_driver();
        $this->db = $db;
        $this->user = $user;
    }

    /**
     * Get info for ajax request
     * @param user $user
     * @param array $info
     */
    public function getInfo(user $user, &$info = array())
    {
        $info['url'] = $this->config['ts3_server_url'];
        $info['port'] = $this->config['ts3_server_port'];
        $info['status'] = true;

        if ($this->auth->acl_get('u_ts3_pwd')) {
            $info['pwd'] = $this->config['ts3_server_pwd'];
        }

        $query_url = $this->getQueryUrl();

        try {
            $ts3 = \TeamSpeak3::factory($query_url);
            $chanelList = $ts3->channelList();
            $clientList = $ts3->clientList(array('client_type' => 0));

            foreach ($clientList as $client) {
                $clientIP = (string) $client['connection_client_ip'];
                $clientIP = preg_replace('/\.\d+\.\d+$/', '.xxx.xxx', $clientIP);

                $info['users'][] = array(
                    'login' => (string) $client,
                    'ip' => $clientIP,
                    'version' => (string) $client['client_version'],
                    'os' => (string) $client['client_platform'],
                    'channel' => (string) $chanelList[$client['cid']]['channel_name'],
                    'cid' => $client['cid'],
                    'date' => $user->format_date($client['client_lastconnected']),
                );
            }
        } catch (\Exception $e) {
            if ($e->getMessage() == 'Connection refused') {
                $info['status'] = false;
            }
            $info['users'] = false;
        }
    }

    /**
     * Get the number and name of users
     * @return array
     */
    public function getOnline()
    {
        // Query
        $clientList = $this->getListeOnline();
        return array(
            'txt' => implode(', ', $clientList),
            'nbr' => count($clientList)
        );
    }

    public function getTop($nb)
    {
        global $table_prefix;
        $sql = "SELECT login, duree, update_at FROM ".$table_prefix."ts ORDER BY duree DESC";
        $result = $this->db->sql_query_limit($sql, $nb);
        $list = array();
        while ($row = $this->db->sql_fetchrow($result)) {
            $list[] = array(
                'username' => $row['login'],
                'time' => $this->showTime($row['duree']),
                'last_cnx' => $this->user->format_date(strtotime($row['update_at'])),
            );
        }

        return $list;
    }

    /**
     * Get the list of online user
     * @return array
     */
    public function getListeOnline()
    {
        $query_url = $this->getQueryUrl();

        if (($onlineList = $this->cache->get('ts3_online_list')) == false) {
            // Query
            try {
                $ts3 = \TeamSpeak3::factory($query_url);
                $clientList = $ts3->clientList(array('client_type' => 0));
                $onlineList = array();

                foreach($clientList as $client){
                    $onlineList[] = (string) $client;
                }
            } catch (\Exception $e) {
                return array();
            }

            // Cache
            $this->cache->put('ts3_online_list', $onlineList, 50);
        }

        return $onlineList;
    }

    /**
     * Get the query string
     * @return string
     */
    private function getQueryUrl()
    {
        return sprintf('serverquery://%s:%s@%s:%s/?server_port=%s',
            $this->config['ts3_query_user'],
            $this->config['ts3_query_pwd'],
            $this->config['ts3_query_url'],
            $this->config['ts3_query_port'],
            $this->config['ts3_server_port']
        );
    }

    private function showTime($duree)
    {
        $duration = [];

        $weeks = floor($duree / 10080);
        $duree -= $weeks * 10080;
        $days = floor($duree / 1440);
        $duree -= $days * 1440;
        $hours = floor($duree / 60);
        $minutes = $duree - $hours * 60;

        if ($weeks) {
            $duration[] = $this->user->lang('TS3_WEEK', $weeks);
        }
        if ($days) {
            $duration[] = $this->user->lang('TS3_DAY', $days);
        }
        if ($hours) {
            $duration[] = $this->user->lang('TS3_HOUR', $hours);
        }
        if ($minutes) {
            $duration[] = $this->user->lang('TS3_MINUTE', $minutes);
        }
        return implode(', ', $duration);
    }
}
