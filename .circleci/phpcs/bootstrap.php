<?php

use steevanb\PhpCodeSniffs\Steevanb\Sniffs\Uses\GroupUsesSniff;

GroupUsesSniff::addSymfonyPrefixes();

$myBootstrapPath = '/var/phpcs/.circleci/phpcs/my.bootstrap.php';
if (file_exists($myBootstrapPath)) {
    include $myBootstrapPath;
}
