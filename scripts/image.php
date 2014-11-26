<?php

require "common.php";

/**
 * Class Image
 * @author("The Mamasu Agency")
 * @type("http://openstack.parallels.com/image/1.4")
 * @implements("http://aps-standard.org/types/core/resource/1.0")
 */
class image extends \APS\ResourceBase {

    /**
     * @link("http://openstack.parallels.com/dc/2.1")
     * @required
     */
    public $dc;

    /**
     * @link("http://openstack.parallels.com/unmanagedve[]")
     */
    public $unmanagedve;

    /**
     * @type("string")
     * @title("Id")
     */
    public $id;

    /**
     * @type("string")
     * @title("Name")
     */
    public $name;

    /**
     * @type("string")
     * @title("OS")
     */
    public $os;

    /**
     * @type("string")
     * @title("Image")
     */
    public $image;

    /**
     * @type("string")
     * @title("Usage")
     */
    public $usage = 0;

    /**
     * @type("string")
     * @title("ISO Status")
     */
    public $isostatus;
    
    /**
     * @type("string")
     * @title("Status")
     */
    public $status;

    public function provision() {
        $apsc = \APS\Request::getController();
        $dc = $apsc->getResource($this->dc->aps->id);

        $os = new OS($dc->apiurl, $dc->user, $dc->password);
        
        $image = $os->getImageDetails($this->id);

        
        $this->image = $image->file;
        $this->usage = 0;
        $this->isostatus = $image->status;
    }

    /**
     * @verb(PUT)
     * @path("/updateimage")
     * @return(string, text/json)
     */
    public function updateImage() {
        $apsc = \APS\Request::getController();
        $dc = $apsc->getResource($this->dc->aps->id);

        $os = new OS($dc->apiurl, $dc->user, $dc->password);
        $image = $os->getImageDetails($this->id);

        $this->isostatus = $image->status;
        return json_encode($this);
    }

    public function configure($new) {
        
    }

    public function unprovision() {
        
    }

    public function upgrade() {
        
    }

}
