$(function  () {
	$('#paynow').click(function  () {
		$('.step3').slideDown();
		$('.indicator').animate({top:"516px"},"slow");
	});
	$('form').submit(function (e) {
          nameV('name0');
          mobileV('phone0');
          addrV('timelineinput');

          var validate = setInterval(function () {
              nameV('name0');
              mobileV('phone0');
              addrV('timelineinput');
          } , 500);

          if (!(nameV('name0') && mobileV('phone0') && addrV('timelineinput'))) {
              return false;
          }
          if (validate) clearInterval(validate);
    })
	$('#update_add').click(function  () {
		$('.step4').slideDown();
		$('.step5').slideDown();
		$('.indicator').animate({top:"988px"},"slow");
	});
});