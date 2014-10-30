<?php

if (!isset($_POST['function']))
    die("You must specify a function");
if (!function_exists($_POST['function']))
    die("Function not found");
else
    call_user_func($_POST['function']);

function getStatus()
{
    $output = array(
        'composer' => file_exists('composer.phar'),
        'composer_extracted' => file_exists('extracted'),
        'installer' => file_exists('installer.php'),
    );
    header("Content-Type: text/json; charset=utf-8");
    echo json_encode($output);
}

function downloadComposer()
{
    $installerURL = 'https://getcomposer.org/installer';
    $installerFile = 'installer.php';
    if (!file_exists($installerFile))
    {
        echo 'Downloading ' . $installerURL . PHP_EOL;
        flush();
        $ch = curl_init($installerURL);
        curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . '/cacert.pem');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_FILE, fopen($installerFile, 'w+'));
        if (curl_exec($ch))
            echo 'Success downloading ' . $installerURL . PHP_EOL;
        else
        {
            echo 'Error downloading ' . $installerURL . PHP_EOL;
            die();
        }
        flush();
    }
    echo 'Installer found : ' . $installerFile . PHP_EOL;
    echo 'Starting installation...' . PHP_EOL;
    flush();
    $argv = array();
    include $installerFile;
    flush();
}

function extractComposer()
{
    if (file_exists('composer.phar'))
    {
        echo 'Extracting composer.phar ...' . PHP_EOL;
        flush();
        $composer = new Phar('composer.phar');
        $composer->extractTo('extracted');
        echo 'Extraction complete.' . PHP_EOL;
    }
    else
        echo 'composer.phar does not exist';
}

function command()
{
    set_time_limit(-1);
    putenv('COMPOSER_HOME=' . __DIR__ . '/extracted/bin/composer');
    if (file_exists('extracted'))
    {
        require_once(__DIR__ . '/extracted/vendor/autoload.php');
        $input = new Symfony\Component\Console\Input\StringInput($_POST['command'].' -vvv -d '.$_POST['path']);
	$output = new Symfony\Component\Console\Output\StreamOutput(fopen('php://output','w'));
        $app = new Composer\Console\Application();
        $app->run($input,$output);
    }
}

?>
