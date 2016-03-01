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
    'TS3_SERVER_STAT' => 'État du serveur',
    'TS3_SEARCH_PROGRESS' => 'Recherche en cours...',
    'TS3_JOIN_SRV' => 'Rejoindre le serveur',
    'TS3_ADDRESS' => 'Adresse',
    'TS3_SERVER_CONFIG' => 'Configuration du serveur',
    'TS3_REFRESH_INFO' => 'Rafraichir les informations',
    'TS3_REFRESH_LIST' => 'Rafraichir la liste',
    'TS3_LIST' => 'Liste des connectés',
    'TS3_LAST_CNX' => 'Dernière activité',
    'TS3_TOP' => 'Top des utilisateurs',
    'TS3_TIME' => 'Durée total',
    'TS3_NICKNAME' => 'Pseudo',
    'TS3_CHANNEL' => 'Salon',
    'TS3_LOGIN_TIME' => 'Date de connexion',
    'TS3_OS' => 'O.S.',
    'TS3_VERSION' => 'Version',
    'TS3_ANY_USER' => 'Aucun connecté pour le moment',
    'TS3_LIST_ERROR' => 'Impossible de récupérer la liste pour le moment',
    'TS3_USER_NB' => array(
        1	=> '%d utilisateur',
        2	=> '%d utilisateurs',
    ),

    // TIME
    'TS3_WEEK' => array(
        1 => '%d semaine',
        2 => '%d semaines'
    ),
    'TS3_DAY' => array(
        1 => '%d jour',
        2 => '%d jours'
    ),
    'TS3_HOUR' => array(
        1 => '%d heure',
        2 => '%d heures'
    ),
    'TS3_MINUTE' => array(
        1 => '%d minute',
        2 => '%d minutes'
    ),

    // ACP
    'ACP_TS3_TITLE' => 'Teamspeak 3',
    'ACP_TS3_QUERY_URL' => 'Adresse du serveur query',
    'ACP_TS3_QUERY_URL_HELP' => 'Domaine ou adresse IP où lancer les requêtes (défaut : 127.0.0.1)',
    'ACP_TS3_QUERY_USER' => 'Nom d\'utilisateur pour les requêtes',
    'ACP_TS3_QUERY_USER_HELP' => '',
    'ACP_TS3_QUERY_PWD' => 'Mot de passe pour le serveur query',
    'ACP_TS3_QUERY_PWD_HELP' => '',
    'ACP_TS3_QUERY_PORT' => 'Port du serveur',
    'ACP_TS3_QUERY_PORT_HELP' => 'Port (défaut : 10011)',
    'ACP_TS3_SERVER_URL' => 'Adresse du serveur TS',
    'ACP_TS3_SERVER_URL_HELP' => 'Adresse public (à afficher aux utilisateurs)',
    'ACP_TS3_SERVER_PORT' => 'Port teamspeak',
    'ACP_TS3_SERVER_PORT_HELP' => 'Port de connexion pour les utilisateurs (défaut : 9987)',
    'ACP_TS3_SERVER_PWD' => 'Mot de passe du serveur',
    'ACP_TS3_SERVER_PWD_HELP' => 'Mot de passe pour se connecter au serveur (uniquement pour les utilisateurs)',
    'ACP_TS3_COUNT' => 'Afficher le nombre de connecté sur la page d\'accueil',
    'ACP_TS3_SETTING_SAVED' => 'La configuration a été enregistrée avec succès !',
));
