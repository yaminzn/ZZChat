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
define("CHANNEL_CREATE", "Create channel");

define("NAME", "Name");
define("DESC", "Description");
define("CREATE", "Create");

define("HELP_EMOTES", "Emotes");
define("HELP_COMMANDS", "Chat Commands");
define("HELP_SHORTCUTS", "Shortcuts");

define("CHAN_SETTINGS_ADD", "Add");
define("CHAN_SETTINGS_KICK", "Kick");
define("CHAN_SETTINGS_RN", "Rename Channel");
define("CHAN_SETTINGS_CHANGE_DESC", "Change description");
define("CHAN_SETTINGS_QUIT", "Leave");
define("CHAN_LEAVE_CONFIRM", "Are you sure you want to leave ?");

define("MSG_LOADING", "Loading");
define("MSG_ROOMNAME", "Roomname");
define("MSG_CHAN_DESC_INFO", "Channel's description");
define("MSG_USER_LIST", "Users list");

/* Sous-menus */
define("CONTENT_COMMANDS_INFO", "!commands in chat to see all available commands");
define("CONTENT_SHORT_INFO", "While in the typing area, use up and down arrow keys to navigate through all your typed messages!");

define("KICK_TITLE", "Kick people");

define("ADD_TITLE", "Add users");

define("SEARCH_INFO", "Search for a user");

define("PREV", "Previous");
define("NEW", "New");

/* Settings */
define("SETTINGS_HOME", "General");
define("SETTINGS_PW", "Password");
define("SETTINGS_LANG", "Language");

define("BTN_SAVE", "Save");
define("BTN_CONFIRM", "Confirm");
define("BTN_CANCEL", "Cancel");

define("SET_COLOR_MSG", "Username color");

define("SET_PW_TITLE", "Change password");
define("SET_PW_PREV", "Previous password");
define("SET_PW_NEW", "New password");
define("SET_PW_VERIFY", "Verify password");
define("SET_PW_VALID", "Set password");

define("SET_LANG_TITLE", "Change Language");
define("SET_LANG_EN", "English");
define("SET_LANG_FR", "French");

/* EMOTES */
define("GO", "Go !");
define("GIF_DESC", "Pss, wanna buy some gifs ?");

define("EMOTE_GLOBAL", "Global");
define("EMOTE_BTTV", "BTTV");
define("EMOTE_CUSTOM", "Custom");

/* File */
define("FILE_ADD", "Add files");
define("FILE_UPLOAD", "Upload");

?>
