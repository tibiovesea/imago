<?php
    /* === DB SETTINGS === */
    //-----------------------------------------------------------------
    if($_SERVER['HTTP_HOST'] == 'localhost')
    {
        define('DB_HOST', '127.0.0.1');
    } else {
        define('DB_HOST', '<YOUR DB HOST HERE>');
    }
    define('DB_NAME', '<YOUR DB NAME HERE>');
    define('DB_USER', '<YOUR DB USERNAME HERE>');
    define('DB_PASS', '<YOUR DB PASSWORD HERE>');

    /* === GALLERY SETTINGS === */
    $config = array(
        'galleryBase'                   => '/gallery',
        'pageSize'                      => 30,
        'singleImageLongEdgeMax'        => 800,
        'thumbBase'                     => '/thumbs',
        'thumbSuffix'                   => '_t',
        'allowedImageType'              => array('jpg','jpeg','gif','png')
    );
?>