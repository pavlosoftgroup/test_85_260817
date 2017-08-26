(function ($) {
  Drupal.behaviors.ReportForm= {
    attach: function (context, settings) {
      try {
        $("select.reporter-list").msDropDown();
      } catch(e) {
        alert(e.message);
      }
    }
  };
})(jQuery);