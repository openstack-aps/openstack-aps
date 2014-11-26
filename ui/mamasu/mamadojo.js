define(['mamasu/Settings.js', 'mamasu/Types.js', 'mamasu/UI.js', 'mamasu/ECRUD.js', "mamasu/Widgets.js", "mamasu/utils.js"], function (settings, Types, UI, ECRUD, Widgets, utils) {
    UI.clearConsole();

    //http://patorjk.com/software/taag/#p=display&f=Big&t=Mamasu%20Lib.
//    UI.plainLog(" __  __                           _       _              ___    ___\n"
//            + "|  \\/  |                         | |     (_)            |__ \\  / _ \\\n"
//            + "| \\  / | __ _ _ __ ___   __ _  __| | ___  _  ___   __   __ ) || | | |\n"
//            + "| |\\/| |/ _` | '_ ` _ \\ / _` |/ _` |/ _ \\| |/ _ \\  \\ \\ / // / | | | |\n"
//            + "| |  | | (_| | | | | | | (_| | (_| | (_) | | (_) |  \\ V // /_ | |_| |\n"
//            + "|_|  |_|\\__,_|_| |_| |_|\\__,_|\\__,_|\\___/| |\\___/    \\_/|____(_)___/ powered by Jepi & Carlos\n"
//            + "                                        _/ |\n"
//            + "                                       |__/");

    return {
        environment: settings.environment,
        Types: Types,
        UI: UI,
        ECRUD: ECRUD,
        Widgets: Widgets,
        utils: utils
    };
});