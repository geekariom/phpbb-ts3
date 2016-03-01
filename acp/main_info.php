<?php
/**
 * This file is a part of TS3 for phpbb
 *
 * @author Matthieu YK <yk@openmailbox.org>
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @link https://bitbucket.org/matthieuy/phpbb-ts3
 * @package language
 */

namespace matthieuy\teamspeak\acp;

/**
 * Class main_info
 *
 * @package matthieuy\teamspeak\acp
 */
class main_info
{
    /**
     * Module config
     * @return array
     */
    public function module()
    {
        return array(
            'filename' => '\matthieuy\teamspeak\acp\main_module',
            'title' => 'ACP_TS3_TITLE',
            'version' => '1.0.0',
            'modes' => array(
                'settings' => array(
                    'title' => 'TS3',
                    'auth' => 'ext_matthieuy/teamspeak && acl_a_board',
                    'cat' => 'ACP_TS3_TITLE'
                )
            )
        );
    }
}
