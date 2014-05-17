<?php

/**
 * Module file: Pages
 *
 * This module lets you add custom pages to the Form Tools UI.
 */

$MODULE["author"]          = "Encore Web Studios";
$MODULE["author_email"]    = "formtools@encorewebstudios.com";
$MODULE["author_link"]     = "http://www.encorewebstudios.com";
$MODULE["version"]         = "1.1.2";
$MODULE["date"]            = "2010-09-11";
$MODULE["origin_language"] = "en_us";
$MODULE["supports_ft_versions"] = "2.0.3";


// define the module navigation - the keys are keys defined in the language file. This lets
// the navigation - like everything else - be customized to the users language
$MODULE["nav"] = array(
  "word_pages"      => array("index.php", false),
  "phrase_add_page" => array("add.php", true),
  "word_settings"   => array("settings.php", false),
  "word_help"       => array("help.php", false)
    );