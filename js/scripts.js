function submitFormLim(lim){
  var x = document.getElementsByName("limit");
    x[0].value=lim;
  var x = document.getElementsByName("limitstart");
    x[0].value=0;
    document.forms['adminForm'].submit();
}

function submitFormLimStart(limS){
  var x = document.getElementsByName("limitstart");
    x[0].value=limS;
    document.forms['adminForm'].submit();
}

function count(obj) {
    var count = 0;
    for(var prs in obj){
      if(obj.hasOwnProperty(prs)) count++;
    }
    return count;
}

$(function() {
    $(window).scroll(function() {
      if($(this).scrollTop() != 0) {
        $('#toTop').fadeIn();
      } else {
        $('#toTop').fadeOut();
      }

    });
    $('#toTop').click(function() {
      $('body,html').animate({scrollTop:0},800);
    });

  });

  jQuery.fn.ForceNumericOnly =
  function()
  {
      return this.each(function()
      {
          $(this).keydown(function(e)
          {
              var key = e.charCode || e.keyCode || 0;
              // ��������� backspace, tab, delete, �������, ������� ����� � ����� �� �������������� ����������
        //  alert(($('#filtr_kodu').val().length)+1);
            return (
                key == 8 ||
                key == 9 ||
                key == 46 ||
                (key >= 37 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
              });

      });
  };