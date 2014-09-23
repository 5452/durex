$(function () {
	var contEle = null;
	
	var oriContVal = null;

	var thisTotalPri = null;

	var singlePri = 1;

	var plusBtn = $('.plus');
	var minusBtn = $('.minus');

	var currentContVal = null;

	$('.inputCont').focus(function(){
		oriContVal = $(this).val();
		contEle = $(this);
		thisTotalPri = $(this).parents('.pro_info').next('.pro_action').find('.totalPrice');
	}).blur(function  () {
		var validatedEle = $(this).val();
		countValidation(validatedEle,oriContVal,contEle);
		currentContVal = $(this).val();
		thisTotalPri.text(calculateTotal(singlePri,currentContVal));
	});

	var added_reduced = 0;

	plusBtn.click(function(){
		var currentContValBar = $(this).siblings(".inputCont");
		//取到点击之前的数量
		currentContVal = $(this).siblings(".inputCont").val();
		added_reduced = plus_minus(true,currentContValBar);
		//取显示的价格
		thisTotalPri = $(this).parents('.pro_info').next('.pro_action').find('.totalPrice');	
		// console.log(currentContVal);
		thisTotalPri.text(calculateTotal(singlePri,added_reduced));
	});
	minusBtn.click(function(){
		var currentContValBar = $(this).siblings(".inputCont");
		currentContVal = $(this).siblings(".inputCont").val();
		added_reduced = plus_minus(false,currentContValBar);
		thisTotalPri = $(this).parents('.pro_info').next('.pro_action').find('.totalPrice');	
		thisTotalPri.text(calculateTotal(singlePri,added_reduced));
	});
	
	function plus_minus(pORm,currentContValBar) {
		
		if (pORm) {
			return plus(currentContVal,currentContValBar);
		}else{
			return minus(currentContVal,currentContValBar);
		}
		
	}
});

function calculateTotal(singlePriPra,currentContValPra){
	var totalPrice = 0;
	totalPrice = singlePriPra*currentContValPra;
	return totalPrice;
}

function countValidation(countVal,oriContValPar,contElePar)  {

	if($.isNumeric(countVal)&&parseInt(countVal)==countVal){
		if (countVal>99999) {
			contElePar.val(oriContValPar);
			$('#if_not_num').modal({
				backdrop:true,
				keyboard:false
			});
		}else if(countVal<1){
			contElePar.val(oriContValPar);
			$('#if_not_num').modal({
				backdrop:true,
				keyboard:false
			});
		}
	}else{
		contElePar.val(oriContValPar);
		$('#if_not_num').modal({
			backdrop:true,
			keyboard:false
		});
	}
}

function plus (currentContValPar,contElePar) {
	
	var count = parseInt(currentContValPar);
	if (currentContValPar<99999) {
		contElePar.val(count+1);
		return count+1;
	}else{
		return false;
	}
}

function minus (currentContValPar,contElePar) {
	var count = parseInt(currentContValPar);
	if (currentContValPar>1) {
		contElePar.val(count-1);
		return count-1;
	}else{
		return false;
	}	
}