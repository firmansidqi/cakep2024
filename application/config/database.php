<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$active_group 				= 'default';
$active_record 				= TRUE;

//Perubahan April-Mei 2023
/*$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'bpsk7477_cakep6500';
$db['default']['password'] = 'bpsk7477_cakep6500';
$db['default']['database'] = 'bpsk7477_cakep';
$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;*/

$db['default'] = array(
    'dsn'       => '',
    'hostname'  => 'localhost',
    'username'  => 'root',
    'password'  => '',
    'database'  => 'cakep2024',
    'dbdriver'  => 'mysqli',
    'dbprefix'  => '',
    'pconnect'  => TRUE,
    'db_debug'  => TRUE,
    'cache_on'  => FALSE,
    'cachedir'  => '',
    'char_set'  => 'utf8',
    'dbcollat'  => 'utf8_general_ci',
    'swap_pre'  => '',
    'autoinit'  => TRUE,
    'stricton'  => FALSE,
    'failover'  => array(),
    'save_queries => TRUE,'
);

$db['db2'] = array(
    'dsn'       => '',
    'hostname'  => 'localhost',
    'username'  => 'root',
    'password'  => '',
    'database'  => 'cakep2024',
    'dbdriver'  => 'mysqli',
    'dbprefix'  => '',
    'pconnect'  => TRUE,
    'db_debug'  => TRUE,
    'cache_on'  => FALSE,
    'cachedir'  => '',
    'char_set'  => 'utf8',
    'dbcollat'  => 'utf8_general_ci',
    'swap_pre'  => '',
    'autoinit'  => TRUE,
    'stricton'  => FALSE,
    'failover'  => array(),
    'save_queries => TRUE,'
);

/* End of file database.php */
/* Location: ./application/config/database.php */