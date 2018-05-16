$(document).ready(function()
{
	$('button.addToCart').on('click',function()
	{
		var id = $(this).closest( 'tr' ).attr('productId');
		var qty = $(this).closest( 'tr' ).find( 'input' ).val();
		$.ajax({
			type: 'GET',
			url: 'ajax.php?id='+id+'&qty='+qty+'&action=add'
		})
		.done(function()
		{
			alert('Product have been added.');
		});
	});

	$('button.update').on('click',function()
	{
		var id = $(this).closest( 'tr' ).attr('productId');
		var qty = $(this).closest( 'tr' ).find( 'input' ).val();
			console.log(qty);
		$.ajax({
			type: 'GET',
			url: 'ajax.php?id='+id+'&qty='+qty+'&action=update'
		})
		.done(function()
		{
			location.reload();
		});
	});
	$('a.pay').on('click',function()
	{
		var transport = +$( 'select.transport' ).val();
		var cash = $('.cash').text();
		var cost = +$('.cost').text() + transport;
		var rest = cash - cost;
		if (rest < 0)
		{
			alert('You have not enough money.');
			return false;
		}
		if (isNaN(transport))
		{
			alert('You have to select a transport.');
			return false;
		}
		alert('Your order costs $'+cost+' including transport costs');
	});

	$('button.rate').on('click',function()
	{
		var id = $(this).closest( 'tr' ).attr('productId');
		var rate = $(this).closest( 'tr' ).find( 'select.rateSelect' ).val();
		$.ajax({
			type: 'GET',
			url: 'ajax.php?id='+id+'&rate='+rate+'&action=rate'
		})
		.done(function()
		{
			location.reload();
		});
	});

	$('button.removeFromCart').on('click',function()
	{
		var id = $(this).closest( 'tr' ).attr('productId');
		$.ajax({
			type: 'GET',
			url: 'ajax.php?id='+id+'&action=remove'
		})
		.done(function()
		{
			location.reload();
		});
	});
	$('a.emptyCart').on('click',function()
	{
		$.ajax({
			type: 'GET',
			url: 'ajax.php?action=empty'
		})
		.done(function()
		{
			alert('Cart been emptied.');
			location.reload();
		});
	});
});
