define(["dojo/Deferred", "aps/Memory", "aps/load"], function(Deferred, Memory, load) {
    return {
        /**
         * 
         * @param {objects array} data: contains an array of objects with the same structure.
         * @param {string} where: id of item where do you want to show GridInspector
         * @returns {Widgets_L1.Deferred}
         */
        ObjectInspector: function(data, where) {
            var def = new Deferred();
            console.log("Object Inspector", data);
            var mem = new Memory({
                data: data
            });
            var layout = [];

            for (var key in data[0]) {
                if (data[0].hasOwnProperty(key)) {
                    layout[layout.length] = {
                        name: key,
                        field: key
                    };
                }
            }
            load(["aps/Grid", {
                    store: mem,
                    columns: layout
                }], where).then(def.resolve).otherwise(def.reject);
            return def;
        },
        /**
         *  @param {objects array} tabs: the structure of tabs is an array of objects with structure {label: "My label", [active:[true|false]], view: "view-where-to-go"}
         *  @returns {array} array prepared to load
         */
        Tabs: function(tabs, activeTabName) {
            function getTab(tab, active, firstTab) {
                var tabId = "";
                if (firstTab === true) {
                    tabId = "first-tab";
                }
                var className = "";
                var style = "";
                var onclickFunc = function() {
                };
                if (active) {
                    className = "active";
                    style = "cursor:default;";
                } else {
                    onclickFunc = function() {
                        aps.apsc.gotoView(tab.view);
                    };
                }

                return ["<li>", {id: tabId, "class": className}, [
                        ["<a>", {style: style, href: "javascript:void(0);", onclick: onclickFunc}, [
                                ["<span>", {innerHTML: tab.label}]
                            ]]
                    ]];
            }


            var tabsArray = [];
            if (tabs.length > 0) {
                tabsArray.push(getTab(tabs[0], tabs[0].name === activeTabName, true));
            }
            for (var i = 1; i < tabs.length; i++) {
                tabsArray.push(getTab(tabs[i], tabs[i].name === activeTabName));
            }

            return ["<div>", {"class": "tabs"}, [
                    ["<div>", {"class": "tabs-area"}, [
                            ["<ul>", tabsArray]
                        ]]
                ]];
        }
    };
});