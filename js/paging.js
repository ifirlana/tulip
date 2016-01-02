$('document').ready(function(){
	//hover
	$('#buku tbody tr:even').addClass('even');
	
	//paging
	$('.paging a').live('click', function(){
		$('.kandang').load($(this).attr('href')+' #kotak', function(){
			$('#buku tbody tr:even').addClass('even');		
		}); return false;
	});
});