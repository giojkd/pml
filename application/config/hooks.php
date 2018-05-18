<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['post_controller_constructor'][] = array(
                                                'class' => 'LanguageLoader',
                                                'function' => 'language_set',
                                                'filename' => 'LanguageLoader.php',
                                                'filepath' => 'hooks'
                                            );

$hook['post_controller_constructor'][] = array(
                                'class'    => 'LanguageLoader',
                                'function' => 'language_load',
                                'filename' => 'LanguageLoader.php',
                                'filepath' => 'hooks',
                                'params'   => array()
                                );											
											
$hook['post_controller_constructor'][] = array(
                                'class'    => 'aclHook',
                                'function' => 'process_acl',
                                'filename' => 'aclHook.php',
                                'filepath' => 'hooks',
                                'params'   => array()
                                );		