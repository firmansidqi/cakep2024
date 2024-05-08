<?php
require 'vendor/autoload.php';
require_once 'config.php';
require_once 'db.php';

session_start();

if(isset($_SERVER['HTTP_REFERER'])){
	$_SESSION['redirect'] = $_SERVER['HTTP_REFERER'];
	$_SESSION['session'] = isset($_GET['session'])? $_GET['session'] : null;
	$config['redirectUri'] .= 'redirect.php';//?url='.$_SERVER['HTTP_REFERER'];
}

$provider = new JKD\SSO\Client\Provider\Keycloak($config);

if (!isset($_GET['code'])) {
    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    exit('Invalid state, make sure HTTP sessions are enabled.');
} else {
    // Try to get an access token (using the authorization coe grant)
    try {
        $token = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);
    } catch (Exception $e) {
        exit('Failed to get access token: '.$e->getMessage());
    }

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the user's details
        $user = $provider->getResourceOwner($token);
	    $data = array(
	         "username" => $user->getUsername(),
	         "nama" => $user->getName(),
	         "niplama" => $user->getNip(),
	         "nipbaru" => $user->getNipBaru(),
	         "id_wilayah" => substr($user->getKodeOrganisasi(),0,4),
	         "id_unitkerja" => substr($user->getKodeOrganisasi(),7,4),
	         "eselon" => $user->getEselon(),
	         "golongan" => $user->getGolongan(),
	         "state" => $_SESSION['oauth2state'],
	         "token" => $token->getToken(),
	         "logout" => $provider->getLogoutUrl(),
	    );

	    $db = new SSOdb();
	    $db->insert($data);

	    //echo '<pre>'; print_r($data);
	    header('location: '.$config['redirectUri']);

    } catch (Exception $e) {
        exit('Failed to get resource owner: '.$e->getMessage());
    }

    // Use this to interact with an API on the users behalf
    // echo $token->getToken();
}
