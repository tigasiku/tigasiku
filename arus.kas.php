<?php
if(isset($_GET['kd_bank'])){
			
	
	$kode_bank=$_GET['kd_bank'];	
}
elseif(isset($_POST['kd_bank'])){
	$kode_bank=$_POST['kd_bank'];	
}else{
	
	$kode_bank="";
}


if(isset($_POST['filter_dari'])){
$filter_dari=$_POST['filter_dari'];
$filter_sampai=$_POST['filter_sampai'];

}
elseif(isset($_GET['filter_dari'])){
$filter_dari=$_GET['filter_dari'];
$filter_sampai=$_GET['filter_sampai'];

}

else{
$filter_sampai=date("Y-m-d");
$filter_dari=date("Y-m-01");
	$filter_jenis="";
}

$tahun_awal=date("Y");
$tahun_ini=date("Y",strtotime($filter_dari));
$tahun_ini2=date("Y",strtotime($filter_dari));
$bulan_lalu=date("m",strtotime($filter_dari));
$bulan_awal=1;
if($bulan_lalu==1)
{
	$bulan_lalu=13-1;
	$tahun_ini2=$tahun_ini2-1;
	
}else{
	$bulan_lalu=$bulan_lalu-1;
}

$hari_terakhir=$tahun_ini2."-".$bulan_lalu."-01";
 $hari_terakhir=date("t",strtotime($bulan_lalu));
 $tgl_terakhir=$tahun_ini2."-".$bulan_lalu."-".date("t",strtotime($hari_terakhir));

$qrybank=mysqli_query($con,"select * from bank_perusahaan where kd_bank='".$kode_bank."'");
						$bank=mysqli_fetch_array($qrybank);
?>

<section class="content-header">
  <div class="pull-right" style="padding-right:5px"><a href="?page=mutasi.kas" data-toggle="tooltip" title="" class="btn btn-warning" data-original-title="Add New"><i class="fa fa-plus"></i> Mutasi Kas</a>
        
      </div>
	<h1>
		Arus Kas   <?php if(!empty($kode_bank)){ echo $bank[1] ?> <?php if(!empty($bank[2])) echo " - ".$bank[2] ?> <?php if(!empty($bank[3])) echo " - ".$bank[3] ; }?></h1>
</section>
<script type="text/javascript">
$(document).ready(function()
{
	$('table .save').click(function()
	{
		
		
			var id2 = $(this).parents().attr('id');
			var data3 = 'id=' + id2;
			var parent = $(this).parents()

			$.ajax(
			{
				   type: "POST",
				   url: "userInfo_material.php",
				   data:data3,
				   cache: false
				  
			 });
		
	});

	// style the table with alternate colors
	// sets specified color for every odd row
	$('table tr:odd');
});
</script>

<section class="content">
			<div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary" style="border-top-color: #34495e">
                                <div class="box-header">
                                 
                                    
                              </div><!-- /.box-header -->
                                <?php 				
					if(isset($_GET['pesan'])){?>  
                           	<div class="small-box bg-<?php if(($_GET['pesan']=="success")){ echo "green";}else{ echo  "red";} ?>">
                                		<div class="inner"><span style="font-weight:bold; font-size:18px"><?php echo $_GET['pesan'] ?> </span> 
                             			</div>
                        	</div><?php }?>
                                <div class="box-body" style="padding-top:0px;">
								<form action="?page=<?Php echo $page ?>" method="post">
        <div class="well">
          <div class="row">
           
            <div class="col-sm-4">
              <div class="form-group">
	                <label class="control-label" for="input-price">Dari Tanggal</label>
    	            <div class="input-group">
        	        	<input type="text" name="filter_dari" value="<?php echo @$filter_dari ?>" placeholder="Dari Tanggal" id="dp1" class="form-control" readonly>
                    	<div class="input-group-addon">
                        	<i class="fa fa-calendar"></i>
                        </div>
                    </div>
              </div>
               <div class="form-group">
	                <label class="control-label" for="input-price">Sampai Tanggal</label>
    	            <div class="input-group">
        	        	<input type="text" name="filter_sampai" value="<?php echo @$filter_sampai ?>" placeholder="Sampai Tanggal" id="dp2" class="form-control" readonly>
                   	<input type="hidden" name="user" value="<?php echo @$usernya ?>" class="form-control">
                   		<input type="hidden" name="nama" value="<?php echo @$namanya ?>" class="form-control">
                    	<div class="input-group-addon">
                        	<i class="fa fa-calendar"></i>
                        </div>
                    </div>
              </div>
            </div>
             <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-name">Dana Dari</label>
                 <select name="kd_bank"   class="form-control" id="pembayaran"  onChange="func2()">
                                                     <option value="">Pilih</option>
                                    	<?php 
												$qrybank=mysqli_query($con,"select * from bank_perusahaan order by kd_bank");
												while($bank=mysqli_fetch_array($qrybank)){
										?>
                                    	<option value="<?php echo $bank[0] ?>" <?php if($bank[0]==$kode_bank) echo "selected"  ?>><?php echo $bank[1] ?> <?php if(!empty($bank[2])) echo " - ".$bank[2] ?> <?php if(!empty($bank[3])) echo " - ".$bank[3] ?></option><?php } ?>
                                    	
									</select>
              </div>
             
            </div>
            <div class="col-sm-4">
           
              <div class="form-group">
                <label class="control-label" for="input-name">Uraian</label>
                <input type="text" name="filter_uraian" value="<?php echo @$filter_uraian ?>" placeholder="Uraian" id="input-name" class="form-control" autocomplete="off"><ul class="dropdown-menu"></ul>
              </div>
              <button type="submit" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Filter</button>
            </div>
          </div>
        </div>
         </form> 
                                     <h3>Kas <?php     if(!empty($filter_sampai) and !empty($filter_dari)){ echo date("d F Y",strtotime($filter_dari))." s/d "; echo date("d F Y",strtotime($filter_sampai)); }else{ echo date("F Y"); } ?> <a href="?page=tambah.mutasi.kas&id=<?php echo $kode_bank ?>" data-toggle="tooltip" title="" class="btn btn-primary pull-right" data-original-title="Add New"><i class="fa fa-plus"></i> Tambah</a></h3> 
                                   <div class="table-responsive">
                                        <table class="table table-hover table-bordered" style="margin-top:10px;">
                                        <tr>
                                            <th style="text-align:center;">No</th>
                                                <th style="text-align:center;">Deskripsi</th>
                                                   <th style="text-align:center;">Dana Dari</th>
                                            <th style="text-align:center;">Debet</th>
                                            <th style="text-align:center;">Kredit</th>
                                        
                                            <th style="text-align:center;">Saldo</th>
                                            <th style="text-align:center;">Aksi</th>
                                        </tr>
										<?php
									        	        	    
								

															$qry_debet=mysqli_query($con,"select  sum(nilai) as nilai from arus_kas where kd_bank like '%".$kode_bank."%' and tipe_kas='debet'  and kd_bank<>'' and tanggal between '01-01-2010  00:00:01' and '".@$tgl_terakhir." 23:59:59' and  kd_bank<>'Pilih'");
$saldo_debet_sebelumnya=mysqli_fetch_array($qry_debet);


															$qry_kredit=mysqli_query($con,"select  sum(nilai) as nilai from arus_kas where kd_bank like '%".$kode_bank."%' and tipe_kas='kredit'  and kd_bank<>'' and tanggal between '01-01-2010  00:00:01' and '".@$tgl_terakhir." 23:59:59' and  kd_bank<>'Pilih'");
$saldo_kredit_sebelumnya=mysqli_fetch_array($qry_kredit);

$saldo_awalan=($saldo_debet_sebelumnya['nilai']-$saldo_kredit_sebelumnya['nilai']);										
										
										
									   if(!empty($filter_sampai) and !empty($filter_dari)){
										$qry=mysqli_query($con,"select * from arus_kas where tanggal between '".$filter_dari." 00:00:00"."' and '".$filter_sampai." 23:59:00"."'  and keterangan like '%".@$filter_uraian."%' and  kd_bank like '%".$kode_bank."%'  group by day(tanggal),month(tanggal),year(tanggal) order by tanggal ");
									   }else{
										   $qry=mysqli_query($con,"select * from arus_kas  where  keterangan like '%".@$filter_uraian."%'  and  kd_bank like '%".$kode_bank."%' and  month(tanggal)='".date("m")."' and year(tanggal)='".date("Y")."'  and kd_bank<>'' and kd_bank<>'Pilih' group by day(tanggal),month(tanggal),year(tanggal) order by tanggal ");
									   }
										while($row2=mysqli_fetch_array($qry)){
										?>
                                        
                                        <tr>
                                           
										   
                                            <td style="text-align:left;" colspan="7"><?php echo date("d F Y",strtotime($row2['tanggal'])); ?></td>
                                            
                            
                                        </tr>
                                        <?php 
											
											 if(!empty($filter_sampai) and !empty($filter_dari)){
												 
												 	$qry_detil=mysqli_query($con,"select * from arus_kas,bank_perusahaan where arus_kas.kd_bank=bank_perusahaan.kd_bank and day(tanggal)='".date("d",strtotime($row2['tanggal']))."' and month(tanggal)='".date("m",strtotime($row2['tanggal']))."' and year(tanggal)='".date("Y",strtotime($row2['tanggal']))."' and keterangan like '%".@$filter_uraian."%' and  arus_kas.kd_bank like '%".$kode_bank."%'  and arus_kas.kd_bank<>'' and arus_kas.kd_bank<>'Pilih' order by tanggal asc ");
												 
											 }else{
												 
											 
										$qry_detil=mysqli_query($con,"select * from arus_kas,bank_perusahaan where  day(tanggal)='".date("d",strtotime($row2['tanggal']))."' and month(tanggal)='".date("m",strtotime($row2['tanggal']))."' and year(tanggal)='".date("Y",strtotime($row2['tanggal']))."' and arus_kas.kd_bank=bank_perusahaan.kd_bank and  keterangan like '%".@$filter_uraian."%'  and  arus_kas.kd_bank like '%".$kode_bank."%'  and arus_kas.kd_bank<>'' and arus_kas.kd_bank<>'Pilih' order by tanggal asc ");
											
											}
										while($row=mysqli_fetch_array($qry_detil)){
											
											
										?><?php if($saldo_awalan > 0){ ?>
                                      <tr >
                                           
										    <td style="text-align:center;" >&nbsp;</td>
                                            <td style="text-align:center;" >Saldo Awal</td>
                                             <td style="text-align:center;" >&nbsp;</td>
                                       
                                             <td style="text-align:center;" ><?php 
											
											 echo number_format($nilai_masuk=$saldo_awalan); ?></td>
                                             
                                              <td style="text-align:center;" ><?php 
											
											 echo number_format($nilai_keluar=$saldo_kredit); ?></td>
                                             
                                         <td style="text-align:center;" ><span class="" style="text-align:center;">
                                           <?php 
										 
										
											 $saldo2=$nilai_masuk-$nilai_keluar; 
									
										 echo number_format($saldo2);
										?>
                                         </span></td>
                                                               
                                         <td></td>
                                       
                                      
                                      
                                      </tr><?php }  ?>
                                        <tr class="  " id="<?php echo $row['0'] ?>">
                                           
										    <td style="text-align:center;" class=""><?php echo $i; ?></td>
                                            <td style="text-align:center;" class=""><?php echo ($row['keterangan']);  ?></td>
                                             <td style="text-align:center;" class=""><?php echo $row['nama_bank'] ?> <?php if(!empty($row['no_rek'])) echo " <br> ".$row['no_rek'] ?> <?php if(!empty($row['atas_nama'])) echo " <br> ".$row['atas_nama'] ?></td>
                                       
                                             <td style="text-align:center;" class=""><?php 
											 if($row['tipe_kas']=="debet"){
											 echo number_format($nilai_masuk=$row['nilai']);} ?></td>
                                             
                                              <td style="text-align:center;" class=""><?php  if($row['tipe_kas']=="kredit"){
											 echo number_format($nilai_keluar=$row['nilai']);} ?></td>
                                             
                                         <td style="text-align:center;" class=""><?php 
										 
										if($row['tipe_kas']=="debet"){
										 $saldo=$nilai_masuk; 
										}else{
											 $saldo=$nilai_keluar; 
										}
										
										 if($row['tipe_kas']=="debet"){@$saldo2=$saldo2+$saldo;}else{@$saldo2=$saldo2-$saldo;}
										 echo number_format($saldo2);
										?></td>
                                   
               <td style="text-align:center;">
                                           
											<a class="btn btn-xs btn-warning" href="?page=edit.mutasi.kas&id=<?php echo $row['0']?>"><span class="fa fa-edit"></span>Edit</a>
										     <?php if($_SESSION['loglevel']=="Administrator"){ ?> 
											 <a href="hapus.mutasi.kas.php?id=<?php echo $row['0']?>" class="hapus"><span class="fa fa-trash-o"></span></a></td> <?php } ?>
                                        <?php
										$i++;
											$saldo_awalan=0;
										}$saldo_awalan=0;
										}$saldo_awalan=0;
										?>
                                    <tr>
                                            <th style="text-align:center;">&nbsp;</th>
                                                <th style="text-align:center;">&nbsp;</th>
                                                   <th style="text-align:center;">&nbsp;</th>
                                            <th style="text-align:center;"><?php 
												
												
											 if(!empty($filter_sampai) and !empty($filter_dari)){
												 
												 	$debet=mysqli_fetch_array(mysqli_query($con,"select sum(nilai) as total from arus_kas where tanggal between '".$filter_dari." 00:00:00"."' and '".$filter_sampai." 23:59:00"."'  and keterangan like '%".@$filter_uraian."%'  and tipe_kas='debet' and  kd_bank like '%".$kode_bank."%'  and kd_bank<>'' and kd_bank<>'Pilih'"));
												 
											 }else{
												 
											 
												$debet=mysqli_fetch_array(mysqli_query($con,"select sum(nilai) as total from arus_kas where  keterangan like '%".@$filter_uraian."%' and tipe_kas='debet' and  kd_bank like '%".$kode_bank."%'  and kd_bank<>'' and kd_bank<>'Pilih'"));
											
											 }
												echo number_format($debet['total']+@$saldo_awal[0]);
												
												 ?></th>
                                            <th style="text-align:center;"><?php 
												
												
											 if(!empty($filter_sampai) and !empty($filter_dari)){
												 
												 	$kredit=mysqli_fetch_array(mysqli_query($con,"select sum(nilai) as total from arus_kas where tanggal between '".$filter_dari." 00:00:00"."' and '".$filter_sampai." 23:59:00"."' and keterangan like '%".@$filter_uraian."%' and tipe_kas='kredit' and  kd_bank like '%".$kode_bank."%'  and kd_bank <>'' and kd_bank<>'Pilih'"));
												 
											 }else{
												 
											 
												$kredit=mysqli_fetch_array(mysqli_query($con,"select sum(nilai) as total from arus_kas where  keterangan like '%".@$filter_uraian."%'  and tipe_kas='kredit' and  kd_bank like '%".$kode_bank."%'  and kd_bank<>'' and kd_bank<>'Pilih'"));
											
											 }
												echo number_format($kredit['total']);
												
												 ?></th>
                                        
                                            <th style="text-align:center;" colspan="2">&nbsp;</th>
                                            
                                      </tr>
                                    </table>
                                </div><!-- /.box-body -->
								</div>
                                <div class="box-footer clearfix">
								
                                </div>
                            </div><!-- /.box -->
                        </div>
                    </div>
</section><!-- /.content -->
<style type="text/css">
table tr.active {background-color: #ffc892 !important;}
	
table, table tr, table tr td {margin: 0; padding: 0; border: 0; cursor: pointer;}
table tr.active td {background-color: #ffc892 !important; }
.table>thead>tr>.active, .table>tbody>tr>.active, .table>tfoot>tr>.active, .table>thead>.active>td, .table>tbody>.active>td, .table>tfoot>.active>td, .table>thead>.active>th, .table>tbody>.active>th, .table>tfoot>.active>th {
    background-color: #ffc892;
}
</style>
<?php

?>
<script>
$( ".hapus" ).click(function( event ) {

	 var setuju=confirm("Apakah Anda Yakin Untuk Menghapus Data?");
  if ( setuju ) {
   
    return;
  }
 

  event.preventDefault();
});
</script>