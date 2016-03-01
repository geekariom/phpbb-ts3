<?php
/**
 * This file is a part of teamspeak for phpbb
 *
 * @author Matthieu YK <yk@openmailbox.org>
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @link https://bitbucket.org/matthieuy/phpbb-ts3
 */

namespace matthieuy\teamspeak;

use phpbb\extension\base;

/**
 * Class ext
 *
 * @package matthieuy\teamspeak
 */
class ext extends base {
    /** @var string Require 3.1.3 due to throwing new exceptions
     *              and using containerAware migration files.
     */
    const PHPBB_VERSION = '3.1.3';

    /**
     * {@inheritdoc}
     */
    public function is_enableable()
    {
        $config = $this->container->get('config');
        return phpbb_version_compare($config['version'], self::PHPBB_VERSION, '>=');
    }
}
