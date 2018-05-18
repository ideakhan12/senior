function ScaleContentToDevice(nextPage)
{
   	var screen = $.mobile.getScreenHeight();
    var header = nextPage.children(".ui-header").hasClass("ui-header-fixed") ? 
    nextPage.children(".ui-header").outerHeight() - 1 : nextPage.children(".ui-header").outerHeight();
	var footer = nextPage.children(".ui-footer").hasClass("ui-footer-fixed") ? 
    nextPage.children(".ui-footer").outerHeight() - 1 : nextPage.children(".ui-footer").outerHeight()
    var contentCurrent = nextPage.children(".ui-content").outerHeight() - nextPage.children(".ui-content").height();
    var content = screen - header - footer - contentCurrent;

    nextPage.children(".ui-content").height(content);
}

$(document).on( "pagecontainershow", function(event, ui)
{
	var nextPage = $(ui.toPage[0]);
    ScaleContentToDevice(nextPage);
});