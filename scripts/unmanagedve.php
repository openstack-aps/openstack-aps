<?php

require "common.php";

class custom_counter {

    /**
     * @type("integer")
     * @title("Usage")
     */
    public $usage = 0;

    /**
     * @type("integer")
     * @title("Limit")
     */
    public $limit = 0;

}

/**
 * Class UnmanagedVe
 * @author("The Mamasu Agency")
 * @type("http://openstack.parallels.com/unmanagedve/1.3")
 * @implements("http://aps-standard.org/types/core/resource/1.0")
 */
class unmanagedve extends \APS\ResourceBase {

    /**
     * @link("http://openstack.parallels.com/organization")
     * @required
     */
    public $organization;

    /**
     * @link("http://openstack.parallels.com/image")
     * @required
     */
    public $image;

    /**
     * @link("http://openstack.parallels.com/ipassigned[]")
     */
    public $ipassigned;

    /**
     * @type("string")
     * @title("instance_id")
     */
    public $instance_id;

    /**
     * @type("string")
     * @title("name")
     */
    public $name;

    /**
     * @type("custom_counter")
     * @title("CPU")
     */
    public $cpu;

    /**
     * @type("custom_counter")
     * @title("Memory")
     */
    public $memory;

    /**
     * @type("custom_counter")
     * @title("Disk Size")
     */
    public $disk_size;

    /**
     * @type("custom_counter")
     * @title("Floating IP")
     */
    public $floating_ip;

    /**
     * @type("custom_counter")
     * @title("Traffic Out")
     */
    public $traffic_out;

    /**
     * @verb(GET)
     * @path("/start")
     * @return(string, text/json)
     */
    public function start() {
    
        $apsc = clone \APS\Request::getController();
        $organization = $apsc->getResource($this->organization->aps->id);
        $dc = $apsc->getResource($organization->dc->aps->id);
        try {

            $os = new OS($dc->apiurl, $dc->user, $dc->password);
            $action = "start";
            $os->serverActions($organization->tenant_id, $this->instance_id, $action);

            return json_encode(array("response" => "ok"));
        } catch (Exception $e) {

            $emsg = "Error " . $action . " server " . $this->instance_id . " : " . $e->getMessage();
            return json_encode(array("response" => $emsg));
        }
    }

    /**
     * @verb(GET)
     * @path("/stop")
     * @return(string, text/json)
     */
    public function stop() {

        $action = "stop";
        $apsc = clone \APS\Request::getController();
        $organization = $apsc->getResource($this->organization->aps->id);
        $dc = $apsc->getResource($organization->dc->aps->id);
        error_log($dc->apiurl . " ----  " . $dc->user . " ---- " . $dc->password . ' ---- ' . $organization->tenant_id);

        try {

            $os = new OS($dc->apiurl, $dc->user, $dc->password);

            $os->serverActions($organization->tenant_id, $this->instance_id, $action);

            return json_encode(array("response" => "ok"));
        } catch (Exception $e) {

            $emsg = "Error " . $action . " server " . $this->instance_id . " : " . $e->getMessage();
            return json_encode(array("response" => $emsg));
        }
    }

    /**
     * @verb(GET)
     * @path("/restart")
     * @return(string, text/json)
     */
    public function restart() {

        $action = "reboot";
        $apsc = clone \APS\Request::getController();

        $organization = $apsc->getResource($this->organization->aps->id);
        $dc = $apsc->getResource($organization->dc->aps->id);
        try {

            $os = new OS($dc->apiurl, $dc->user, $dc->password);

            $os->serverActions($organization->tenant_id, $this->instance_id, $action);

            return json_encode(array("response" => "ok"));
        } catch (Exception $e) {

            $emsg = "Error " . $action . " server " . $this->instance_id . " : " . $e->getMessage();
            return json_encode(array("response" => $emsg));
        }
    }

    /**
     * @verb(DELETE)
     * @path("/remove")
     * @return(string, text/json)
     */
    public function deleteinstance() {
        
    }

    /**
     * @verb(GET)
     * @path("/getdetails")
     * @return(string, text/json)
     */
    public function getInstanceDetails() {
        
    }

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
     * @path("/updateusage")
     * @return(string, text/json)
     */
    public function updateUsage() {
    	$apsc = clone \APS\Request::getController();
    	
    	$organization = $apsc->getResource($this->organization->aps->id);
    	$dc = $apsc->getResource($organization->dc->aps->id);
    	
    	
    	try{
    		
	    	$os = new OS($dc->apiurl, $dc->user, $dc->password);
	    	
	    	$query[] = array("field" => "project_id","op" => "eq","value" => $organization->tenant_id);
	    	$query[] = array("field" => "resource_id","op" => "eq","value" => $this->instance_id);
	    		
	    	$cpu = $os->getMeterStatisticsVM("vcpus", $query, array("resource_id"), null);
	        $memory = $os->getMeterStatisticsVM("memory", $query, array("resource_id"), null);
	        $disk = $os->getMeterStatisticsVM("disk.root.size", $query, array("resource_id"), null);
	        $floatingip = $os->getMeterStatisticsVM("ip.floating", $query, array("resource_id"), null);
	        $trafficout = $os->getMeterStatisticsVM("network.outgoing.bytes", $query, array("resource_id"), null);
          
	        return array(
	        	'cpu'=>$cpu,
	        	'memory'=>$memory,
	        	'disk' => $disk,
	        	'floatingip' => $floatingip,
	        	'trafficout' => $trafficout
	        );
          
    	}catch(Exception $e){
			return array (
					'cpu' => 0,
					'memory' => 0,
					'disk' => 0,
					'floatingip' => 0,
					'trafficout' => 0 
			);
    	}
    }

}
