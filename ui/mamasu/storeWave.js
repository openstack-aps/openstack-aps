define(["dojo/_base/declare", "dojo/Deferred", "aps/xhr", "dojo/promise/all"],
        function(declare, Deferred, xhr, all) {
            return declare(null, {
                promises: [],
                results: [],
                constructor: function() {
                    this.promises = [];
                    this.results = [];
                },
                addStorePromise: function(store, call, params) {
                    var deferred = new Deferred();
                    store[call](params).then(function(data) {
                        deferred.resolve(data);
                    }).otherwise(function(err) {
                        deferred.reject(err);
                    });
                    this.promises.push(deferred.promise);
                },
                addXHRPromise: function(call, url, data) {
                    var deferred = new Deferred();
                    xhr[call](url, {data: data}).then(function(data) {
                        deferred.resolve(data);
                    }).otherwise(function(err) {
                        deferred.reject(err);
                    });
                    this.promises.push(deferred.promise);
                },
                execute: function() {
                    var deferred = new Deferred();
                    var that = this;
                    all(this.promises).then(function(data) {
                        that.results = data;
                        deferred.resolve(data);
                    }).otherwise(function(err) {
                        deferred.reject(err);
                    });
                    return deferred.promise;
                },
                mapResults: function(callBack) {
                    callBack.apply(callBack, this.results);
                }
            });
        });