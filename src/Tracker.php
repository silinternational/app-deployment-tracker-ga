<?php
namespace AppDeploymentTracker;

use Sil\PhpEnv\Env;
use TheIconic\Tracking\GoogleAnalytics\Analytics;
use Dotenv\Dotenv;

class Tracker
{
    public static function init()
    {
        $dotEnvPath = __DIR__ . '/..';
        /*
         * Load environment
         */
        if ( ! file_exists($dotEnvPath. '/.env')) {
            touch($dotEnvPath . '/.env');
        }
        $dotenv = new Dotenv($dotEnvPath);
        $dotenv->load();

        define('TRACKER_INITIALIZED', true);
    }

    public static function track()
    {
        if ( ! defined('TRACKER_INITIALIZED')) {
            self::init();
        }

        $trackingId = Env::get('TRACKING_ID', null);
        if ($trackingId === null) {
            throw new \Exception('TRACKING_ID is required');
        }

        $eventCategory = Env::get('EVENT_CATEGORY', 'app-deployment');

        $userIdValueEnvVar = Env::get('USER_ID_VALUE_ENV_VAR', 'CI_REPO_NAME');
        $userId = Env::get($userIdValueEnvVar, null);

        $dataSourceValueEnvVar = Env::get('DATA_SOURCE_VALUE_ENV_VAR', 'CI_NAME');
        $dataSource = Env::get($dataSourceValueEnvVar, 'script');

        $eventActionValueEnvVar = Env::get('EVENT_ACTION_VALUE_ENV_VAR', 'CI_BRANCH');
        $eventAction = Env::get($eventActionValueEnvVar, 'master');

        $eventLabel = Env::get('EVENT_LABEL', $userId);
        $documentTitle = Env::get('DOCUMENT_TITLE', $userId);

        /*
         * Track Event
         */
        $analytics = new Analytics();
        $analytics->setProtocolVersion('1')
            ->setTrackingId($trackingId)
            ->setClientId($userId)
            ->setDataSource($dataSource)
            ->setHitType('event')
            ->setDocumentTitle($documentTitle)
            ->setEventCategory($eventCategory)
            ->setEventAction($eventAction)
            ->setEventLabel($eventLabel)
            ->sendEvent();

        exit(0);
    }
}