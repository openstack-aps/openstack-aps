<?php

require "common.php";

/**
 * Class APP
 * @author("The Mamasu Agency")
 * @type("http://openstack.parallels.com/app/1.4")
 * @implements("http://aps-standard.org/types/core/application/1.0")
 * */
class app extends \APS\ResourceBase {

    /**
     * @link("http://openstack.parallels.com/dc/2.1[]")
     */
    public $dc;

    /**
     * @link("http://openstack.parallels.com/organization[]")
     */
    public $organization;

    public function provision() {
        
    }

    public function configure($new) {
        
    }

    public function unprovision() {
        
    }

    public function upgrade() {
        
    }

    /**
     * @verb(GET)
     * @path("/dcconnectiontest")
     * @param(string, query)
     * @return(string,text/json) 
     */
    public function dcConnectionTest($data) {
        $decodedData = json_decode(base64_decode($data));
        $object = $decodedData;

        //While editing, password cannot be retrieved from UI so we need to get 
        //full DC object from here before to stablish connection.
        if (!isset($object->password) && isset($object->aps->id)) {
            $apsc = clone \APS\Request::getController();
            $object = $apsc->getResource($object->aps->id);
        }
        $os = new OS($object->apiurl, $object->user, $object->password);
        return json_encode($os->isReachable());
    }

}
