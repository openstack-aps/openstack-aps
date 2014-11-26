<?php

require "common.php";

class os_metric {

    /**
     * @type("string")
     * @title("Measure")
     */
    public $measure;

    /**
     * @type("string")
     * @title("value")
     */
    public $value;

//    public function __construct($measure, $value) {
//        logme("METRIC", "$measure, $value");
//        $this->measure = $measure;
//        $this->value = $value;
//    }
}

class statistics_historic {

    /**
     * @type("string")
     * @title("Date")
     */
    public $date;

    /**
     * @type("os_metric")
     * @title("Cpu")
     */
    public $cpu;

    /**
     * @type("os_metric")
     * @title("Memory")
     */
    public $memory;

    /**
     * @type("os_metric")
     * @title("Disk Size")
     */
    public $disk_size;

    /**
     * @type("os_metric")
     * @title("IPs")
     */
    public $ips;

    /**
     * @type("os_metric")
     * @title("Traffic Out")
     */
    public $traffic_out;

//    public function __construct($cpu, $memory, $disk_size, $ips, $traffic_out) {
//        $this->cpu = $cpu;
//        $this->memory = $memory;
//        $this->disk_size = $disk_size;
//        $this->ips = $ips;
//        $this->traffic_out = $traffic_out;
//        $this->date = strtotime("now");
//    }
}

/**
 * Class Organization
 * @author("The Mamasu Agency")
 * @type("http://openstack.parallels.com/organization/1.6")
 * @implements("http://aps-standard.org/types/core/resource/1.0")
 */
class organization extends \APS\ResourceBase {

    /**
     * @link("http://openstack.parallels.com/app")
     * @required
     */
    public $app;

    /**
     * @link("http://openstack.parallels.com/dc/2.1")
     * @required
     */
    public $dc;

    /**
     * @link("http://openstack.parallels.com/heatstack[]")
     */
    public $heatstack;

    /**
     * @link("http://openstack.parallels.com/unmanagedve[]")
     */
    public $unmanagedve;

    /**
     * @link("http://aps-standard.org/types/core/subscription/1.0")
     * @required
     */
    public $subscription;

    /**
     * @link("http://aps-standard.org/types/core/account/1.0")
     * @required
     */
    public $account;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Counter")
     * @title("VCPU Counter Flat")
     * @description("Number of VCPUs")
     * @unit("unit")
     */
    public $cpu_counter;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Counter")
     * @title("Memory Counter Flat")
     * @description("Volume of RAM allocated in MB")
     * @unit("mb")
     */
    public $memory_counter;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Counter")
     * @title("Disk Size Couter Flat")
     * @description("Size of root disk in GB")
     * @unit("gb")
     */
    public $disk_size_counter;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Counter")
     * @title("IPs Counter Flat")
     * @description("Number of IPs")
     * @unit("unit")
     */
    public $ips_counter;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Counter")
     * @title("Traffic Out Counter Flat")
     * @description("Number of outgoing Kbytes on a VM network interface")
     * @unit("kb")
     */
    public $traffic_out_counter;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("VCPU Usage PAYG")
     * @description("Number of used VCPUs")
     * @unit("unit-h")
     */
    public $cpu_usage;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("Memory Usage PAYG")
     * @description("Volume of RAM used in MB/h")
     * @unit("mb-h")
     */
    public $memory_usage;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("Disk Size Usage PAYG")
     * @description("Size of root disk used in MB/h")
     * @unit("mb-h")
     */
    public $disk_size_usage;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("IPs Usage PAYG")
     * @description("Use of IPs")
     * @unit("unit-h")
     */
    public $ips_usage;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("Traffic Out Usage PAYG")
     * @description("Number of outgoing MB/h used on a VM network interface")
     * @unit("mb-h")
     */
    public $traffic_out_usage;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("ISO Slot 1")
     * @description("Slot 1 to assign ISO images a unit/h quota")
     * @unit("unit-h")
     */
    public $slot_1;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("ISO Slot 2")
     * @description("Slot 2 to assign ISO images a unit/h quota")
     * @unit("unit-h")
     */
    public $slot_2;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("ISO Slot 3")
     * @description("Slot 3 to assign ISO images a unit/h quota")
     * @unit("unit-h")
     */
    public $slot_3;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("ISO Slot 4")
     * @description("Slot 4 to assign ISO images a unit/h quota")
     * @unit("unit-h")
     */
    public $slot_4;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("ISO Slot 5")
     * @description("Slot 5 to assign ISO images a unit/h quota")
     * @unit("unit-h")
     */
    public $slot_5;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("ISO Slot 6")
     * @description("Slot 6 to assign ISO images a unit/h quota")
     * @unit("unit-h")
     */
    public $slot_6;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("ISO Slot 7")
     * @description("Slot 7 to assign ISO images a unit/h quota")
     * @unit("unit-h")
     */
    public $slot_7;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("ISO Slot 8")
     * @description("Slot 8 to assign ISO images a unit/h quota")
     * @unit("unit-h")
     */
    public $slot_8;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("ISO Slot 9")
     * @description("Slot 9 to assign ISO images a unit/h quota")
     * @unit("unit-h")
     */
    public $slot_9;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("ISO Slot 10")
     * @description("Slot 10 to assign ISO images a unit/h quota")
     * @unit("unit-h")
     */
    public $slot_10;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("ISO Slot 11")
     * @description("Slot 11 to assign ISO images a unit/h quota")
     * @unit("unit-h")
     */
    public $slot_11;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("ISO Slot 12")
     * @description("Slot 12 to assign ISO images a unit/h quota")
     * @unit("unit-h")
     */
    public $slot_12;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("ISO Slot 13")
     * @description("Slot 13 to assign ISO images a unit/h quota")
     * @unit("unit-h")
     */
    public $slot_13;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("ISO Slot 14")
     * @description("Slot 14 to assign ISO images a unit/h quota")
     * @unit("unit-h")
     */
    public $slot_14;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("ISO Slot 15")
     * @description("Slot 15 to assign ISO images a unit/h quota")
     * @unit("unit-h")
     */
    public $slot_15;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("ISO Slot 16")
     * @description("Slot 16 to assign ISO images a unit/h quota")
     * @unit("unit-h")
     */
    public $slot_16;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("ISO Slot 17")
     * @description("Slot 17 to assign ISO images a unit/h quota")
     * @unit("unit-h")
     */
    public $slot_17;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("ISO Slot 18")
     * @description("Slot 18 to assign ISO images a unit/h quota")
     * @unit("unit-h")
     */
    public $slot_18;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("ISO Slot 19")
     * @description("Slot 19 to assign ISO images a unit/h quota")
     * @unit("unit-h")
     */
    public $slot_19;

    /**
     * @type("http://aps-standard.org/types/core/resource/1.0#Usage")
     * @title("ISO Slot 20")
     * @description("Slot 20 to assign ISO images a unit/h quota")
     * @unit("unit-h")
     */
    public $slot_20;

    /**
     * @type("integer")
     * @title("subscription id")
     */
    public $subscription_id;

    /**
     * @type("string")
     * @title("tenant id")
     */
    public $tenant_id;

    /**
     * @type("string")
     * @title("os")
     */
    public $os;

    /**
     * @type("string")
     * @title("username")
     */
    public $username;

    /**
     * @type("string")
     * @title("password")
     */
    public $password;

    /**
     * @type("string")
     * @title("name")
     */
    public $name;

    /**
     * @type("string")
     * @title("email")
     */
    public $email;

    /**
     * @type("statistics_historic[]")
     * @title("Statistics Historic")
     */
    public $statistics_historic;

    /**
     * @type("string")
     * @title("Model")
     * @description("Identifies the payment model (PAYG or FLAT)")
     */
    public $model;

    public function provision() {

        $apsc = clone \APS\Request::getController();
        $dc = $apsc->getResource($this->dc->aps->id);
        $os = new OS($dc->apiurl, $dc->user, $dc->password);

        try {

            /*
             * Roles :
             * 1. admin 19161422093d482fb6540bcecde60f89
             * 2. _member_ 9fe2ff9ee4384b1894a90878d3e92bab
             * 3. heat_stack_user b59320c672764885b3c702308b5b5814
             * 4. ResellerAdmin d2477be31eb141649cc02325cb273561
             * 5. Member f3ffbe27d94741e9baeada7086a3b159
             */

            $apscAccount = $apsc->impersonate($this->aps->id);
            $apscAccount->resetSession();

            $admins = json_decode($apscAccount->getIo()->sendRequest(\APS\Proto::GET, "/aps/2/resources/" . $this->account->aps->id . "/users?implementing(http://parallels.com/aps/types/pa/admin-user/1.0)"));

            if (!empty($admins)) {
                $apscAdmin = clone $apscAccount;
                $admin = $apscAdmin->getResource($admins[0]->aps->id);
            }

            

            $checkUserExists = $os->checkUserExists($admin->login);
            $this->name = "Proj" . strtotime("now") . $admin->userId;
            $this->email = $admin->email;
            $this->username = $admin->login;
            $Tenant = $os->createTenant($this->name, "Tenant description " . $this->username, true);
            $this->tenant_id = $Tenant->tenant->id;

            if (count($checkUserExists->users) > 0) {

                $User = $checkUserExists->users[0];
                $uid = $User->id;
                $json_organizations = $apscAccount->getIo()->sendRequest(\APS\Proto::GET, "/aps/2/resources/?implementing(http://openstack.parallels.com/organization)&eq(aps.status,aps:ready)");
                $organizations = json_decode($json_organizations, true);

                if (!isset($organizations[0]['password']))
                    throw new Exception("Unable to find previous password");

                $this->password = $organizations[0]['password'];
            } else {
                $admin->password = \APS\generatePassword(10);
                $this->password = $admin->password;
                $User = $os->createUsers($Tenant->tenant->id, "Default user " . $Tenant->tenant->id, "default", $this->email, $this->username, $this->password);
                $uid = $User->user->id;
            }


            if (($dc->admin_role == "") || ($dc->member_role == "")) {
                throw new Exception("Roles are not defined");
            }
            $token = $os->getToken();
            $adminUserId = $token->access->user->id;
            $Roles = $os->grantRoleToProjectUser($Tenant->tenant->id, $uid, $dc->member_role);
            $Roles = $os->grantRoleToProjectUser($Tenant->tenant->id, $adminUserId, $dc->admin_role);

            if (isset($this->disk_size_counter) && isset($this->memory_counter) && isset($this->cpu_counter) && isset($this->ips_counter) && isset($this->traffic_out_counter)) {
                $this->model = "flat";
                $os->updateQuotasStorage($this->tenant_id, array("gigabytes" => $this->disk_size_counter->limit));
                $os->updateQuotasCompute($this->tenant_id, array('ram' => $this->memory_counter->limit, 'cores' => $this->cpu_counter->limit));
                $os->updateQuotasNetwork($this->tenant_id, array('floatingip' => $this->ips_counter->limit));


                $this->cpu_counter->usage = 0;
                $this->memory_counter->usage = 0;
                $this->disk_size_counter->usage = 0;
                $this->ips_counter->usage = 0;
                $this->traffic_out_counter->usage = 0;


                error_log("IT is a flat subscription");
            } else {
                $this->model = "payg";
                $os->updateQuotasStorage($this->tenant_id, array("gigabytes" => -1));
                $os->updateQuotasCompute($this->tenant_id, array('ram' => -1, 'cores' => -1));
                $os->updateQuotasNetwork($this->tenant_id, array('floatingip' => -1));

                $this->cpu_usage->usage = 0;
                $this->memory_usage->usage = 0;
                $this->disk_size_usage->usage = 0;
                $this->ips_usage->usage = 0;
                $this->traffic_out_usage->usage = 0;

                error_log("it is a payg subscription");
            }
            $this->statistics_historic[] = $this->getStatisticHistoricItem(0, 0, 0, 0, 0);
        } catch (Exception $e) {

//            error_log("exception " . $e . "\r\n", 3, "/var/www/html/openstack/my-errors.log");
            throw new Exception("Error : " . $e->getMessage());
        }
    }

    
    
    public function configure($new) {
        $apsc = clone \APS\Request::getController();
        $dc = $apsc->getResource($this->dc->aps->id);
        $os = new OS($dc->apiurl, $dc->user, $dc->password);
        
        if ($new->password == "new_password"){
        	$randomPass = \APS\generatePassword(10);
        	$os->changePassword($this->tenant_id, $randomPass);
        	$this->password = $randomPass;
        }
        

        if ($this->model == "flat") {

            $this->disk_size_counter = $new->disk_size_counter;
            $this->memory_counter = $new->memory_counter;
            $this->cpu_counter = $new->cpu_counter;
            $this->ips_counter = $new->ips_counter;

            $os->updateQuotasStorage($this->tenant_id, array("gigabytes" => $this->disk_size_counter->limit));
            $os->updateQuotasCompute($this->tenant_id, array('ram' => $this->memory_counter->limit, 'cores' => $this->cpu_counter->limit));
            $os->updateQuotasNetwork($this->tenant_id, array('floatingip' => $this->ips_counter->limit));
        } else {
            $os->updateQuotasStorage($this->tenant_id, array("gigabytes" => -1));
            $os->updateQuotasCompute($this->tenant_id, array('ram' => -1, 'cores' => -1));
            $os->updateQuotasNetwork($this->tenant_id, array('floatingip' => -1));
        }
    }

    public function retrieve() {
        $this->synchOpenStackInstances();

        $apsc = \APS\Request::getController();
        $dc = $apsc->getResource($this->dc->aps->id);
        $os = new OS($dc->apiurl, $dc->user, $dc->password);

        $this->updateCountersPerImage($os);


        $query = array();
        if (count($this->statistics_historic) > 0) {

            $lastStatistic = $this->statistics_historic[count($this->statistics_historic) - 1];

            $query[] = array("field" => "timestamp", "op" => "ge", "value" => date("Y-m-d\TH:00:00", $lastStatistic->date));
            $query[] = array("field" => "timestamp", "op" => "lt", "value" => date("Y-m-d\TH:00:00", strtotime("now")));
        } else {

            $query[] = array("field" => "timestamp", "op" => "ge", "value" => date("Y-m-d\TH:00:00", strtotime("yesterday")));
            $query[] = array("field" => "timestamp", "op" => "lt", "value" => date("Y-m-d\TH:00:00", strtotime("now")));
        }

        $query[] = array(
            "field" => "project_id",
            "op" => "eq",
            "value" => $this->tenant_id
        );

        error_log("[OPENSTACK] HOLA");


        if ($this->tenant_id != null && $os->checkProjectExits($this->tenant_id)) {
            /*
             * Check if it is a Flat or a PAYG subscription
             */
//error_log("----------NEW PROJECT " . $this->tenant_id . "---------" . "\r\n", 3, '/var/www/html/openstack/controllers/retrieve.txt');

            $metercpu = intval($os->getMeterStatistics("vcpus", $query, array("resource_id"), null));
            $metermemory = intval($os->getMeterStatistics("memory", $query, array("resource_id"), null));
            $meterdisksize = intval($os->getMeterStatistics('disk.root.size', $query, array("resource_id"), null));
            $meterips = intval($os->getMeterStatistics('ip.floating', $query, array("resource_id"), null));
            $metertrafficout = intval($os->getMeterStatistics('network.outgoing.bytes', $query, array("resource_id"), null));

            if ($this->model == "flat") {

                $this->cpu_counter->usage = $metercpu;
                $this->memory_counter->usage = $metermemory;
                $this->disk_size_counter->usage = $meterdisksize;
                $this->ips_counter->usage = $meterips;
                $this->traffic_out_counter->usage = $metertrafficout;

                $this->statistics_historic[] = $this->getStatisticHistoricItem($this->cpu_counter->usage, $this->memory_counter->usage, $this->disk_size_counter->usage, $this->ips_counter->usage, $this->traffic_out_counter->usage);

                error_log("---------------FLAT----------------" . "\r\n", 3, '/var/www/html/openstack/controllers/retrieve.txt');
                error_log("----------" . $this->tenant_id . "---------" . "\r\n", 3, '/var/www/html/openstack/controllers/retrieve.txt');
                error_log("CPU usage = " . $this->cpu_counter->usage . "\r\n", 3, '/var/www/html/openstack/controllers/retrieve.txt');
                error_log("Memory usage = " . $this->memory_counter->usage . "\r\n", 3, '/var/www/html/openstack/controllers/retrieve.txt');
                error_log("Disk size usage = " . $this->disk_size_counter->usage . "\r\n", 3, '/var/www/html/openstack/controllers/retrieve.txt');
                error_log("Ips usage = " . $this->ips_counter->usage . "\r\n", 3, '/var/www/html/openstack/controllers/retrieve.txt');
                error_log("Traffic out usage = " . $this->traffic_out_counter->usage . "\r\n", 3, '/var/www/html/openstack/controllers/retrieve.txt');
                error_log("----------" . $this->tenant_id . "---------" . "\r\n", 3, '/var/www/html/openstack/controllers/retrieve.txt');
                error_log("-------------------------------------" . "\r\n", 3, '/var/www/html/openstack/controllers/retrieve.txt');
            } else {
                $this->cpu_usage->usage += $metercpu;
                $this->memory_usage->usage += $metermemory;
                $this->disk_size_usage->usage+= $meterdisksize;
                $this->ips_usage->usage += $meterips;
                $this->traffic_out_usage->usage += $metertrafficout;

                $this->statistics_historic[] = $this->getStatisticHistoricItem($this->cpu_usage->usage, $this->memory_usage->usage, $this->disk_size_usage->usage, $this->ips_usage->usage, $this->traffic_out_usage->usage);


                error_log("---------------PAYG ----------------" . "\r\n", 3, '/var/www/html/openstack/controllers/retrieve.txt');
                error_log("----------" . $this->tenant_id . "---------" . "\r\n", 3, '/var/www/html/openstack/controllers/retrieve.txt');
                error_log("CPU usage = " . $this->cpu_usage->usage . "\r\n", 3, '/var/www/html/openstack/controllers/retrieve.txt');
                error_log("Memory usage = " . $this->memory_usage->usage . "\r\n", 3, '/var/www/html/openstack/controllers/retrieve.txt');
                error_log("Disk size usage = " . $this->disk_size_usage->usage . "\r\n", 3, '/var/www/html/openstack/controllers/retrieve.txt');
                error_log("Ips usage = " . $this->ips_usage->usage . "\r\n", 3, '/var/www/html/openstack/controllers/retrieve.txt');
                error_log("Traffic out usage = " . $this->traffic_out_usage->usage . "\r\n", 3, '/var/www/html/openstack/controllers/retrieve.txt');
                error_log("-------------------------------------" . "\r\n", 3, '/var/www/html/openstack/controllers/retrieve.txt');
            }
        }


        logme("FINISH RETRIEVE");
        $apsc->updateResource($this);
    }

    private function updateCountersPerImage($os) {
        $this->synchOpenStackInstances();

        $apsc = \APS\Request::getController();
        $apsc2 = $apsc->impersonate($this);
        $dc = $apsc->getResource($this->dc->aps->id);

        $images = json_decode($apsc->getIo()->sendRequest(\APS\Proto::GET, "/aps/2/resources/" . $dc->aps->id . "/image"));
        if ($this->model == "payg") {
            for ($i = 0; $i < count($images); $i++) {
                $image = $apsc->getResource($images[$i]->aps->id);
                logme("IMAGE", $image);
                $unmanaged = json_decode($apsc->getIo()->sendRequest(\APS\Proto::GET, "/aps/2/resources/" . $image->aps->id . "/unmanagedve"));
                $activeTime = 0;
                for ($j = 0; $j < count($unmanaged); $j++) {
                    $server = $os->listServerDetails($this->tenant_id, $unmanaged[$j]->instance_id);
                    $serverDetails = $server->server;

                    $now = strtotime("now");
                    $created = strtotime($serverDetails->created);
                    $activeTime += $now - $created;
                }
                //Update Counters
                try {
                    $slotRef = "slot_" . $image->slot;
                    $this->$slotRef->usage = $activeTime;
                } catch (Exception $e) {
                    
                }
            }
        }
    }

    private function getMetricStruct($measure, $value) {
        $metric = new os_metric();
        $metric->measure = $measure;
        $metric->value = $value;
        return $metric;
    }

    private function getStatisticHistoricItem($cpu, $memory, $disk_size, $ips, $traffic_out) {
        $statisticItem = new statistics_historic();

        $statisticItem->date = strtotime("now");
        $statisticItem->cpu = $this->getMetricStruct("vcpus", $cpu);
        $statisticItem->memory = $this->getMetricStruct("memory", $memory);
        $statisticItem->disk_size = $this->getMetricStruct("disk.root.size", $disk_size);
        $statisticItem->ips = $this->getMetricStruct("ip.floating", $ips);
        $statisticItem->traffic_out = $this->getMetricStruct("network.outgoing.bytes", $traffic_out);

        return $statisticItem;
    }

    public function synchOpenStackInstances() {
        $apsc = \APS\Request::getController();
        $apsc2 = $apsc->impersonate($this);
        $dc = $apsc->getResource($this->dc->aps->id);

        $existentUnmanaged = json_decode($apsc->getIo()->sendRequest(\APS\Proto::GET, "/aps/2/resources/" . $this->aps->id . "/unmanagedve"));

        logme("UNMANAGED EXISTENTS", $existentUnmanaged);

        $os = new OS($dc->apiurl, $dc->user, $dc->password);

        $servers = $os->listServers($this->tenant_id);
        $images = json_decode($apsc->getIo()->sendRequest(\APS\Proto::GET, "/aps/2/resources/" . $dc->aps->id . "/image"));
        $defaultImage = null;
        for ($i = 0; $i < count($images); $i++) {
            if (is_null($defaultImage) && $images[$i]->default == 1) {
                $defaultImage = $images[$i];
            }
        }
        $unmanagedve = array();
        for ($i = 0; $i < count($servers->servers); $i++) {
//Check if already exists on PA
            $exists = false;
            $j = 0;

            while ($j < count($existentUnmanaged) && !$exists) {
                if ($servers->servers[$i]->id == $existentUnmanaged[$j]->instance_id) {
                    $exists = true;
                } else {
                    $j++;
                }
            }
//If not exists unmanagedve will be created
            if (!$exists) {
                logme("NOT EXISTS");
                try {
                    //Check which image is using
                    $imageToLink = null;
                    $server = $os->listServerDetails($this->tenant_id, $servers->servers[$i]->id);
                    $serverDetails = $server->server;
                    logme("IMAGES", $images);
                    logme("SERVER DETAILS", $serverDetails);
//                    logme("SERVER DETAILS", $serverDetails);
                    for ($n = 0; $n < count($images); $n++) {
                        if ($images[$n]->id == $serverDetails->image->id) {
                            $imageToLink = $images[$n];
                        }
                    }
                    if (is_null($imageToLink)) {
                        $imageToLink = $defaultImage;
                    }


//                    logme("INSTANCE", $servers->servers[$i]);
                    $unmanagedve[$i] = clone \APS\TypeLibrary::newResourceByTypeId("http://openstack.parallels.com/unmanagedve/1.3");

                    $unmanagedve[$i]->instance_id = $servers->servers[$i]->id;
                    $unmanagedve[$i]->name = $servers->servers[$i]->name;

                    $unmanagedve[$i]->organization = $this;
                    $unmanagedve[$i]->image = $imageToLink;

                    $apsc2->linkResource($this, "unmanagedve", $unmanagedve[$i]);
                } catch (Exception $e) {
//Nothing to do here, it's just to avoid unexpected finish on retrieve()
                    error_log("[OpenStack] ERROR CREATING INSTANCE => " . json_encode($unmanagedve[$i]));
                }
            }
        }

//Remove unmanagedVe which are not in OpenStack but just in PA
        for ($j = 0; $j < count($existentUnmanaged); $j++) {
            $alive = false;
            $i = 0;
            while ($i < count($servers->servers) && !$alive) {
                if ($servers->servers[$i]->id == $existentUnmanaged[$j]->instance_id) {
                    $alive = true;
                } else {
                    $i++;
                }
            }
            if (!$alive) {
                $apsc->getIo()->sendRequest(\APS\Proto::DELETE, "/aps/2/resources/" . $existentUnmanaged[$j]->aps->id);
            }
        }
    }

    public function unprovision() {
        return true;
    }

    public function upgrade() {
        
    }
    
    
    /**
     * @verb(GET)
     * @path("/getTenantUsage")
     * @return(string, text/json)
     */
    public function getTenantUsage(){
    	
    	$apsc = \APS\Request::getController();
    	
    	$dc = $apsc->getResource($this->dc->aps->id);
    	
    	$os = new OS($dc->apiurl, $dc->user, $dc->password);
    	
    	return json_encode($os->getLimits($this->tenant_id));
    	
    }
    

    /**
     * @verb(GET)
     * @path("/synchproject")
     * @return(string, text/json)
     */
    public function synchproject() {
        $this->retrieve();
    }

    /**
     * @verb(GET)
     * @path("/getvms")
     * @return(string, text/json)
     */
    public function getAllVMs() {

        //$this->synchOpenStackInstances();

        $apsc = \APS\Request::getController();
        $unmanaged = json_decode($apsc->getIo()->sendRequest(\APS\Proto::GET, "/aps/2/resources/" . $this->aps->id . "/unmanagedve"));
        $dc = $apsc->getResource($this->dc->aps->id);
        $os = new OS($dc->apiurl, $dc->user, $dc->password);
        $arrayInstances = array();



        for ($i = 0; $i < count($unmanaged); ++$i) {
        	
            error_log("tenant_id : " . $this->tenant_id . " == unmanagedve " . $unmanaged[$i]->instance_id . "\r\n");
            try {
                $server = $os->listServerDetails($this->tenant_id, $unmanaged[$i]->instance_id);
                $unmanaged[$i]->info = $server->server;
                
                
                
                
                $arrayInstances[] = $unmanaged[$i];
            } catch (Exception $e) {
                //throw new Exception("Could not obtain the ServerDetails  from " . $this->dc->api_tenant_id . " of instance ". $unmanaged[$i]->instance_id);
            }
            
            
        }



        return json_encode($arrayInstances);
    }

}
