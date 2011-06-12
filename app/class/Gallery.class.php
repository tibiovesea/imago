<?php

class Gallery {
    private $dbHandle;
    private $imageQuery;
    public $longEdgeMax = 800;

    function __construct($dbHost, $dbName, $dbUser, $dbPass) {
        $this->dbHandle = new PDO('mysql:host=' . $dbHost . ';dbname=' . $dbName, $dbUser, $dbPass);
        $this->dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->imageQuery = sprintf('
            SELECT
                picture.intID as _id, picture.txtFileName as fileName,
                picture.dttDigitized as date, picture.txtPath as path,
                picture.txtThumbPath as thumbPath, picture.txtHash as hash,
                picture.txtUniq as id, picture.intOrder as orderNum,
                (SELECT count(*) FROM `comments` comment WHERE comment.txtUniqTarget = picture.txtUniq) AS numComments,
                (SELECT count(*) FROM `pictures`) as numPictures
            FROM `pictures` picture
            WHERE picture.intOrder IS NOT NULL
        ');
    }

    function fetchPictures($page, $pageSize) {
        $query = $this->imageQuery . 'ORDER BY picture.intOrder DESC LIMIT :offset, :size';
        $offset = $page * $pageSize;
        $pictures = array();

        $statement = $this->dbHandle->prepare($query);
        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
        $statement->bindParam(':size', $pageSize, PDO::PARAM_INT);
        $statement->execute();

        $total = 0;
        while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $total = $row['numPictures'];
            array_push($pictures, $row);
        }

        $return = array(
            'picture' => $pictures,
            'page' => (int)$page,
            'pageSize' => (int)$pageSize,
            'pageTotal' => ceil($total/$pageSize)
        );

        return $return;
    }

    function fetchPicturesByTag($tag, $page, $pageSize) {
        if(!$tag) {
            throw new IllegalArgumentException('tag must be set');
        }

        $query = sprintf('
            SELECT
                picture.intID as _id, picture.txtFileName as fileName,
                picture.dttDigitized as date, picture.txtPath as path,
                picture.txtThumbPath as thumbPath, picture.txtHash as hash,
                picture.txtUniq as id, picture.intOrder as orderNum,
                tag.txtTag as tag,
                (SELECT count(*) FROM `comments` comment WHERE comment.txtUniqTarget = picture.txtUniq) AS numComments,
                (SELECT count(*) FROM `pictures` p1 LEFT OUTER JOIN `tags` t1 ON p1.txtUniq = t1.txtUniqTarget WHERE t1.txtTag = :tag) as numPictures
            FROM `pictures` picture
                LEFT OUTER JOIN `tags` tag ON picture.txtUniq = tag.txtUniqTarget
            WHERE picture.intOrder IS NOT NULL
                AND tag.txtTag = :tag
            ORDER BY picture.intOrder DESC LIMIT :offset, :size
        ');
        $offset = $page * $pageSize;
        $pictures = array();

        $statement = $this->dbHandle->prepare($query);
        $statement->bindParam(':tag', $tag, PDO::PARAM_STR);
        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
        $statement->bindParam(':size', $pageSize, PDO::PARAM_INT);
        $statement->execute();

        $total = 0;
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $total = $row['numPictures'];
            array_push($pictures, $row);
        }

        $return = array(
            'picture' => $pictures,
            'page' => (int)$page,
            'pageSize' => (int)$pageSize,
            'pageTotal' => ceil($total/$pageSize)
        );

        return $return;
    }

    function fetchOnePicture($uniq) {
        if(!$uniq) {
            throw new IllegalArgumentException('uniq must be set');
        }
        if(gettype($uniq) !== 'string') {
            throw new IllegalArgumentException('uniq must be of type string');
        }
        
        $query = $this->imageQuery . 'AND picture.txtUniq = :uniq';
        $picture = null;

        $statement = $this->dbHandle->prepare($query);
        $statement->bindParam(':uniq', $uniq, PDO::PARAM_STR);
        $statement->execute();

        if($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $picture = $row;
            $widthAndHeight = $this->getWidthAndHeight($picture['path'], $this->longEdgeMax);
            $picture['width'] = $widthAndHeight['width'];
            $picture['height'] = $widthAndHeight['height'];
        } else {
            throw new ImageNotFoundException('cannot find picture ' . $uniq);
        }

        return $picture;
    }

    private function getWidthAndHeight($path, $longEdgeMax) {
        if(!$path) {
            throw new IllegalArgumentException('image path must be set');
        }
        list($width, $height, $type, $attr) = getimagesize($path);
        $ratio = 0.0;

        //get the correct ratio of the picture
        if($width && $height)
        {
            if($width < $height)
            {
                $ratio = $width/$height;
                $height = $longEdgeMax;
                $width = $longEdgeMax * $ratio;
            } else {
                $ratio = $height/$width;
                $width = $longEdgeMax;
                $height = $longEdgeMax * $ratio;
            }
        }

        return array(
            'width' => (int)$width,
            'height' => (int)$height
        );
    }

    function fetchPictureTags() {
        $tags = array();

        $query = sprintf('
            SELECT
                tags.intID as _id, tags.txtUniq as id, tags.txtUniqTarget as target,
                tags.txtTag as tag, tags.txtTagText as tagText
            FROM tags tags
            INNER JOIN pictures pics ON tags.txtUniqTarget = pics.txtUniq
            GROUP BY tags.txtTag
            ORDER BY tags.txtTag ASC
        ');

        $statement = $this->dbHandle->prepare($query);
        $statement->execute();

        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            array_push($tags, $row);
        }

        return $tags;
    }
}

?>