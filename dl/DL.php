<?php
/**
 * DL.php
 * Created by PhpStorm.
 * User: sami
 * Date: 4/8/14
 * Time: 3:23 PM
 */

namespace dl;



class DL
{
    /** @var Catalog  */
    private $catalog;

    function __construct(Catalog $catalog)
    {
        $this->catalog = $catalog;
    }

    /**
     * @return Catalog
     */
    public function getCatalog()
    {
        return $this->catalog;
    }



}