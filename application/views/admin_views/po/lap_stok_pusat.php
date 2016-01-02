<?php $this->load->helper('HTML');
echo link_tag('css/style2.css');
echo link_tag('images/favicon.ico','shortcut icon','image/x-icon');
?></head>
<div id="page1">
    <div id="wrapper">
        <?php $this->load->view('admin_views/header'); ?><hr />

    </div>
    <div id="page">
        <div id="page-bgtop">
            <div id="content">
                <div class="post">
                    <h2 class="title">Laporan Stok Pusat</h2>
                    <div class="entry">
                        <form action="<?php echo $form_action?>" method="post">
                        <table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
                            <tr>
                        
                                <td style="width:75%" ><b><?php //echo "Jumlah Data : ". $jumlah_data;?>Filter Bulan : </b><?php echo $combo_bulan?>
                                    <input type="submit" name="submit" value="Cari"> </td></tr>
                            <tr><td></td> </tr>
                        </table>
                      </form>
                        <table width="90%" border="0" cellpadding="1" cellspacing="1" id="data" align="center">
                            <thead>
                                <tr   class="table" align="center" >
                                  <th width="27" >&nbsp;</th>
                                  <th width="183">&nbsp;</th>
                                  <th colspan="2">Stok Awal</th>
                                  <th colspan="2">Masuk</th>
                                  <th colspan="2" >Keluar</th>
                                  <th colspan="2" >Akhir</th>
                                </tr>
                                <tr   class="table" align="center" >
                                    <th >No</th>
                                    <th>Item</th>
                                    <th width="83">Set</th>
                                    <th width="81" >Pcs</th>
                                  <th width="82">Set</th>
                                  <th >Pcs</th>
                                    <th >Set</th>
                                    <th >Pcs</th>
                                    <th >Set</th>
                                    <th >Pcs</th>
                                </tr>
                            </thead>
                            <tbody>

                                <!-- ============isi ============ -->

                                <?php
                                $i=1;
foreach($week as $m) : 
    ?>

                                <tr class='data' align='center'>
                                    <td ><?php echo $i++; ?></td>
                                    <td align='left'>&nbsp;<?php //echo $m->intid_week; ?></td>
                                    <td align='left'>&nbsp;<?php //echo $this->Week_model->nama_bulan($m->intbulan); ?></td>
                                    <td align='left'>&nbsp;<?php //echo date('d-F-Y', strtotime($m->dateweek_start)); ?></td>
                                    <td align='left'>&nbsp;<?php //echo date('d-F-Y', strtotime($m->dateweek_end)); ?></td>
                                  <td align="center" width="75">&nbsp;</td>
                                  <td align="center" width="78">&nbsp;</td>
                                    <td align="center" width="81">&nbsp;</td>
                                    <td align="center" width="64">&nbsp;</td>
                                    <td align="center" width="82">&nbsp;</td>
                              </tr>
<?php endforeach; ?> 
                            </tbody>
                        </table>
                        <table width="95%" border="0" cellpadding="0" cellspacing="0" id="data" align="center">
                            <tr>
                                <td align="left" ><?php echo $pagination; ?></td>
                                <td align="right" width="60%">&nbsp;<a href="<?php echo base_url()?>event"  title="Kembali ke menu event" ><img  src="<?php echo base_url()?>images/img12.png" align="absmiddle"/><font size="2"> Kembali</font></a></td></tr>
                        </table>

                    </div>
                </div>

            </div>
            <!-- end #content -->
<?php $this->load->view('admin_views/sidebar_po'); ?><!-- end #sidebar -->
            <div style="clear: both;">&nbsp;</div>
        </div>
    </div>
    <!-- end #page -->
    <div id="footer-bgcontent">
<?php $this->load->view('admin_views/footer'); ?></div>
    <!-- end #footer -->

