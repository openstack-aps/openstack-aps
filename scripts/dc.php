<?php

require "common.php";

class slot_details {

    /**
     * @type("integer")
     * @title("Slot id")
     */
    public $id = 0;

    /**
     * @type("string")
     * @title("Slot name")
     */
    public $name = "";
    
    /**
     * @type("string[]")
     * @title("Images")
     */
    public $images = array();
    
    /**
     * @type("string")
     * @title("Images name")
     */
    public $imagesDisplayName = "";
    
    

}

/**
 * Class DC
 * @author("The Mamasu Agency")
 * @type("http://openstack.parallels.com/dc/2.1")
 * @implements("http://aps-standard.org/types/core/resource/1.0")
 */
class dc extends \APS\ResourceBase {

    /**
     * @link("http://openstack.parallels.com/app")
     * @required
     */
    public $app;

    /**
     * @link("http://openstack.parallels.com/organization[]")
     */
    public $organization;

    /**
     * @link("http://openstack.parallels.com/profile[]")
     */
    public $profile;

    /**
     * @link("http://openstack.parallels.com/image[]")
     */
    public $image;

    /**
     * @link("http://openstack.parallels.com/ippool[]")
     */
    public $ippool;

    /**
     * @type("string")
     * @title("API Connection")
     * @description("API URL")
     */
    public $apiurl;

    /**
     * @type("string")
     * @title("Tenant name")
     */
    public $name;

    /**
     * @type("string")
     * @title("User name")
     */
    public $user;

    /**
     * @type("string")
     * @title("Password")
     * @encrypted
     */
    public $password;

    /**
     * @type("string")
     * @title("Proxy")
     */
    public $proxy;

    /**
     * @type("string")
     * @title("API Tenant ID")
     */
    public $api_tenant_id;

    /**
     * @type("integer")
     * @title("Num Organizations")
     */
    public $numorganizations = 0;

    /**
     * @type("integer")
     * @title("Num Profiles")
     */
    public $numprofiles = 0;

    /**
     * @type("integer")
     * @title("Num Images")
     */
    public $numimages = 0;

    /**
     * @type("integer")
     * @title("Num IPPools")
     */
    public $numippools = 0;

    /**
     * @type("string")
     * @title("Admin role")
     */
    public $admin_role = "";

    /**
     * @type("string")
     * @title("Member role")
     */
    public $member_role = "";



    /**
     * @type("slot_details[]")
     * @title("Slots list")
     */
    public $listslots;
    
    
    
    

    public function provision() {
        logme("provision");
        $subDCavailable = new \APS\EventSubscription(\APS\EventSubscription::Available, "onDCavailable");
        $subDCavailable->source = $this;

        $apsc = \APS\Request::getController();
        $apsc->subscribe($this, $subDCavailable);
    }

    public function configure($new) {
        logme("configure");
        if ($this->apiurl !== $new->apiurl) {
            throw new Exception("API Url cannot be changed");
        }
//        if ($this->user !== $new->user) {
//            throw new Exception("User cannot be changed");
//        }
//        if ($this->password !== $new->password) {
//            throw new Exception("Password cannot be changed");
//        }
        $new->listslots = array();
        
        $slot = new slot_details();
        $slot->id = "";
        $slot->name = "";
        $slot->images = array("123");
        $slot->imagesDisplayName = "123";
        
        $new->listslots[] = $slot;
        $apsc = \APS\Request::getController();
        $apsc->updateResource($new);
    }

    public function unprovision() {

    }

    public function upgrade() {
    	
    	$apsc = \APS\Request::getController();
    	$this->listslots = array();
    	$apsc->updateResource($this);
    	
    }

    function profileLink() {
        $apsc = \APS\Request::getController();

        $count = json_decode($apsc->getIo()->sendRequest(\APS\Proto::GET, "/aps/2/resources/" . $this->aps->id . "/profile"));
        $this->numprofiles = count($count);

        $apsc->updateResource($this);
    }

    function profileUnlink() {
        $apsc = \APS\Request::getController();
        $count = json_decode($apsc->getIo()->sendRequest(\APS\Proto::GET, "/aps/2/resources/" . $this->aps->id . "/profile"));
        $this->numprofiles = count($count);
        $apsc->updateResource($this);
    }

    function imageLink() {
        $apsc = \APS\Request::getController();
        $count = json_decode($apsc->getIo()->sendRequest(\APS\Proto::GET, "/aps/2/resources/" . $this->aps->id . "/image"));
        $this->numimages = count($count);
        $apsc->updateResource($this);
    }

    function imageUnlink() {
        $apsc = \APS\Request::getController();
        $count = json_decode($apsc->getIo()->sendRequest(\APS\Proto::GET, "/aps/2/resources/" . $this->aps->id . "/image"));
        $this->numimages = count($count);
        $apsc->updateResource($this);
    }

    function ippoolLink() {
        $apsc = \APS\Request::getController();
        $count = json_decode($apsc->getIo()->sendRequest(\APS\Proto::GET, "/aps/2/resources/" . $this->aps->id . "/ippool"));
        $this->numippools = count($count);
        $apsc->updateResource($this);
    }

    function ippoolUnlink() {
        $apsc = \APS\Request::getController();
        $count = json_decode($apsc->getIo()->sendRequest(\APS\Proto::GET, "/aps/2/resources/" . $this->aps->id . "/ippool"));
        $this->numippools = count($count);
        $apsc->updateResource($this);
    }

    function organizationLink() {
        $apsc = \APS\Request::getController();
        $count = json_decode($apsc->getIo()->sendRequest(\APS\Proto::GET, "/aps/2/resources/" . $this->aps->id . "/organization"));
        $this->numorganizations = count($count);
        $apsc->updateResource($this);
    }

    function organizationUnlink() {
        $apsc = \APS\Request::getController();
        $count = json_decode($apsc->getIo()->sendRequest(\APS\Proto::GET, "/aps/2/resources/" . $this->aps->id . "/organization"));
        $this->numorganizations = count($count);
        $apsc->updateResource($this);
    }

    /**
     * @verb(GET)
     * @path("/updatedatacenter")
     * @return(string, text/json)
     */
    public function updateDatacenter() {
        //logme("updateDatacenter", $this);

        $this->synchIpPools();

        $apsc = \APS\Request::getController();
        $count = json_decode($apsc->getIo()->sendRequest(\APS\Proto::GET, "/aps/2/resources/" . $this->aps->id . "/organization"));
        $this->numorganizations = count($count);

        $apsc->updateResource($this);

        return json_encode($this);
    }

    private function removeDuplicities() {
        logme("RemoveDuplicities");
        //Remove duplicities
        $apsc = \APS\Request::getController()->impersonate($this->app->aps->id);
        $pools = json_decode($apsc->getIo()->sendRequest(\APS\Proto::GET, "/aps/2/resources/" . $this->aps->id . "/ippool"));
        for ($i = 0; $i < count($pools); $i++) {
            for ($j = 0; $j < count($pools); $j++) {
                if (($i != $j) && ($pools[$i]->id == $pools[$j]->id)) {
                    try {
                        logme("Remove Pool => " . print_r($pools[$i], true));
                        $apsc->getIo()->sendRequest(\APS\Proto::DELETE, "/aps/2/resources/" . $pools[$i]->aps->id);
                    } catch (Exception $e) {
                        try {
                            logme("Remove Pool => " . print_r($pools[$j], true));
                            $apsc->getIo()->sendRequest(\APS\Proto::DELETE, "/aps/2/resources/" . $pools[$j]->aps->id);
                        } catch (Exception $e) {
                            
                        }
                    }
                }
            }
        }
    }

    private function synchIpPools() {
        logme("synchIpPools");
        $apsc = \APS\Request::getController()->impersonate($this->app->aps->id);
        $dc = $apsc->getResource($this->aps->id);
        $previousPools = json_decode($apsc->getIo()->sendRequest(\APS\Proto::GET, "/aps/2/resources/" . $dc->aps->id . "/ippool"));
        $nextsPools = array();

        $os = new OS($this->apiurl, $this->user, $this->password);
        $subnets = $os->getExternalSubnets();

        logme("PREVIOUS POOLS", $previousPools);
        logme("CURRENT POOLS", $subnets);


        for ($i = 0; $i < count($subnets); $i++) {
            //If subnet already exists in DC doesn't creates it
            $createIt = true;
            for ($j = 0; $j < count($previousPools); $j++) {
                if ($previousPools[$j]->id == $subnets[$i]->id) {
                    $createIt = false;
                }
            }
            if ($createIt) {
                $ippool = \APS\TypeLibrary::newResourceByTypeId("http://openstack.parallels.com/ippool/1.3");

                $ippool->id = $subnets[$i]->id;
                $ippool->name = $subnets[$i]->name;
                $ippool->cidr = $subnets[$i]->cidr;
                $ippool->allocation_pools = array();
                for ($j = 0; $j < count($subnets[$i]->allocation_pools); $j++) {
                    $allocPool = array(
                        "start" => $subnets[$i]->allocation_pools[$j]->start,
                        "end" => $subnets[$i]->allocation_pools[$j]->end
                    );
                    $ippool->allocation_pools[] = $allocPool;
                }
                $ippool->gateway_ip = $subnets[$i]->gateway_ip;
                $ippool->aps->link['dc'] = new \APS\Link($this, "dc", $ippool);

                $apsc->linkResource($this, "ippool", $ippool);
                $nextsPools[] = $ippool;
            }
        }

        //If subnet is not in subnets list retrieved from OS, will be tried to be erase it
        for ($j = 0; $j < count($previousPools); $j++) {

            $remove = true;
            for ($i = 0; $i < count($subnets); $i++) {
                if ($subnets[$i]->id == $previousPools[$j]->id) {
                    $remove = false;
                }
            }
            if ($remove) {
                try {
                    $remove_result = json_decode($apsc->getIo()->sendRequest(\APS\Proto::DELETE, "/aps/2/resources/" . $previousPools[$j]->aps->id));
                } catch (Exception $e) {
                    $ippool_change = $apsc->getResource($previousPools[$j]->aps->id);
                    $ippool_change->os_status = "disabled";
                    $apsc->updateResource($ippool_change);
                }
            }
        }

        $this->removeDuplicities();

        $finalIpPools = json_decode($apsc->getIo()->sendRequest(\APS\Proto::GET, "/aps/2/resources/" . $dc->aps->id . "/ippool"));
        $this->numippools = count($finalIpPools);
        $apsc->updateResource($this);
    }

    /**
     * @verb(GET)
     * @path("/listimages")
     * @return(string, text/json)
     */
    public function listImages() {
        logme("ListImages");
        $os = new OS($this->apiurl, $this->user, $this->password);
        try {
            $images = $os->listImages();
            logme("IMAGES", $images);
            $publicImages = array();
            foreach ($images->images as $image) {
                if (($image->visibility == "public") && ($image->status == "active")) {
                    $publicImages[] = $image;
                }
            }
            return json_encode($publicImages);
        } catch (Exception $e) {
            return json_encode($e);
        }
    }

    /**
     * @verb(GET)
     * @path("/meterallstatistics")
     * @param(string, query)
     * @return(string,text/json)
     */
    public function MeterAllStatistics() {
        $os = new OS($this->apiurl, $this->user, $this->password);
        return json_encode($os->getAllUsages());
    }

    /**
     * @verb(GET)
     * @path("/gettotalipstraffic")
     * @return(string, text/json)
     */
    public function get_total_ips_traffic() {
        $total_ips = 0;
        $total_traffic_out = 0;

        $apsc = \APS\Request::getController();
        $organizations = json_decode($apsc->getIo()->sendRequest(\APS\Proto::GET, "/aps/2/resources/" . $this->aps->id . "/organization"));

        for ($i = 0; $i < count($organizations); ++$i) {
            if ($organizations[$i]->cpu_counter->limit == -1 AND $organizations[$i]->memory_counter->limit == -1 AND $organizations[$i]->disk_size_counter->limit == -1 AND $organizations[$i]->ips_counter->limit == -1 AND $organizations[$i]->traffic_out_counter->limit == -1) {

                $total_ips += $organizations[$i]->ips_usage->usage;
                $total_traffic_out += $organizations[$i]->traffic_out_usage->usage;
            } else {
                $total_ips += $organizations[$i]->ips_counter->usage;
                $total_traffic_out += $organizations[$i]->traffic_out_counter->usage;
            }
        }

        return json_encode(array("total_ips" => $total_ips, "total_traffic_out" => $total_traffic_out));
    }

    /**
     * @verb(POST)
     * @path("/onDCavailable")
     * @param("http://aps-standard.org/types/core/resource/1.0#Notification",body)
     */
    public function onDCavailable($notification) {
        logme("onDCAvailable");
        $this->updateDatacenter();
    }

    /**
     * @verb(GET) 
     * @path("/canbedeleted")
     * @return(string,text/json) 
     */
    public function canBeDeleted() {
        $os = new OS($this->apiurl, $this->user, $this->password);
        $projects = $os->getProjects();
        $return = array("success" => true);
        if (count($projects->projects) > 0) {
            $return['success'] = false;
        }
        return json_encode($return);
    }

    /**
     * @verb(GET)
     * @path("/getroles")
     * @param(string, query)
     * @return(string,text/json)
     */
    public function getRoles() {
        $os = new OS($this->apiurl, $this->user, $this->password);
        $roles = $os->getRoles();
        $options = array();
        if (isset($roles->roles)) {
            for ($i = 0; $i < count($roles->roles); $i++) {
                $options[] = array(
                    "label" => $roles->roles[$i]->name,
                    "value" => $roles->roles[$i]->id
                );
            }
        }
        return json_encode($options);
    }


    /**
     * @verb(GET)
     * @path("/getslots")
     * @param(string, query)
     * @return(string,text/json)
     */
    public function getSlots() {
    	
    	function sortslots($a, $b){
    		return $a->id > $b->id;
    	}
    	
    	$apsc = \APS\Request::getController();
    	$dc = $apsc->getResource($this->aps->id);

      	if (is_null($this->listslots)) {
      		
            $dc->listslots = array();
            
            for ($i = 0; $i < 20; $i++) { 
            	
                $slot = new slot_details();
                $slot->id = $i+1;
                $slot->name = "ISO Slot " . $slot->id;
                $slot->images = array();
                $slot->imagesDisplayName ="";
                
                /*
				$slot_images = $apsc->getResources("eq(slot,". $slot->id .")","/aps/2/resources/". $this->aps->id . "/image");
				
				$p = 0;
				
                foreach($slot_images as $image){
                	if($image->slot){
                		$slot->images[] = $image->slot;
                	}
                	if($p>0){
                		$slot->imagesDisplayName = " , ";
                	}
                	$slot->imagesDisplayName .= $image->name;
                	++$p;
                }*/
                                
				$dc->listslots[] = $slot;
            }
           $apsc->updateResource($dc);
        }
        
        usort($dc->listslots, "sortslots");
       
        return json_encode($dc->listslots);
    }

    /**
     * @verb(POST)
     * @path("/editslots")
     * @param(string, query)
     * @return(string,text/json)
     */
    public function editSlots($slots) {
    	/*
    	 * Actually updates one slot
    	 */
        $apsc = \APS\Request::getController();
        $dc = $apsc->getResource($this->aps->id);
        
        $slots = json_decode($slots);
        $found = false;
        $i = 0;

        try{
logme("STEP 1");
        	while(!$found && $i < count($dc->listslots)){
        		if($dc->listslots[$i]->id == $slots->id) {
logme("STEP 2");
        			// Actualizar el slot encontrado
        			$dc->listslots[$i]->name = $slots->name;
        			$dc->listslots[$i]->images = $slots->images;
        			if (count($slots->images) > 0) {
        				$firstImg = $apsc->getResource($slots->images[0]);
logme("SLOTS",$slots);
        				$dc->listslots[$i]->imagesDisplayName = $firstImg->name;
        				if (count($slots->images) > 1){
        					$dc->listslots[$i]->imagesDisplayName .= ", " . (count($slots->images) - 1) . " more";
        				}
        			}else{
        				$dc->listslots[$i]->imagesDisplayName = "";
        			}
        			$found = true;
        		}
        		++$i;
        	}
        	$apsc->updateResource($dc);
        	return json_encode(array("success" => true));
        }catch(Exception $e){
        	return json_encode(array("success" => false, "error" => $e->getMessage()));
        }
       	
       	
 
    }

}
