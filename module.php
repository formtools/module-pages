<?php

/**
 * Module file: Pages
 *
 * This module lets you add custom pages to the Form Tools UI.
 */

$MODULE["author"]          = "Encore Web Studios";
$MODULE["author_email"]    = "formtools@encorewebstudios.com";
$MODULE["author_link"]     = "http://www.encorewebstudios.com";
$MODULE["version"]         = "1.0.0-beta-20081226";
$MODULE["date"]            = "2008-12-26";
$MODULE["origin_language"] = "en_us";
$MODULE["supports_ft_versions"] = "2.0.0";

// define the module navigation - the keys are keys defined in the language file. This lets
// the navigation - like everything else - be customized to the users language
$MODULE["nav"] = array(
  "word_pages"        => array("index.php", false),
  "phrase_add_page"   => array("add.php", false),
  "word_settings"     => array("settings.php", false)
    );