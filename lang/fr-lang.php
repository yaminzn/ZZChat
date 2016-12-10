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
define("CHANNEL_CREATE", "Créer salon de discussion");

define("NAME", "Nom");
define("DESC", "Description");
define("CREATE", "Créer");

define("HELP_EMOTES", "Emoticônes");
define("HELP_COMMANDS", "Commandes du chat");
define("HELP_SHORTCUTS", "Raccourcis");

define("CHAN_SETTINGS_ADD", "Ajouter");
define("CHAN_SETTINGS_KICK", "Exclure");
define("CHAN_SETTINGS_RN", "Renommer canal");
define("CHAN_SETTINGS_CHANGE_DESC", "Changer description");
define("CHAN_SETTINGS_QUIT", "Quitter");
define("CHAN_LEAVE_CONFIRM", "Etes vous sûr de vouloir quitter ?");

define("MSG_LOADING", "Chargement");
define("MSG_ROOMNAME", "Nom du salon");
define("MSG_CHAN_DESC_INFO", "Description du salon");
define("MSG_USER_LIST", "Utilisateurs");

/* Sous-menus */
define("CONTENT_COMMANDS_INFO", "Entrez !commands pour voir la liste des commandes");
define("CONTENT_SHORT_INFO", "Dans la zone de texte, utilisez les flèches Haut et Bas pour naviguez dans vos précédents messages.");

define("KICK_TITLE", "Bannir des personnes du salon");

define("ADD_TITLE", "Ajouter Utilisateurs");

define("SEARCH_INFO", "Entrez le nom d'utilisateur");

define("PREV", "Actuel");
define("NEWW", "Nouveau");

/* Settings */
define("SETTINGS_HOME", "Général");
define("SETTINGS_PW", "Mot de passe");
define("SETTINGS_LANG", "Langue");

define("BTN_SAVE", "Sauver");
define("BTN_CONFIRM", "Confirmer");
define("BTN_CANCEL", "Annuler");

define("SET_COLOR_MSG", "Couleur utilisateur");

define("SET_PW_TITLE", "Changer mot de passe");
define("SET_PW_PREV", "Mot de passe précédent");
define("SET_PW_NEW", "Nouveau mot de passe");
define("SET_PW_VERIFY", "Vérifier mot de passe");
define("SET_PW_VALID", "Valider le changement");

define("SET_LANG_TITLE", "Choisir la langue");
define("SET_LANG_EN", "Anglais");
define("SET_LANG_FR", "Français");

/* EMOTES */
define("GO", "Lancer !");
define("GIF_DESC", "Hey, ça te dit des gifs pas cher ?");

define("EMOTE_GLOBAL", "Global");
define("EMOTE_BTTV", "BTTV");
define("EMOTE_CUSTOM", "Perso");

/* File */
define("FILE_ADD", "Sélectionner fichier");
define("FILE_UPLOAD", "Envoyer");

?>
