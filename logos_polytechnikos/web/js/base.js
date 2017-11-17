$(document).ready(function() {
  $('select').select2({theme: "bootstrap", width: 'style', language: 'cs'});
  $('input').addClass('form-control');
  $('input[type=checkbox]').removeClass('form-control');
  $('textarea').addClass('form-control');
});
$(function() {
    $('#side-menu').metisMenu({
       toggle: false // disable the auto collapse. Default: true.
     });
    $('.confirm').on("click", function(){

        $('.modal-content').html(
            ' <div class="modal-header">\n' +
            '    <button type="button" class="close" data-dismiss="modal">&times;</button>\n' +
            '    <h4 class="modal-title">Potvrzení </h4>\n' +
            ' </div>\n' +
            ' <div class="modal-body obrazky-modal-body">\n' +
            '   Opravdu chcete tuto akci provést?' +
            ' </div>\n' +
            ' <div class="modal-footer">\n' +
            '    <a type="button" class="btn btn-success">Provést</a>\n' +
            '    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>\n' +
            ' </div>'
        );

        $('.modal-content a').attr('href', $(this).attr('href'));
        $("#modal").modal('show');

        event.preventDefault();
    });
});
