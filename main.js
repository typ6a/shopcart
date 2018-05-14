$( document ).ready(function(){
	$('button.addToCart').on('click',function(){
		var id = $(this).closest( 'tr' ).attr('productId');
		var qty = $(this).closest( 'tr' ).find( 'input' ).val();
		// var transport = $(this).closest( 'tr' ).find( '.transport' ).val();
			console.log(qty);
		$.ajax({
			type: 'GET',
			url: 'ajax.php?id='+id+'&qty='+qty+'&action=add'
		})
		.done(function()
		{
			// alert('Product have been added.');
		});
	});

	$('button.refresh').on('click',function(){
		var id = $(this).closest( 'tr' ).attr('productId');
		var qty = $(this).closest( 'tr' ).find( 'input' ).val();
		var transport = $(this).closest( 'tr' ).find( 'select.transport' ).val();
		// var transport = $(this).closest( 'tr' ).find( '.transport' ).val();
			console.log(qty);
		$.ajax({
			type: 'GET',
			url: 'ajax.php?id='+id+'&qty='+qty+'&transport='+transport+'&action=add'
		})
		.done(function()
		{
			// alert('Product have been added.');
		});
	});

	$('button.rate').on('click',function(){
		var id = $(this).closest( 'tr' ).attr('productId');
		var qty = $(this).closest( 'tr' ).attr('productId');
			console.log(id);
		// $.ajax({
		// 	type: 'GET',
		// 	url: 'ajax.php?id='+id+'&action=add'
		// })
		// .done(function()
		// {
		// 	alert('Product have been added.');
		// 	console.log('addddddddddd');
		// });
	});

	$('span.removeFromCart').on('click',function(){
		var id = $(this).attr('data-id');
		$.ajax({
			type: 'GET',
			url: 'ajax.php?id='+id+'&action=remove'
		})
		.done(function()
		{
			alert('Product have been removed.');
			location.reload();
		});
	});
	$('a.emptyCart').on('click',function(){
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