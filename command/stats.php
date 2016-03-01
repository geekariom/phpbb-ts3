<?php

namespace matthieuy\teamspeak\command;

use matthieuy\teamspeak\services\Teamspeak;
use phpbb\console\command\command;
use phpbb\db\driver\factory;
use phpbb\user;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class stats
 *
 * @package matthieuy\teamspeak\command
 */
class stats extends command
{
    private $teamspeak;
    private $db;
    private $rootPath;

    /**
     * Constructor (DIC)
     * @param user      $user
     * @param Teamspeak $teamspeak
     * @param factory   $db
     * @param string    $rootPath
     */
    public function __construct(user $user, Teamspeak $teamspeak, factory $db, $rootPath)
    {
        $this->user = $user;
        $this->teamspeak = $teamspeak;
        $this->db = $db;
        $this->rootPath = $rootPath;
        parent::__construct($user);
    }

    /**
     * Configure the command
     */
    protected function configure()
    {
        $this
            ->setName('ts3:stats')
            ->setDescription('Update TS3 stats');
    }

    /**
     * Execute command
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $onlineList = $this->teamspeak->getListeOnline();
        if (empty($onlineList)) {
            return;
        }
        global $table_prefix;

        // Increment user count
        foreach ($onlineList as $username) {
            $login = strtolower($username);
            $sql_ary = array(
                'login' => $login,
                'duree' => 1
            );
            $sql = "INSERT INTO ".$table_prefix."ts ".$this->db->sql_build_array('INSERT', $sql_ary)." ON DUPLICATE KEY UPDATE duree=duree+1";
            $this->db->sql_query($sql);
        }

        // Shoutbox extension
        if (class_exists('matthieuy\shoutbox')) {
            // Select user with + 24h
            $sql = "SELECT login, duree FROM ".$table_prefix."ts WHERE duree % 1440 = 0";
            $result = $this->db->sql_query($sql);
            $rows = $this->db->sql_fetchrowset($result);
            if ($rows) {
                require_once $this->rootPath.'/includes/functions_content.php';
            }
            $this->db->sql_freeresult($result);

            // Insert into shoutbox
            foreach ($rows as $row) {
                $message  = "[b]".$row['login']."[/b] vient de passer un jour de plus sur [url=https://geekariom.com/teamspeak#top5]TS[/url] :geek: !";
                $message .= " (total : ".$this->getNbDayTxt($row['duree']).")";
                $uid = ''; $bitfield = ''; $flags = '';
                generate_text_for_storage($message, $uid, $bitfield, $flags, true, true, true);

                $sql_ary = array(
                    'user_id' => 2,
                    'text' => $message,
                    'bitfield' => $bitfield,
                    'uid' => $uid,
                    'flags' => 7,
                    'create_at' => time()
                );

                $sql_insert = 'INSERT INTO '.$table_prefix.'shoutbox '.$this->db->sql_build_array('INSERT', $sql_ary);
                $this->db->sql_query($sql_insert);
            }
        }
    }

    /**
     * Get days txt
     * @param int $minutes Nb of minutes
     *
     * @return string Nb of weeks and hours
     */
    private function getNbDayTxt($minutes)
    {
        $duration = [];

        // Semaines
        $weeks = floor($minutes / 10080);
        if ($weeks == 1) {
            $duration[] = 'une semaine';
        } elseif ($weeks > 1) {
            $duration[] = $weeks.' semaines';
        }

        // Days
        $minutes -= $weeks * 10080;
        $days = floor($minutes / 1440);
        if ($days == 1) {
            $duration[] = 'un jour';
        } elseif ($days > 1) {
            $duration[] = $days.' jours';
        }

        return implode(', ', $duration);
    }
}
