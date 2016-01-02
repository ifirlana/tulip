$('document').ready(function(){
	//hover
	$('#buku tbody tr:even').addClass('even');
	
	//filter
	$('input[name="filter"]').live('keyup', function(e){
		if(e.which == 27) { $(this).val(''); $('#buku tbody tr').removeClass('visible'); }
		
		var val = $.trim($(this).val());
		$('#buku tbody tr').each(function(){
			($(this).find('td:eq(1)').text().search(new RegExp(val, "i")) < 0 ) ? $(this).removeClass('visible').hide() : $(this).addClass('visible').show();
			
		$('#buku tbody tr').removeClass('even'); 
		$('#buku tbody tr.visible:even').addClass('even');
		});
	});
	  
});