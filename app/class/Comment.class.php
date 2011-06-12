<?php
class Comment {
    private $dbHandle;

    function __construct($dbHost, $dbName, $dbUser, $dbPass) {
        $this->dbHandle = new PDO('mysql:host=' . $dbHost . ';dbname=' . $dbName, $dbUser, $dbPass);
        $this->dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function newComment($postParameters) {
        if(!isset($postParameters['req']) || $postParameters['req'] !== '') {
            throw new EmptyPostFieldNotEmptyException();
        }
        if(trim($postParameters['name']) === '') {
            throw new PostParameterEmptyException('name must be provided');
        }
        if(trim($postParameters['comment']) === '') {
            throw new PostParameterEmptyException('comment must be provided');
        }
        if(trim($postParameters['target']) === '') {
            throw new PostParameterEmptyException('comment must have a target');
        }

        $query = sprintf('
            INSERT INTO `comments` (txtUniq, txtUniqTarget, txtName, txtComment, dttPosted)
            VALUES(:uniq, :target, :name, :comment, NOW())
        ');
        $uniq = $this->createUniq($postParameters);

        $statement = $this->dbHandle->prepare($query);
        $statement->bindParam(':uniq', $uniq, PDO::PARAM_STR);
        $statement->bindParam(':target', $postParameters['target'], PDO::PARAM_STR);
        $statement->bindParam(':name', $postParameters['name'], PDO::PARAM_STR);
        $statement->bindParam(':comment', $postParameters['comment'], PDO::PARAM_STR);
        $statement->execute();

        $result = $this->dbHandle->lastInsertId();
        $insertedComment = $this->fetchCommentByUniq($uniq);

        return $insertedComment;
    }

    function fetchCommentByUniq($uniq) {
        if(!$uniq) {
            throw new IllegalArgumentException('uniq must be set');
        }
        if(gettype($uniq) !== 'string') {
            throw new IllegalArgumentException('uniq must be of type string');
        }

        $query = sprintf('
            SELECT
                txtTitle as title, txtName as name, txtComment as comment, dttPosted as date,
                txtUniqTarget as target, txtUniq as id
            FROM `comments`
            WHERE txtUniq = :uniq
            ORDER BY dttPosted ASC
        ');

        $statement = $this->dbHandle->prepare($query);
        $statement->bindParam(':uniq', $uniq, PDO::PARAM_STR);
        $statement->execute();

        $comment = $statement->fetch(PDO::FETCH_ASSOC);

        return $comment;
    }

    function fetchCommentsByTarget($targetUniq) {
        if(!$targetUniq) {
            throw new IllegalArgumentException('uniq must be set');
        }
        if(gettype($targetUniq) !== 'string') {
            throw new IllegalArgumentException('uniq must be of type string');
        }

        $comments = array();

        $query = sprintf('
            SELECT
                txtTitle as title, txtName as name, txtComment as comment, dttPosted as date,
                txtUniqTarget as target, txtUniq as id
            FROM `comments`
            WHERE txtUniqTarget = :uniq
            ORDER BY dttPosted ASC
        ');

        $statement = $this->dbHandle->prepare($query);
        $statement->bindParam(':uniq', $targetUniq, PDO::PARAM_STR);
        $statement->execute();

        while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            array_push($comments, $row);
        }

        return $comments;
    }

    //TODO: move to utils class
    private function createUniq($seed = null) {
        $uniq = implode($seed) . microtime() . '';
        $uniq = hash('sha256', $uniq);

        $sliceStartIndex = rand(1, strlen($uniq) - 2);
        $uniq = substr($uniq, $sliceStartIndex, 8);

        return $uniq;
    }
}
?>