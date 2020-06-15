<?php

// activation du système d'autoloading de Composer
require __DIR__.'/../vendor/autoload.php';

// instanciation du chargeur de templates
$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../templates');

// instanciation du moteur de template
$twig = new \Twig\Environment($loader, [
    // activation du mode debug
    'debug' => true,
    // activation du mode de variables strictes
    'strict_variables' => true,
]);

// chargement de l'extension Twig_Extension_Debug
$twig->addExtension(new \Twig\Extension\DebugExtension());

$formData = [
    'login' => '',
    'password'  => '',
];

if ($_POST) {
    $errors = [];
    $messages = [];

    if (isset($_POST['login'])) {
        $formData['login'] = $_POST['login'];
    }

    if (isset($_POST['password'])) {
        $formData['password'] = $_POST['password'];
    }
    
    if (!isset($_POST['login']) || empty($_POST['login'])) {
        $errors['login'] = true;
        $messages['login'] = "Please enter your login";
    } elseif (strlen($_POST['login']) < 4) {
        $errors['login'] = true;
        $messages['login'] = "The login must be at least 4 characters long";
    } elseif (strlen($_POST['login']) > 100) {
        $errors['login'] = true;
        $messages['login'] = "The login must be at most 100 characters long";
    } elseif (($_POST['login']) != "toto") {
        $errors['login'] = true;
        $messages['login'] = "Please enter a valid login";
    }


    if (!isset($_POST['password']) || empty($_POST['password'])) {
        $errors['password'] = true;
        $messages['password'] = "Please enter your password";
    } elseif (strlen($_POST['password']) < 4) {
        $errors['password'] = true;
        $messages['password'] = "The password must be at least 4 characters long";
    } elseif (strlen($_POST['password']) > 100) {
        $errors['password'] = true;
        $messages['password'] = "The password must be at most 100 characters long";
    } elseif (($_POST['password']) != "12345678") {
        $errors['password'] = true;
        $messages['password'] = "Incorrect password";
    }

    else {
        $url = 'private-page.php';
        header("Location: {$url}", true, 302);
        exit();
    }

   
}

// affichage du rendu d'un template
echo $twig->render('login.html.twig', [
    // transmission de données au template
    'errors' => $errors,
    'messages' => $messages,
    'formData' => $formData,
]);