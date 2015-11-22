<?php
return array(
    'name'        => 'LinuxVer',
    'description' => 'Plugin per mostrare la versione più recente del kernel linux nelle email di Mautic',
    'author'      => 'Alessio Felicioni',
    'version'     => '0.1.0',

    'services'    => array(
        'events' => array(
            'plugin.linuxver.emailbundle.subscriber' => array(
                'class' => 'MauticPlugin\LinuxVerBundle\EventListener\EmailSubscriber'
            )
        )
    ),
);
