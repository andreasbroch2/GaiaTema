<?php
/**
* Template Name: Test
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/
get_header(); 

$current_user = wp_get_current_user();
echo $current_user->user_email;
?>