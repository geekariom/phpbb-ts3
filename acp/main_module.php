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
 * Class main_module
 *
 * @package matthieuy\teamspeak\acp
 */
class main_module
{
    public $u_action;

    /**
     * Main
     * @param int $id
     * @param string $mode
     */
    public function main($id, $mode)
    {
        /** @var \phpbb\request\request $request */
        global $user, $request, $template, $config;

        $user->add_lang('acp/common');
        $this->tpl_name = 'ts3_config';
        $this->page_title = $user->lang('ACP_TS3_TITLE');
        add_form_key('matthieuy/teamspeak');

        // Submit form
        if ($request->is_set_post('submit')) {
            if (!check_form_key('matthieuy/teamspeak')) {
                trigger_error('FORM_INVALID');
            }

            // Save
            $config->set('ts3_query_url', $request->variable('ts3_query_url', '127.0.0.1'));
            $config->set('ts3_query_user', $request->variable('ts3_query_user', ''));
            $config->set('ts3_query_pwd', $request->variable('ts3_query_pwd', ''));
            $config->set('ts3_query_port', $request->variable('ts3_query_port', '10011'));
            $config->set('ts3_server_url', $request->variable('ts3_server_url', ''));
            $config->set('ts3_server_port', $request->variable('ts3_server_port', '9987'));
            $config->set('ts3_server_pwd', $request->variable('ts3_server_pwd', ''));
            $config->set('ts3_count', $request->variable('ts3_count', '1'));

            // Success message
            trigger_error($user->lang('ACP_TS3_SETTING_SAVED') . adm_back_link($this->u_action));
        }

        // Template
        $template->assign_vars(array(
            'U_ACTION' => $this->u_action,
            'TS3_QUERY_URL' => $config['ts3_query_url'],
            'TS3_QUERY_USER' => $config['ts3_query_user'],
            'TS3_QUERY_PWD' => $config['ts3_query_pwd'],
            'TS3_QUERY_PORT' => $config['ts3_query_port'],
            'TS3_SERVER_URL' => $config['ts3_server_url'],
            'TS3_SERVER_PORT' => $config['ts3_server_port'],
            'TS3_SERVER_PWD' => $config['ts3_server_pwd'],
            'TS3_COUNT' => $config['ts3_count'],
        ));
    }
}
