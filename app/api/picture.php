<?php

require_once($appDir . '/class/Gallery.class.php');
require_once($appDir . '/class/Comment.class.php');

function doGet($parameters) {
    $return = '';

    try {

        $gallery = new Gallery(DB_HOST, DB_NAME, DB_USER, DB_PASS);
        $comment = new Comment(DB_HOST, DB_NAME, DB_USER, DB_PASS);

        switch($parameters['action']){
            case 'show':
                $return = $gallery->fetchOnePicture($parameters['uniq']);
                break;
            case 'comment':
                //TODO: move to COMMENTS class
                $return = $comment->fetchCommentsByTarget($parameters['uniq']);
                break;
            case 'list':
                $return = $gallery->fetchPictures($parameters['page'], $parameters['pageSize']);
                break;
            case 'listByTag':
                $return = $gallery->fetchPicturesByTag($parameters['tag'], $parameters['page'], $parameters['pageSize']);
                break;
            case 'tag':
                //TODO: move to TAGS class
                $return = $gallery->fetchPictureTags();
                break;
            default:
                Failure::fail(500);
                break;
        }
    }catch (ImageNotFoundException $e){
        Failure::fail(404, $e->getMessage());
    }catch (IllegalArgumentException $e) {
        Failure::fail(412, $e->getMessage());
    }catch (PDOException $e) {
        Failure::fail(500, $e->getMessage());
    }catch (Exception $e) {
        Failure::fail(404, $e->getMessage());
    }

    return json_encode($return);
}

function doPost($parameters) {
    $return = '';

    try {
        $comment = new Comment(DB_HOST, DB_NAME, DB_USER, DB_PASS);

        switch($parameters['action']) {
            case 'comment' :
                $return = $comment->newComment($parameters['POST']);
                break;
            default:
                Failure::fail(500);
                break;
        }
    } catch (EmptyPostFieldNotEmptyException $e) {
        Failure::fail(405);
    } catch (PostParameterEmptyException $e) {
        Failure::fail(412, $e->getMessage());
    }catch (PDOException $e) {
        Failure::fail(500, $e->getMessage());
    } catch (Exception $e) {
        Failure::fail(404, $e->getMessage());
    }

    return json_encode($return);
}

$out = '';

switch($parameters['method']) {
    case 'GET' :
        $out = doGet($parameters);
        break;
    case 'POST' :
        $out = doPost($parameters);
        break;
    default :
        Failure::fail(405);
        break;
}

header('Content-type: application/json');
echo $out;
?>