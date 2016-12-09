<?php

define("LANG", "fr");
$_SESSION['lang'] = LANG;

/* Page d'accueil -- index.php */

define("INPUT_USERNAME_DESC", "Nom d'utilisateur");
define("INPUT_PASSWORD_DESC", "Mot de passe");

define("CHECKBOX_TEXT", "Rester actif");
define("SIGN_IN_TEXT", "Se connecter");
define("CREATE_ACC_TEXT", "Créer un compte");

define("ACCOUNT_CREATION", "Création de compte");
define("SIGN_UP_TEXT", "S'enregistrer");


define("ACCOUNT_CREATION_SUCCESS", "Votre compte a bien été créé.");

/* Errors */

define("ERR_WRONG_LOGIN", "<strong>Erreur</strong> Mauvais nom d'utilisateur/mot de passe.");
define("ERR_USERNAME_TAKEN", "<strong>Erreur</strong> Nom d'utilisateur déjà utilisé.");
define("ERR_UNKNOWN", "<strong>Erreur inconnue</strong> <br/> Veuillez réessayer plus tard.");


/*  Chat.php */
define("CHAT_PLACEHOLDER", "Entrez votre message ici");
define("SEND_BUTTON", "Envoyer");

define("MENU_SETTINGS", "Options");
define("MENU_LOG_OUT", "Se déconnecter");

define("MENU_CHANNELS", "Canaux");
define("CHANNEL_RESTRICTED", "Privé");

define("HELP_EMOTES", "Emoticônes");
define("HELP_COMMANDS", "Commandes du chat");
define("HELP_SHORTCUTS", "Raccourcis");

define("CHAN_SETTINGS_ADD", "Ajouter");
define("CHAN_SETTINGS_KICK", "Exclure");
define("CHAN_SETTINGS_RN", "Renommer canal");
define("CHAN_SETTINGS_CHANGE_DESC", "Changer description");
define("CHAN_SETTINGS_QUIT", "Quitter");

?>