<?php
/**
 * This file is a part of TS3 for phpbb
 *
 * @author Matthieu YK <yk@openmailbox.org>
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @link https://bitbucket.org/matthieuy/phpbb-ts3
 */

namespace matthieuy\teamspeak\event;

use matthieuy\teamspeak\services\Teamspeak;
use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\controller\helper;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class listener
 *
 * @package matthieuy\shoutbox\event
 */
class listener implements EventSubscriberInterface
{
    private $helper;
    private $user;
    private $template;
    private $auth;
    private $config;
    private $teamspeak;

    /**
     * Constructor (DIC)
     * @param helper    $helper
     * @param user      $user
     * @param template  $template
     * @param auth      $auth
     * @param config    $config
     * @param Teamspeak $teamspeak
     */
    public function __construct(helper $helper, user $user, template $template, auth $auth, config $config, Teamspeak $teamspeak)
    {
        $this->helper = $helper;
        $this->user = $user;
        $this->template = $template;
        $this->auth = $auth;
        $this->config = $config;
        $this->teamspeak = $teamspeak;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            'core.user_setup'  => 'load_language_on_setup',
            'core.permissions' => 'permissions',
            'core.page_header' => 'add_page_header_link',
            'core.viewonline_overwrite_location' => 'viewonline_page',
        );
    }

    /**
     * Load language file
     * @param \phpbb\event\data $event
     */
    public function load_language_on_setup($event)
    {
        $lang_set_ext = $event['lang_set_ext'];
        $lang_set_ext[] = array(
            'ext_name' => 'matthieuy/teamspeak',
            'lang_set' => 'common',
        );
        $event['lang_set_ext'] = $lang_set_ext;
    }

    /**
     * Translate permission
     * @param \phpbb\event\data $event
     */
    public function permissions($event)
    {
        // Categories
        $categories = array_merge($event['categories'], array(
            'ts3' => 'TS3'
        ));

        // Permissions
        $permissions = array_merge($event['permissions'], array(
            'u_ts3_view'   => array('lang' => 'ACL_U_TS3_VIEW', 'cat' => 'ts3'),
            'u_ts3_pwd'   => array('lang' => 'ACL_U_TS3_PWD', 'cat' => 'ts3'),
        ));

        $event['permissions'] = $permissions;
        $event['categories'] = $categories;
    }

    /**
     * Show user on Who is online page
     * @param \phpbb\event\data $event core.viewonline_overwrite_location
     */
    public function viewonline_page($event)
    {
        if ($event['row']['session_page'] == 'app.php/teamspeak') {
            $event['location'] = $this->user->lang('TS3');
            $event['location_url'] = $this->helper->route('matthieuy_teamspeak_index');
        }
    }

    /**
     * Add the link in header
     * @param \phpbb\event\data $event
     */
    public function add_page_header_link($event)
    {
        if (!$this->auth->acl_get('u_ts3_view')) {
            return;
        }

        if ($this->config['ts3_count']) {
            $this->template->assign_var('U_TEAMSPEAK_COUNT', $this->helper->route('matthieuy_teamspeak_nb'));
        }

        $this->template->assign_vars(array(
            'U_TEAMSPEAK' => $this->helper->route('matthieuy_teamspeak_index'),
            'TEAMSPEAK_STATS' => $this->teamspeak->getOnline(),
        ));
    }
}
