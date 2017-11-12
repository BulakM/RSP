$(document).ready(function() {
  $('select').select2({theme: "bootstrap", width: 'style', language: 'cs'});
  $('input').addClass('form-control');
  $('textarea').addClass('form-control');
});
$(function() {
  $('#side-menu').metisMenu({
    toggle: false // disable the auto collapse. Default: true.
  });
});
