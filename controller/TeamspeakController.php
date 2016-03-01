<?php
/**
 * This file is a part of TS3 for phpbb
 *
 * @author Matthieu YK <yk@openmailbox.org>
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @link https://bitbucket.org/matthieuy/phpbb-ts3
 */

namespace matthieuy\teamspeak\controller;

use matthieuy\teamspeak\services\Teamspeak;
use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\controller\helper;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TeamspeakController
 *
 * @package matthieuy\teamspeak\controller
 */
class TeamspeakController
{
    private $helper;
    private $template;
    private $user;
    private $auth;
    private $teamspeak;
    private $config;

    /**
     * Constructor (DIC)
     * @param helper    $helper
     * @param template  $template
     * @param user      $user
     * @param auth      $auth
     * @param Teamspeak $teamspeak
     */
    public function __construct(helper $helper, template $template, user $user, auth $auth, Teamspeak $teamspeak, config $config)
    {
        $this->helper = $helper;
        $this->template = $template;
        $this->user = $user;
        $this->auth = $auth;
        $this->teamspeak = $teamspeak;
        $this->config = $config;
    }

    /**
     * Teamspeak page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        if (!$this->auth->acl_get('u_ts3_view')) {
            trigger_error('NOT_AUTHORISED');
        }
        $title = $this->user->lang['TS3'];

        // Breadcrumbs
        $this->template->assign_block_vars('navlinks', array(
            'FORUM_NAME'	=> $title,
            'U_VIEW_FORUM'	=> $this->helper->route('matthieuy_teamspeak_index'),
        ));

        $this->template->assign_vars(array(
            'U_TS3_AJAX' => $this->helper->route('matthieuy_teamspeak_ajax'),
            'TS3_TOP' => $this->teamspeak->getTop(6),
        ));

        return $this->helper->render('teamspeak.html', $title);
    }

    /**
     * Ajax request
     * @return JsonResponse
     */
    public function ajax()
    {
        if (!$this->auth->acl_get('u_ts3_view')) {
            return new Response('', 403);
        }

        $json = array(
            'status' => false,
            'url' => '',
            'pwd' => '',
            'port' => '9987',
            'login' => $this->user->data['username'],
            'users' => array()
        );
        $this->teamspeak->getInfo($this->user, $json);

        $json['statusText'] = $json['status'] ? $this->user->lang['ONLINE'] : $this->user->lang['OFFLINE'];
        if ($json['users'] === false) {
            $json['users_msg'] = $this->user->lang['TS3_LIST_ERROR'];
        } elseif (count($json['users']) == 0) {
            $json['users_msg'] = $this->user->lang['TS3_ANY_USER'];
        }

        return new JsonResponse($json);
    }

    /**
     * Get the number of user
     * @return JsonResponse
     */
    public function nb()
    {
        if (!$this->auth->acl_get('u_ts3_view') || !$this->config['ts3_count']) {
            return new Response('', 403);
        }
        $info = $this->teamspeak->getOnline();
        $info['nbr_txt'] = $this->user->lang('TS3_USER_NB', $info['nbr']);

        return new JsonResponse($info);
    }
}
