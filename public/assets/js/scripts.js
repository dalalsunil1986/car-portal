function runSlidebars() {
    var mySlidebars = new $.slidebars(); // Start Slidebars
    var width = $(window).width(); // Get width of the screen

    if (width > 480 && mySlidebars.init) { // Check width and if Slidebars has been initialised
        $('.sb-close').trigger("click"); // Triggering a click event will close a Slidebar if open.
    }
}
