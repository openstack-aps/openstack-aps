define([
    "dijit/registry",
    "aps/Message",
    "mamasu/Settings.js"
], function(registry, Message, settings) {
    function safe_tags_replage(str) {
        if (typeof str === 'string') {
            return str.replace(/</g, "&lt;").replace(/>/g, "&gt;");
        } else {
            return str;
        }
    }
    var UI = {
        _showMessage: function(message, typeMsg) {
            UI.log("MESSAGE", message);
            if (settings.htmlMessages) {
                message = safe_tags_replage(message);
            }
            var containerId = settings.mainPageId;
            var page = registry.byId(containerId);
            if (page === undefined) {
                containerId = "page";
                page = registry.byId(containerId);
            }
            var messages = page.get("messageList");
            aps.apsc.cancelProcessing();
            messages.removeAll();
            messages.addChild(new Message({
                description: message,
                type: typeMsg
            }));
        },
        showSuccess: function(msg) {
            UI._showMessage(msg, "info");
        },
        showInfo: function(msg) {
            UI._showMessage(msg, "");
        },
        showWarning: function(msg) {
            UI._showMessage(msg, "warning");
        },
        showError: function(error) {
            UI.log("ERROR", error);
            var newError = UI.getErrorMsg(error);
            UI._showMessage(newError, "error");
        },
        getErrorMsg: function(error) {
            var errMsg = "";
            UI.log("EEEEEEEEEERROR", error);
            try {
                var errData = JSON.parse(error.response.text);
                errMsg = errData.message;
            } catch (e) {
                errMsg = error;
            }
            return errMsg;
        },
        log: function() {
            if (settings.environment !== "PROD") {
                console.log("[LOG]", arguments);
            }
        },
        plainLog: function(log) {
            if (settings.environment !== "PROD") {
                console.log(log);
            }
        },
        clearConsole: function() {
            if (settings.environment !== "PROD") {
                console.clear();
            }
        }
    };
    return UI;
});