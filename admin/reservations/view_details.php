<?php 
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT b.*,t.name as `table` FROM `reservation_list` b inner join `table_list` t on b.table_id = t.id where b.id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k)){
                $$k = $v;
            }
        }
    }else{
        echo '<script> alert("Unknown reservation\'s ID."); location.replace("./?page=reservations"); </script>';
    }
}else{
    echo '<script> alert("reservation\'s ID is required to access the page."); location.replace("./?page=reservations"); </script>';
}
?>
<div class="content py-3">
    <div class="card card-outline card-navy rounded-0 shadow">
        <div class="card-header">
            <h4 class="card-title">Reservation Details: <b><?= isset($code) ? $code : "" ?></b></h4>
            <div class="card-tools">
                <a href="./?page=reservations" class="btn btn-default border btn-sm"><i class="fa fa-angle-left"></i> Back to List</a>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row mb-0">
                    <div class="col-3 border border-navy bg-gradient-navy mb-0"><b>Client Name</b></div>
                    <div class="col-9 border mb-0"><?= isset($name) ? $name : '' ?></div>
                    <div class="col-3 border border-navy bg-gradient-navy mb-0"><b>Contact #</b></div>
                    <div class="col-9 border mb-0"><?= isset($contact) ? $contact : '' ?></div>
                    <div class="col-3 border border-navy bg-gradient-navy mb-0"><b>Email</b></div>
                    <div class="col-9 border mb-0"><?= isset($email) ? $email : '' ?></div>
                    <div class="col-3 border border-navy bg-gradient-navy mb-0"><b>Address</b></div>
                    <div class="col-9 border mb-0"><?= isset($address) ? $address : '' ?></div>
                    <div class="col-3 border border-navy bg-gradient-navy mb-0"><b>Table</b></div>
                    <div class="col-9 border mb-0"><?= isset($table) ? $table : '' ?></div>
                    <div class="col-3 border border-navy bg-gradient-navy mb-0"><b>Reservation Schedule</b></div>
                    <div class="col-9 border mb-0"><?= isset($schedule) ? date("M d, Y", strtotime($schedule)) : '' ?></div>
                    <div class="col-3 border border-navy bg-gradient-navy mb-0"><b>Status</b></div>
                    <div class="col-9 border mb-0">
                        <?php 
                        $status = isset($status) ? $status : '';
                        switch($status){
                            case 0:
                                echo '<span class="badge badge-default border px-3 rounded-pill">Pending</span>';
                                break;
                            case 1:
                                echo '<span class="badge badge-primary px-3 rounded-pill">Confirmed</span>';
                                break;
                            case 2:
                                echo '<span class="badge badge-info px-3 rounded-pill">Arrived</span>';
                                break;
                            case 3:
                                echo '<span class="badge badge-warning px-3 rounded-pill">No Show</span>';
                                break;
                            case 4:
                                echo '<span class="badge badge-success px-3 rounded-pill">Done</span>';
                                break;
                            case 5:
                                echo '<span class="badge badge-danger px-3 rounded-pill">Cancelled</span>';
                                break;
                        }
                        ?>
                    </div>
                </div>
                <div class="clear-fix mb-2"></div>
                <div class="text-center">
                    <button class="btn btn-primary bg-gradient-navy border col-3 rounded-pill" id="update_status" type="button"><i class="fa fa-edit"></i> Update Status</button>
                    <button class="btn btn-danger bg-gradient-danger border col-3 rounded-pill" id="delete_reservation" type="button"><i class="fa fa-trash"></i> Delete reservation</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

$(function(){
    $('#update_status').click(function(){
        uni_modal("Update reservation Status", "reservations/update_status.php?id=<?= isset($id) ? $id : '' ?>")
    })
    $('#delete_reservation').click(function(){
        _conf("Are you sure to delete this reservation permanently?","delete_reservation",[])
    })
})
function delete_reservation($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_reservation",
			method:"POST",
			data:{id: '<?= isset($id) ? $id : "" ?>'},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.replace('./?page=reservations');
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>