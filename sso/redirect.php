<?php
session_start();
//echo '<pre>'; print_r($_SESSION); echo '<pre>'; exit();
if(isset($_SESSION['redirect']) && isset($_SESSION['logout'])){
    echo 'ok<br><pre>';print_r($_SESSION);
    //header('location:'.$_SESSION['redirect'].'?state='.$_SESSION['oauth2state']);
} else
    print_r($_SESSION);