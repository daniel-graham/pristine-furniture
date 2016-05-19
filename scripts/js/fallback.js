/**
 * Created by Dan on 4/16/2016.
 */
function cssLoaded(href) {
    var cssFound = false;

    for (var i = 0; i < document.styleSheets.length; i++) {
        var sheet = document.styleSheets[i];
//				console.log(sheet);
        if (
            (sheet['href'] == "http://netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" ||
            sheet['href'] == "https://netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" ||
            sheet['href'] == "https://cdnjs.cloudflare.com/ajax/libs/angularjs-toaster/1.1.0/toaster.css" ||
            sheet['href'] == "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.2.1/css/material.css" ||
            sheet['href'] == "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.2.1/css/ripples.css" ||
            sheet['href'] == "https://cdn.rawgit.com/enyo/dropzone/master/dist/dropzone.css") &&
            $('#bootstrapCssTest').is(':visible') === false
        ) {
            console.log("Found");
            cssFound = true;
        }
    };
    return cssFound;
}
function runCheck() {
    var stylesheets = [
        {"name": "bootstrap.min.css", "href": "css/bootstrap.min.css"},
        {"name": "material.css", "href": "css/material.css"},
        {"name": "toaster.css", "href": "css/toaster.css"},
        {"name": "ripples.css", "href": "css/ripples.css"},
        {"name": "dropzone.css", "href": "css/dropzone.css"}
    ];
    var local_css;
    var parent = document.getElementsByTagName('head').item(0) || document.documentElement;
    console.log(parent);
    for(var i = 0; i < stylesheets.length; i++){
        var sheet = stylesheets[i];
//				console.log(sheet.name);
        if ($('#bootstrapCssTest').is(':visible') === true) {
            local_css = document.createElement("link");
            local_css.href = s.href;
            local_css.setAttribute("rel", "stylesheet");

            console.log(sheet.name);
//					local_css = new CustomEvent('link');
//					local_css.setAttribute("rel", "stylesheet");
//					local_css.setAttribute("href", sheet.href);

            parent.appendChild(local_css);
            console.log(sheet.href);
        }
        console.log(sheet.name);

    }

}
