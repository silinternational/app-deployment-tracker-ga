<?php
require __DIR__ . '/vendor/autoload.php';

use Sil\PhpEnv\Env;
use TheIconic\Tracking\GoogleAnalytics\Analytics;
use Dotenv\Dotenv;

/*
 * Load environment
 */
$dotenv = new Dotenv(__DIR__);
$dotenv->load();

$trackingId = Env::get('TRACKING_ID', null);
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
 * Require Tracking ID and a var to get User ID
 */
$dotenv->required(['TRACKING_ID', $userIdValueEnvVar]);

/*
 * Track Event
 */
try {
    $analytics = new Analytics();
    $analytics->setProtocolVersion('1')
        ->setTrackingId($trackingId)
        ->setClientId($userId)
        ->setHitType('event')
        ->setDocumentTitle($documentTitle)
        ->setEventCategory($eventCategory)
        ->setEventAction($eventAction)
        ->setEventLabel($eventLabel)
        ->sendEvent();
} catch (\Exception $e) {
    echo sprintf('Error occurred (%s): %s', $e->getCode(), $e->getMessage());
    exit(1);
}

exit(0);