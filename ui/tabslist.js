define([], function() {
    return [
        {name: "datacenter", label: _("Settings"), view: "datacenter-view"},
        {name: "roles", label: _("Roles assignment"), view: "roles-assignment"},
        {name: "ippools", label: _("IP Pools"), view: "ippool"},
        {name: "iso", label: _("Glance Images"), view: "iso"},
        {name: "slots", label: _("Slot management"), view: "slots"},
        {name: "statistics", label: _("Statistics"), view: "statistics"},
        {name: "synchronize", label: _("Synchronize"), view: "synchronize"}
    ];
});