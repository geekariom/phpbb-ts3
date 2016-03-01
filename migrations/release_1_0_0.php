<?php
/**
 * This file is a part of teamspeak for phpbb
 *
 * @author Matthieu YK <yk@openmailbox.org>
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @link https://bitbucket.org/matthieuy/phpbb-ts3
 */

namespace matthieuy\teamspeak\migrations;

use phpbb\db\migration\migration;

/**
 * Class release_1_0_0
 *
 * @package matthieuy\teamspeak\migrations
 */
class release_1_0_0 extends migration
{
    /**
     * Is install ?
     * @return bool
     */
    public function effectively_installed()
    {
        return isset($this->config['teamspeak_version']) && version_compare($this->config['teamspeak_version'], '1.0.0', '>=');
    }

    /**
     * Update data
     * @return array
     */
    public function update_data()
    {
        return array(
            array('config.add', array('ts3_version', '1.0.0')),
            array('config.add', array('ts3_query_url', '127.0.0.1')),
            array('config.add', array('ts3_query_user', 'phpbb')),
            array('config.add', array('ts3_query_pwd', '')),
            array('config.add', array('ts3_query_port', '10011')),
            array('config.add', array('ts3_server_url', $this->config['server_name'])),
            array('config.add', array('ts3_server_port', '9987')),
            array('config.add', array('ts3_server_pwd', '')),
            array('config.add', array('ts3_count', '1')),
            array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_TS3_TITLE')),
            array('module.add', array('acp', 'ACP_TS3_TITLE', array(
                'module_basename'	=> '\matthieuy\teamspeak\acp\main_module',
                'modes'				=> array('settings'),
            ))),
            array('permission.add', array('u_ts3_view')),
            array('permission.add', array('u_ts3_pwd')),
            array('permission.permission_set', array('REGISTERED', 'u_ts3_view', 'group')),
            array('permission.permission_set', array('REGISTERED', 'u_ts3_pwd', 'group')),
        );
    }

    /**
     * Remove data
     * @return array
     */
    public function revert_data()
    {
        return array(
            array('config.remove',
                array('ts3_version'), array('ts3_query_user'), array('ts3_query_pwd'), array('ts3_query_url'),
                array('ts3_query_port'), array('ts3_server_url'), array('ts3_server_port'), array('ts3_server_pwd'),
                array('ts3_count'),
            ),
            array('module.remove', array('acp', 'ACP_TS3_TITLE')),
            array('permission.remove', array('u_ts3_view')),
            array('permission.remove', array('u_ts3_pwd')),
        );
    }
}
