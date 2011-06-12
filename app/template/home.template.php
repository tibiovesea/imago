<html>
    <head>
        <link href="./css/styling.css" rel="stylesheet" type="text/css">
        <title></title>
    </head>
    <body>
        <header>
            <div id='breadcrumbs'></div>
            <div id='tagcloud'></div>
            <div id='pagination'></div>
        </header>
        <div id="notice"></div>
        <div id="gallery"></div>
        <div id="comment"></div>
    </body>

<?php
    $templateFiles = array(
        '/template/breadcrumbs.template.php',
        '/template/tagcloud.template.php',
        '/template/tag.template.php',
        '/template/pagination.template.php',
        '/template/picture.list.template.php',
        '/template/picture.single.template.php',
        '/template/comment.list.template.php',
        '/template/comment.form.template.php',
        '/template/upload.template.php'
    );
    foreach($templateFiles as $file) {
        require_once($appDir . $file);
    }
?>

<?php
    $jsFiles = array(
        '/js/lib/json2.js',
        '/js/lib/jquery-1.6.1.min.js',
        '/js/lib/jquery.dotimeout.js',
        '/js/lib/underscore-min.js',
        '/js/lib/backbone-min.js',
        '/js/lib/underscore.string-min.js',

        '/js/application.js',

        '/js/model/picture.js',
        '/js/model/comment.js',
        '/js/model/tagcloud.js',
        '/js/model/breadcrumbs.js',

        '/js/collection/picture.js',
        '/js/collection/comment.js',
        '/js/collection/tagcloud.js',
        '/js/collection/breadcrumbs.js',

        '/js/controller/picture.js',
        '/js/controller/picture.upload.js',
        '/js/controller/header.js',
        '/js/controller/tagcloud.js',
        '/js/controller/breadcrumbs.js',

        '/js/view/picture.single.js',
        '/js/view/picture.list.js',
        '/js/view/picture.upload.js',
        '/js/view/pagination.js',
        '/js/view/comment.list.js',
        '/js/view/header.js',
        '/js/view/tagcloud.js',
        '/js/view/breadcrumbs.js',
        '/js/view/notice.js',
        '/js/view/error.js'
    );
    foreach($jsFiles as $file) {
        echo '<script type="text/javascript" src=".' . $file . '"></script>';
    }
?>
</html>