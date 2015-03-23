<?php
/**
 * Catalog.php
 * User: sami
 * Date: 23-Mar-15
 * Time: 6:50 PM
 */

namespace dl;


class Catalog {

    /** @var  IDB */
    private $db;

    function __construct(IDB $db)
    {
        $this->db = $db;
    }

    public function getFormatsCatalog()
    {
        $query = "
            select
                id, `name`
            from
                fontformat
            where
                char_length(coalesce(`folder`, '')) > 1
            order by
                `name`;
        ";

        $rs = $this->db->getRS($query);
        $res = array();

        foreach($rs as $format) {
            $res[$format['id']] = $format['name'];
        }

        return $res;
    }

    public function getFontsCatalog()
    {
        $query = '
            select
                f.id fontId, fg.id groupId, fg.`name` `groupName`, fw.`name` `weight`, highlight
            from
                font f
                inner join fontgroup fg on f.fontGroupId = fg.id
                inner join fontweight fw on f.fontWeightId = fw.id
            where
                f.hide=0
            order by
                fg.name,
                fw.ord, fw.name;
        ';

        $rs = $this->db->getRS($query);
        $res = array();

        foreach($rs as $font) {

            if(!isset($res[$font['groupId']])) {
                $res[$font['groupId']] = array(
                    'name' => $font['groupName'],
                    'highlight' => $font['highlight'],
                    'fonts' => array(),
                );
            }

            $res[$font['groupId']]['fonts'] []= array(
                'id' => $font['fontId'],
                'weight' => $font['weight'],
                'name' => $font['groupName'] . ' ' . $font['weight'],
            );
        }

        return $res;
    }
}