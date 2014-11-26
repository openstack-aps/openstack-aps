define([
    "aps/ResourceStore",
    "dojo/Deferred",
    "aps/xhr",
    "dojo/promise/all",
    "mamasu/UI.js",
    "mamasu/base64.js"
], function(ResourceStore, Deferred, xhr, all, UI, base64) {

    var ECRUD = {
        simpleStoreByType: function(type) {
            var store = new ResourceStore({
                target: "/aps/2/resources/",
                apsType: type
            });
            return store;
        },
        simpleStoreByTarget: function(target) {
            var store = new ResourceStore({
                target: "/aps/2/resources/" + target
            });
            return store;
        },
        list: function(type) {
            var store = new ResourceStore({
                target: "/aps/2/resources/",
                apsType: type
            });
            var def = new Deferred();
            store.query().then(def.resolve).otherwise(def.reject);
            return def;
        },
        create: function(item, target) {
            target = target || "";
            var store = new ResourceStore({
                target: "/aps/2/resources/" + target
            });
            var def = new Deferred();
            store.add(item).then(def.resolve).otherwise(def.reject);
            return def;
        },
        read: function(target) {
            var store = new ResourceStore({
                target: "/aps/2/resources/"
            });
            var def = new Deferred();
            store.get(target).then(def.resolve).otherwise(def.reject);
            return def;
        },
        types: function() {
            var store = new ResourceStore({
                target: "/aps/2/types/"
            });
            var def = new Deferred();
            store.query().then(def.resolve).otherwise(def.reject);
            return def;
        },
        update: function(item) {
            var store = new ResourceStore({
                target: "/aps/2/resources/"
            });
            var def = new Deferred();
            store.put(item).then(def.resolve).otherwise(def.reject);
            return def;
        },
        get: function(target, data) {
            data = data || "";
            return xhr.get("/aps/2/resources/" + target + "?data=" + base64.encode(JSON.stringify(data)));// + "/?data=" + encodeURI(JSON.stringify(data)));
        },
        put: function(target, data) {
            return xhr.put("/aps/2/resources/" + target, {data: data});
//        xhr("/aps/2/resources/" + that.apsId, {method: "DELETE", handleAs: "text"}), function(data) {
        },
        post: function(target, data) {
            return xhr.post("/aps/2/resources/" + target, {data: data});
//        xhr("/aps/2/resources/" + that.apsId, {method: "DELETE", handleAs: "text"}), function(data) {
        },
        customDelete: function(target) {
            var def = new Deferred();
            xhr.del("/aps/2/resources/" + target).then(def.resolve).otherwise(def.reject);
            return def;
        },
        successDelete: function(target) {
            var def = new Deferred();
            xhr.del("/aps/2/resources/" + target).then(function() {
                def.resolve(_("Resource __ID__: Removed!", {ID: target}));
            }).otherwise(function(err) {
                def.resolve(_("Resource __ID__: __MESSAGE__", {ID: target, MESSAGE: UI.getErrorMsg(err)}));
            });
            return def;
        },
        deleteArrayOfIDs: function(ids) {
            var promises = [];
            for (var i = 0; i < ids.length; i++) {
                promises.push(this.customDelete(ids[i]));
            }
            var def = new Deferred();
            all(promises).then(def.resolve).otherwise(def.reject);
            return def;
        },
        deleteCollection: function(globalResources) {
            var promises = [];
            for (var i = 0; i < globalResources.length; i++) {
                promises.push(this.successDelete(globalResources[i].aps.id));
            }
            var def = new Deferred();
            all(promises).then(function(data) {
                var message = "";
                for (var i = 0; i < data.length; i++) {
                    message += data[i] + "<br />";
                }
                def.resolve(message);
            }).otherwise(def.reject);
            return def;
        }
    };
    return ECRUD;
});
