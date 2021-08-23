/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
tooltip = function tooltip(e) {
  $(e).tooltip('show');
};

add_comment_form_toggle = function add_comment_form_toggle(post_id) {
  if ($("#".concat(post_id, "_resume_form_toggle")).is(":visible")) {
    $("#".concat(post_id, "_resume_form_toggle")).hide();
  }

  $("#".concat(post_id, "_add_comment")).toggle();
};

upload_resume_button = function upload_resume_button(post_id) {
  if ($("#".concat(post_id, "_add_comment")).is(":visible")) {
    $("#".concat(post_id, "_add_comment")).hide();
  }

  $("#".concat(post_id, "_resume_form_toggle")).toggle();
};

share_post_modal = function share_post_modal() {
  $('#share_post_modal').modal();
};

hide_comments = function hide_comments(post_id) {
  $("#".concat(post_id, "_view_comments_btn")).show();
  $("#".concat(post_id, "_hide_comments_btn")).hide();
  $("#".concat(post_id, "_comment_accordion")).collapse('hide');
};

copy_to_clipboard = function copy_to_clipboard(id) {
  var copyText = $("#".concat(id)).val();
  navigator.clipboard.writeText(copyText);
  /* Alert the copied text */

  alertify.notify("Copied!");
};
/******/ })()
;