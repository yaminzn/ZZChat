<?php

define("LANG", "en");
$_SESSION['lang'] = LANG;

/* Page d'accueil -- index.php */

define("INPUT_USERNAME_DESC", "Username");
define("INPUT_PASSWORD_DESC", "Password");

define("CHECKBOX_TEXT", "Remember me");
define("SIGN_IN_TEXT", "Sign in");
define("CREATE_ACC_TEXT", "Create my account :D");

define("ACCOUNT_CREATION", "Account creation");
define("SIGN_UP_TEXT", "Sign up");


define("ACCOUNT_CREATION_SUCCESS", "Your account has been created.");

/* Errors */

define("ERR_WRONG_LOGIN", "<strong>Error</strong>, wrong username/password.");
define("ERR_USERNAME_TAKEN", "<strong>Error</strong>, username already taken.");
define("ERR_UNKNOWN", "<strong>Unknown Error</strong><br/>Please try again later.");


/*  Chat.php */
define("CHAT_PLACEHOLDER", "Type your message here");
define("SEND_BUTTON", "Send");

define("MENU_SETTINGS", "Settings");
define("MENU_LOG_OUT", "Log Out");

define("MENU_CHANNELS", "Channels");
define("CHANNEL_RESTRICTED", "Restricted");

define("HELP_EMOTES", "Emotes");
define("HELP_COMMANDS", "Chat Commands");
define("HELP_SHORTCUTS", "Shortcuts");

define("CHAN_SETTINGS_ADD", "Add");
define("CHAN_SETTINGS_KICK", "Kick");
define("CHAN_SETTINGS_RN", "Rename Channel");
define("CHAN_SETTINGS_CHANGE_DESC", "Change description");
define("CHAN_SETTINGS_QUIT", "Leave");

/* Settings */
define("SETTINGS_HOME", "General");
define("SETTINGS_PW", "Password");
define("SETTINGS_LANG", "Language");


?>
