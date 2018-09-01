<?php include(dirname(__FILE__)."/v_kpims_main.php") ?>
<style>
	th{
        text-align: left;
	}
</style>
<script>
	$(document).ready( function () {
		get_data();
		
		$('#search').keyup(function() {
			var data = this.value.split(" ");
			var rows = $('#tb_modal_add_resm').find('tr');
            var rows2 = $('#tb_modal_add_resm').find('tr.department');
			if (this.value == "") {
				rows.show();
				return;
			}
			rows.hide().filter(function() {
				var $t = $(this);
				for (var d = 0; d < data.length; ++d) {
					if ($t.is(":contains('" + data[d] + "')")) {
						return true;
					}
				}
				return false;
			}).show();
            rows2.hide();
		});
		
		<?php if(count($rs_resm) > 0){?>
			$('#btn_add_resm').attr('disabled','');
			$('#note').html('&nbsp;&nbsp;&nbsp;<span id="note_descpt" class="text-danger">*ลบผู้รับผิดชอบเพื่อเพิ่มผู้รับผิดชอบใหม่</span>');
			$('#btn_add_resm').removeAttr('onclick');
		<?php }else{?>
			$('#btn_add_resm').removeAttr('disabled');
			$('#note').html('<br>');
		<?php }?>
    });
	
	function get_data(){
		var dfine_id = '<?php echo $dfine_id; ?>';
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('/Define_responsibility_main/get_data');?>",
			data: {'dfine_id': dfine_id},
			dataType : "json",
			success : function(data){
				// console.log(data);
				// $('#modal_define_indicator').modal('toggle');
				$('#tb_res').html(data);
				// btn_del_all
				// notify_edit("");
				// get_data();
			}//End success
		});
	}
	
	function get_resm(chk_modal,resm_id){
		var dfine_id = '<?php echo $dfine_id; ?>';
		$('#modal_add_resm').modal({show:true});
		$("#modal_add_resm").animate({ scrollTop: 0 }, 'fast');
		$('#search').val("");
		
		$('#div_search').hide();
		$('#tb_data').hide();
		$('#md_add_footer').hide();
		$('#row_loading_out').show();
		
		if(chk_modal == 0){
			$("#head_madal_addres").text("เพิ่มผู้รับผิดชอบตัวชี้วัด");
			$("#hid_btn_chk").val(0);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('/Define_responsibility_main/get_resm');?>",
				data: {'dfine_id': dfine_id},
				dataType : "json",
				success : function(data){
					$('#div_search').show();
					$('#tb_data').show();
					$('#md_add_footer').show();
					$('#row_loading_out').hide();
					$('#tb_modal_res').html(data);
				}//End success
			});
		}else if(chk_modal == 1){
			$("#head_madal_addres").text("เพิ่มผู้รับผิดชอบร่วม");
			$("#hid_btn_chk").val(1);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('/Define_responsibility_main/get_ress');?>",
				data: {'dfine_id': dfine_id, 'resm_id': resm_id},
				dataType : "json",
				success : function(data){
					$('#div_search').show();
					$('#tb_data').show();
					$('#md_add_footer').show();
					$('#row_loading_out').hide();
					$('#tb_modal_res').html(data);
				}//End success
			});
		}
		
	}
	
	function save_resm(){
		var dfine_id = '<?php echo $dfine_id; ?>';
		var btn_chk = $("#hid_btn_chk").val();
		if(btn_chk == 0){
			var ps_id = $('input:radio[name=chk_ps_add]:checked').val();
			// var ps_checked = [];
			// $("input:checkbox[name=chk_ps_add]:checked").each(function() {
				// ps_checked.push($(this).attr('value'));
			// });
			$('#div_search').hide();
			$('#tb_data').hide();
			$('#md_add_footer').hide();
			$('#row_loading_out').show();
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('/Define_responsibility_main/save_resm');?>",
				data: {'ps_id' : ps_id, 'dfine_id' : dfine_id},
				success : function(data){
					$('#modal_add_resm').modal('toggle');
					notify_save("");
					get_data();
					$('#div_search').show();
					$('#tb_data').show();
					$('#md_add_footer').show();
					$('#row_loading_out').hide();
					// $('#btn_del_all').attr('disabled','');
					$('#btn_del_all').removeAttr('disabled');
					$('#btn_add_resm').attr('disabled','');
					$('#btn_add_resm').removeAttr('onclick');
					$('#note').html('&nbsp;&nbsp;&nbsp;<span id="note_descpt" class="text-danger">*ลบผู้รับผิดชอบเพื่อเพิ่มผู้รับผิดชอบใหม่</span>');
					
				}
			});
		}else if(btn_chk == 1){
			var resm_id = $("#hid_resm_id").val();
			var ps_id = $('input:checkbox[name=chk_ps_add]:checked').val();
			var ps_checked = [];
			$("input:checkbox[name=chk_ps_add]:checked").each(function() {
				ps_checked.push($(this).attr('value'));
			});
			$('#div_search').hide();
			$('#tb_data').hide();
			$('#md_add_footer').hide();
			$('#row_loading_out').show();
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('/Define_responsibility_main/save_ress');?>",
				data: {'ps_checked' : ps_checked, 'resm_id' : resm_id},
				success : function(data){
					$('#modal_add_resm').modal('toggle');
					notify_save("");
					get_data();
					$('#div_search').show();
					$('#tb_data').show();
					$('#md_add_footer').show();
					$('#row_loading_out').hide();
				}
			});
		}
	} //End fn save_resm
	
	function del_resm(resm_id, dfine_id){
		swal({ //start swal
			title: "คุณต้องการลบใช่หรือไม่?",
			text: "หากลบแล้วจะไม่สามารถกู้คืนได้อีก!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#dd4b39",
			confirmButtonText: "ยืนยัน",
			closeOnConfirm: true ,
			cancelButtonText: 'ยกเลิก'
		},function(){
            $.ajax({
				type: "POST",
				url: "<?php echo site_url('/Define_responsibility_main/del_resm');?>",
				data: {'resm_id' : resm_id, 'dfine_id' : dfine_id},
				success : function(data){
					var data = jQuery.parseJSON(data);
					notify_del("");
					get_data();
					
					if(data.length == 0){
						$('#btn_del_all').attr('disabled','');
					}else{
						$('#btn_del_all').removeAttr('disabled');
					}
					$('#btn_add_resm').removeAttr('disabled');
					$('#btn_add_resm').attr('onclick','get_resm("0","0")');
					$('#note').html('<br>');
				}
			});
            // swal('ดำเนินการลบสำเร็จ','ข้อมูลที่คุณเลือกได้ลบออกจากระบบแล้ว', "success");
		});	//End swal
	} //End fn del_resm
	
	// function del_all_resm(dfine_id){
		// swal({ //start swal
			// title: "คุณต้องการลบใช่หรือไม่?",
			// text: "หากลบแล้วจะไม่สามารถกู้คืนได้อีก!",
			// type: "warning",
			// showCancelButton: true,
			// confirmButtonColor: "#dd4b39",
			// confirmButtonText: "ยืนยัน",
			// closeOnConfirm: true ,
			// cancelButtonText: 'ยกเลิก'
		// },function(){
            // $.ajax({
				// type: "POST",
				// url: "<?php echo site_url('/Define_responsibility_main/del_all_resm');?>",
				// data: {'dfine_id' : dfine_id},
				// success : function(data){
					// notify_del("");
					// get_data();
					// $('#btn_del_all').attr('disabled','');
				// }
			// });
		// });	//End swal
	// }
	
	function del_ress(ress_id,ress_resm_id){
		// alert(ress_resm_id);
		swal({ //start swal
			title: "คุณต้องการลบใช่หรือไม่?",
			text: "หากลบแล้วจะไม่สามารถกู้คืนได้อีก!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#dd4b39",
			confirmButtonText: "ยืนยัน",
			closeOnConfirm: true ,
			cancelButtonText: 'ยกเลิก'
		},function(){
            $.ajax({
				type: "POST",
				url: "<?php echo site_url('/Define_responsibility_main/del_ress');?>",
				data: {'ress_id' : ress_id, 'resm_id' : ress_resm_id},
				success : function(data){
					if(data == 1){
						notify_del("");
						get_info_ress(ress_resm_id);
						get_data();
					}else{
						$('#modal_info_ress').modal('toggle');
						get_info_ress(ress_resm_id);
						get_data();
					}
				}
			});
            // swal('ดำเนินการลบสำเร็จ','ข้อมูลที่คุณเลือกได้ลบออกจากระบบแล้ว', "success");
		});	//End swal
	}
	
	function del_all_ress(){
		var resm_id = $("#hid_modal_info_resm_id").val();
		swal({ //start swal
			title: "คุณต้องการลบใช่หรือไม่?",
			text: "หากลบแล้วจะไม่สามารถกู้คืนได้อีก!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#dd4b39",
			confirmButtonText: "ยืนยัน",
			closeOnConfirm: true ,
			cancelButtonText: 'ยกเลิก'
		},function(){
            $.ajax({
				type: "POST",
				url: "<?php echo site_url('/Define_responsibility_main/del_all_ress');?>",
				data: {'resm_id' : resm_id},
				success : function(data){
					notify_del("");
					get_data();
					$('#modal_info_ress').modal('toggle');
				}
			});
            // swal('ดำเนินการลบสำเร็จ','ข้อมูลที่คุณเลือกได้ลบออกจากระบบแล้ว', "success");
		});	//End swal
	} //End fn del_all_ress
	
	function checkAll_person_add(){
		var checkboxes = $(".chk_preson_add");
		if($("#checkAll_add").is(':checked')){ //Start if
			for(var i = 0; i < checkboxes.length; i++){ //Start for
				// console.log(i)
				if (checkboxes[i].type == 'checkbox'){ //Start if
					checkboxes[i].checked = true;
				} //End if
			} //End for
		}else{
			for(var i = 0; i < checkboxes.length; i++){ //Start for
				// console.log(i)
				if(checkboxes[i].type == 'checkbox'){ //Start if
					checkboxes[i].checked = false;
				} //End if
			} //End for
		} //End if else
	} //End fn checkAll_person

	function get_info_ress(resm_id){
		$.ajax({
            type: "POST",
            url: "<?php echo site_url().'/Define_responsibility_main/get_info_ress'; ?>",
            data: {'resm_id': resm_id},
            dataType : "json",
            success : function(data){
				// $('#modal_info_ress').modal('toggle');
				// var row = "";
				// $(data).each(function(seq, data) {
					// seq++;			
				// });
				$("#hid_modal_info_resm_id").val(resm_id);
				$("#tb_modal_info").html(data);	
            }
        });
		
	}
</script>


<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid box-primary">
            <div class="box-header with-border">
                <i class="fa fa-edit"></i>
                <h2 class="box-title">กำหนดผู้รับผิดชอบตัวชี้วัด</h2>
                <!-- <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                    <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                    <i class="fa fa-times"></i></button>
                </div> -->
            </div>
            
            <div class="box-body">
                <div class="col-md-3">	
                   
                </div>
                <div class="col-md-12"><!-- Start  col-md-12 -->
                    <div class="box box-solid">
						<form id="frm_modal_add"> <!-- Start form -->
							<div class="form-group"> <!-- Start form-group -->
								<table id="" class="table table-bordered">
									<tbody id="tb_info">
										<?php foreach($rs_dfine as $dfine){?>
											<tr>
												<th width="20%" style="background-color: #eeeeee; align: left;" >ตัวชี้วัด</th>
												<td><?php echo $dfine->ind_name;?></td>
											</tr>
											<tr>
												<th width="20%" style="background-color: #eeeeee;">กลุ่มตัวชี้วัด</th>
												<td><?php echo $dfine->indgp_name;?></td>
											</tr>
											<tr>
												<th width="20%" style="background-color: #eeeeee;">ปีงบประมาณ</th>
												<td><?php echo $dfine->bgy_name;?></td>
											</tr>
											<tr>
												<th width="20%" style="background-color: #eeeeee;">หน่วยงาน</th>
												<td><?php echo $dfine->side_name;?></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div> <!-- End form-group -->
						</form>
						<div class="form-group">
							<a id="btn_add_resm" name="btn-add-tab" class="<?php echo $this->config->item('btn_primary');?> pull-left" href="#" onclick="get_resm('0','0')">
							<i class="glyphicon glyphicon-plus" style="color:white"></i> เพิ่มผู้รับผิดชอบตัวชี้วัด</a>
						</div>
						<div class="form-group"  id="note">
							
						</div>
							<?php //if(count($arr_resm) > 0){?>
								<!--<a id="btn_del_all" name="btn_del_all" class="<?php echo $this->config->item('btn_danger')?> pull-right" onclick="del_all_resm(<?php echo $dfine_id; ?>)">
								<i class="glyphicon glyphicon-remove" style="color:white"></i>&nbsp;ลบผู้รับผิดชอบทั้งหมด</a>-->
							<?php //}else{?>
								<!--<a id="btn_del_all" name="btn_del_all" class="<?php //echo $this->config->item('btn_danger')?> pull-right"  disabled>
								<i class="glyphicon glyphicon-remove" style="color:white"></i>&nbsp;ลบผู้รับผิดชอบทั้งหมด</a>-->
							<?php //}?>
						<br>
                        <table id="" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 5%; text-align: center;">ลำดับ</th>
                                    <th style="width: 25%; text-align: center;">ชื่อ - สกุล</th>
                                    <th style="width: 15%; text-align: center;">ตำแหน่ง</th>
                                    <th style="width: 10%; text-align: center;">ผู้รับผิดชอบร่วม</th>
									<th style="width: 10%; text-align: center;">ดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody id="tb_res">
								
							</tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div><!-- End  col-md-12 -->
				<a type="button" class="btn btn-default pull-left" href="<?php echo site_url('/Define_indicator')?>">ย้อนกลับ</a>
            </div>
        </div>
    </div>
</div>

<!--Modal add resm-->
<div class="modal fade" id="modal_add_resm" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="">
        <div class="modal-content">
            <div class="modal-header modal_header_success">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" data-toggle="modal">&times;</span></button>
                <h3 class="modal-title" id="head_madal_addres" ></h3>
            </div>
            <div class="modal-body">
				<form id="frm_modal_add"> <!-- Start form -->
					<div class="form-group">
						<div class="col-md-3 pull-right" id="div_search">	
							<div class="input-group">
								<input type="text" id="search" class="form-control" placeholder="ค้นหา">
								<span class="input-group-addon">
									<i class="glyphicon glyphicon-search"></i>
								</span>
							</div>
						</div>
					</div><br><br><br>
				
					<div class="form-group" id="tb_data" style="display:block;"> <!-- Start form-group -->
						<table id="tb_modal_res" class="table table-bordered">
							 
						</table>
					</div> <!-- End form-group -->
				</form>
				
				<div class="" id="row_loading_out" style="display:none;">
					<div class="col-md-12">
						<center>
						<img src="<?php echo base_url();?>/images/Loading_icon3.gif" width="40%" height="100%">
						<h4 style="color:red;">ระบบกำลังทำการประมวลผล ... กรุณารอสักครู่... </h4>
						</center>
					</div>
				</div>
            </div>
            <div class="modal-footer" id="md_add_footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ยกเลิก</button>
                <!-- <input type="button" class="btn btn-success" onclick="save()" value="บันทึก"> -->
                <a type="button" class="btn btn-success" onclick="save_resm()" >บันทึก</a> 
				<input type="hidden" id="hid_btn_chk" value="0">
            </div><!--modal-footer-->
        </div>
    </div> <!-- /.modal-content -->
</div> <!-- /.modal-dialog -->

<!--Modal info ress-->
<div class="modal fade" id="modal_info_ress" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="">
        <div class="modal-content">
            <div class="modal-header modal_header_info">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" data-toggle="modal">&times;</span></button>
                <h3 class="modal-title">ผู้รับผิดชอบตัวชี้วัดร่วม</h3>
            </div>
            <div class="modal-body">
				<form id="frm_modal_add"> <!-- Start form -->
					<div class="form-group"> <!-- Start form-group -->
						<!--<a id="btn_del" name="btn_del" class="<?php //echo $this->config->item('btn_danger')?> pull-right" onclick="del_all_ress('.$resm_id.')">
						<i class="glyphicon glyphicon-remove" style="color:white"></i>ลบทั้งหมด</a><br><br>-->
						<table id="tb_modal_info" class="table table-bordered">
						
						</table>
						<input type="hidden" id="hid_modal_info_resm_id" value="">
					</div> <!-- End form-group -->
				</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
				<a id="btn_del" name="btn_del" class="<?php echo $this->config->item('btn_danger')?>" onclick="del_all_ress()">ลบทั้งหมด</a>
                <!-- <input type="button" class="btn btn-success" onclick="save()" value="บันทึก"> -->
                <!-- <button type="submit" class="btn btn-success" onclick="save_indicator()" >บันทึก</button> -->
            </div><!--modal-footer-->
        </div>
    </div> <!-- /.modal-content -->
</div> <!-- /.modal-dialog -->

