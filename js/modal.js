jQuery(document).ready(function () {
  //Support for thickbox in the admin bar
  jQuery('#wpadminbar .findfunction-menu a').addClass('thickbox');
  //Fix some problem about thickbox
  jQuery('body').removeClass('index-php');
  jQuery('#findfunction-input').keypress(function (e) {
    if (e.which === 13) {
      jQuery('#findfunction-button').trigger('click');
    }
  });
  //Search the function
  jQuery('#findfunction-button').click(function () {
    //Fix for the width
    jQuery('#TB_ajaxContent').css('width', parseInt(jQuery('#TB_window').css('width')) - 30);
    var data = {
      'ffsearch': 'search_the_function',
      'function': jQuery('#findfunction-input').val()
    };
    jQuery.get(window.location.href, data, function (response) {
      //Extract the output
      jQuery('#find-function-found').html(jQuery(response).find('#find-function-result').html());
    });
  });
});
