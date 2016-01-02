//base_url = 'http://localhost/tulip/';
window.onload = function () {
	new Ajax.Autocompleter("strnama_upline", "autocomplete_choices", base_url+"admin/penjualan/ajaxsearch", {
		minChars: 2, 
		indicator: 'indicator1'	,
		afterUpdateElement : getSelectionId
	});

	$('starterkitForm').onsubmit = function () {
		inline_results();
		return false;	
	}
}

function getSelectionId(text, li) {
	inline_results();
}


function inline_results() {
	new Ajax.Updater ('strkode_upline', base_url+'admin/penjualan/ajaxsearch', {method:'post', postBody:'kode_upline=true&strnama_upline='+$F('strnama_upline')});
	new Effect.Appear('strkode_upline');

}