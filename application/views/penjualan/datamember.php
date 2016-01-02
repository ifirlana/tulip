<script type="text/javascript">
         $(document).ready( function() {
            /////////////////end///////////////
            $("#intid_unit").autocomplete({
                minLength: 2,
                source:
                    function(req, add){
                    $.ajax({
                        url: "<?php echo base_url(); ?>penjualan/lookupUnit",
                        dataType: 'json',
                        type: 'POST',
                        data: req,
                        success:
                            function(data){
                            if(data.response =="true"){
                                add(data.message);
                                }
                            },
                        });
                    },
                focus:
                    function(event,ui) {
                    var q = $(this).val();
                    $(this).val() = q;
                    },
                            select:
                                function(event, ui) {
                    $("#strnama_dealer").val("");
                    $("#result001").empty();
                    $("#result").empty();
                                $("#result").append(
                                "<input type='text' id='id_unit' name='id_unit' value='" + ui.item.id + "' size='10' />"
                            );
                        },
                    });
            $("#strnama_dealer").autocomplete({
                minLength: 2,
                source:
                    function(req, add){
                    $.ajax({
                        url: "<?php echo base_url(); ?>penjualan/lookupUpline",
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            term: req.term,
                            state: $('#id_unit').val(),

                        },
                        success:
                            function(data){
                            if(data.response =="true"){
                                add(data.message);
                            }
                        },
                    });
                },
                focus:
                    function(event,ui) {
                    var q = $(this).val();
                    $(this).val() = q;
                    },
                            select:
                                function(event, ui) {
                    $("#track1").val(0);
                    $("#track2").val(0);
                    $("#track3").val(0);
                    $("#track4").val(0);
                    $("#track5").val(0);
                    $("#track6").val(0);
                    $("#metal_1").attr("disabled","disabled");
                    $("#metal_2").attr("disabled","disabled");
                    $("#metal_3").attr("disabled","disabled");
                    $("#metal_4").attr("disabled","disabled");
                    $("#metal_5").attr("disabled","disabled");
                    $("#metal_6").attr("disabled","disabled");
                                $("#result001").empty();
                                $("#result001").append(
                                    "<input type='text' align='top' id='strkode_dealer' name='strkode_dealer' value='" + ui.item.id + "' readonly/><br><td><input type='text' id='strkode_upline' name='strkode_upline' value='" + ui.item.value2 + "' size='30' readonly/></td>"
                    );
                    if(ui.item.value4 == 0) {$("#metal_1").removeAttr("disabled");} else {$("#track1").val(1);}
                    if(ui.item.value5 == 0) {$("#metal_2").removeAttr("disabled");} else {$("#track2").val(1);}
                    if(ui.item.value6 == 0) {$("#metal_3").removeAttr("disabled");} else {$("#track3").val(1);}
                    if(ui.item.value7 == 0) {$("#metal_4").removeAttr("disabled");} else {$("#track4").val(1);}
                    if(ui.item.value8 == 0) {$("#metal_5").removeAttr("disabled");} else {$("#track5").val(1);}
                    if(ui.item.value9 == 0) {$("#metal_6").removeAttr("disabled");} else {$("#track6").val(1);}
                            },
                });
            $("#strnama_upline").autocomplete({
                minLength: 2,
                source:
                    function(req, add){
                    $.ajax({
                        url: "<?php echo base_url(); ?>penjualan/lookupUpline",
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            term: req.term,
                            state: $('#id_unit').val(),

                        },
                        success:
                            function(data){
                            if(data.response =="true"){
                                add(data.message);
                            }
                        },
                    });
                },
            });
            autoComp();
         $("#otomatis").bind('click',function(){
            if($(".otomatis_1").attr('checked') == true && $("#otomatis").val() == 'scan'){
                alert('test');
            }
            if($(".otomatis_2").attr('checked') == true && $("#otomatis").val() == 'input'){
                alert('ho');
            }
         });
        });
        function switching_mode(id){
            if($('.otomatis_'+id).attr('checked') == true){
                if($('.otomatis_'+id).val() == 'scan'){
                    set_null_datamember();
                    $('#intid_unit').attr('readonly','readonly');
                    $('#strnama_dealer').attr('readonly','readonly');
                    $('#data_form_scanner').show();
                }else if($('.otomatis_'+id).val() == 'input'){
                    set_null_datamember();
                    $('#intid_unit').removeAttr('readonly','readonly');
                    $('#strnama_dealer').removeAttr('readonly','readonly');
                    $('#data_form_scanner').hide();
                }
            }
        function set_null_datamember(){
            $('#modulscan').val('');
            $('#intid_unit').val('');
            $('#strnama_dealer').val('');
            $('#result').html('');
            $('#result001').html('');
            }
        }
    </script>
    <div id='data_form_manual'>
        <table width="685" border="0" id="data" class="data_member" align="center">
       <tr>
            <td width="107"><input type='radio' id='1' class='otomatis_1' name='otomatis' value='scan' checked='checked' onclick='switching_mode(this.id)' />scan barcode</td>
            <td width="316">&nbsp;</td>
            <td width="35">&nbsp;</td>
            
            <td >&nbsp;<?php echo $cabang; ?>
            <input type="hidden" name="intid_cabang" size="30" readonly="readonly" value="<?php echo $id_cabang; ?>">         </td>
            <td>&nbsp;,</td>
            <td>&nbsp;<?php echo date("d-m-Y");?></td>
        </tr>
        <tr>
            <td><input type='radio' id='2' class='otomatis_2' name='otomatis' value='input' onclick='switching_mode(this.id)' />manual</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;Unit</td>
            <td>&nbsp;:</td>
            <td><input type="text" name="textfield4" id="intid_unit"  size="25"/></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td width="82">&nbsp;Nama</td>
            <td width="7">&nbsp;:</td>
            <td width="213"><input type="text" name="strnama_dealer" id="strnama_dealer" size="25"/></td>
        </tr>
    </table>
    </div>
   