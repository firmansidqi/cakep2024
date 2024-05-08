<?php
require 'vendor/autoload.php';
session_start();

$_SESSION['url'] = $_SERVER['HTTP_REFERER'];

$provider = new JKD\SSO\Client\Provider\Keycloak([
    'authServerUrl'         => 'https://sso.bps.go.id',
    'realm'                 => 'pegawai-bps',
    'clientId'              => '13300-evita-4ed',
    'clientSecret'          => 'ef75e3c8-88d8-4c57-a2a7-7732a924144f',
    'redirectUri'           => 'https://webapps.bps.go.id/jateng/evita/sso/redirect.php?url='.$_SERVER['HTTP_REFERER'],
]);

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
        $_SESSION['code'] = $token->getToken();
    } catch (Exception $e) {
        exit('Failed to get access token: '.$e->getMessage());
    }

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the user's details
        //$user = $provider->getResourceOwner($token);
        // Use these details to create a new profile
        //printf('Hello %s!\n<br>', $user->getName());
        echo $token->getToken();

        
//        header('location:'.$_SERVER['HTTP_REFERER'].'?code='.$token->getToken());
    } catch (Exception $e) {
        exit('Failed to get resource owner: '.$e->getMessage());
    }

    // Use this to interact with an API on the users behalf
    //echo $token->getToken();
}
