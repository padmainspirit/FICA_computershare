/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************************!*\
  !*** ./resources/js/pages/form-wizard.init.js ***!
  \************************************************/
$(function () {
  $("#basic-example").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slide",
    autoFocus: true,
    saveState: true
  //   onFinished: function( a ) {
  //     $('#basic-example.steps a:eq(0)').click();
  //     $('basic-example').hide();
  //     $('#custom-message').show();
  // }
  }), $("#vertical-example").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slide",
    stepsOrientation: "vertical"
  });
});
/******/ })()
;