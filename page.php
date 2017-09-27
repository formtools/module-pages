<?php

// TODO this isn't compatible with Submission Accounts yet

require("../../global/library.php");

use FormTools\Errors;
use FormTools\General;
use FormTools\Modules;
use FormTools\Sessions;
use FormTools\Pages;

// this just checks that SOMEONE's logged in - even someone via the Submission Accounts module
$module = Modules::initModulePage("client");

$request = array_merge($_POST, $_GET);
$page_id = $request["id"];
$page_info = $module->getPage($page_id);

// check permissions! The above code handles booting a user out if they're not logged in,
// so the only case we're worried about
$account_type = Sessions::get("account.account_type");
$account_id   = Sessions::get("account.account_id");

$has_permission = true;
if ($account_type == "client") {
    if ($page_info["access_type"] == "admin") {
        $has_permission = false;
    }
    if ($page_info["access_type"] == "private") {
        if (in_array($account_id, $page_info["clients"])) {
            $has_permission = false;
        }
    }
}

if (!$has_permission) {
    Errors::handleError("Sorry, you do not have permissions to see this page.");
    exit;
}

$content = $page_info["content"];
switch ($page_info["content_type"]) {
    case "php":
        ob_start();
        eval($page_info["content"]);
        $content = ob_get_contents();
        ob_end_clean();
        break;
    case "smarty":
        $content = General::evalSmartyString($page_info["content"]);
        break;
}

$L = $module->getLangStrings();

$page_vars = array(
    "page"         => "custom_page",
    "page_id"      => $page_id,
    "phrase_edit_page" => $L["phrase_edit_page"],
    "account_type" => $account_type,
    "page_url"     => Pages::getPageUrl("custom_page"),
    "head_title"   => "{$L["word_page"]} - {$page_info["heading"]}",
    "page_info"    => $page_info,
    "content"      => $content
);

$module->displayPage("../../modules/pages/templates/page.tpl", $page_vars);
