<section class="py-5">
    <div class="container">
        <?php if($_settings->chk_flashdata('success_fix')): ?>
            <div class="alert alert-success">
                <div class="d-flex w-100 align-items-center">
                    <div class="col-11"><?= $_settings->flashdata('success_fix') ?></div>
                    <div class="col-1 text-right">
                        <button class="btn-close" type="button" onclick="$(this).closest('.alert').hide('slow').remove()"></button>
                    </div>
                </div>
            </div>
        <?php endif;?>
        <h2 class="text-center"><b>Reservation Form</b></h2>
        <center>
            <hr class="bg-navy" width="10%" style="height:2px;opacity:1">
        </center>
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
                <div class="card card-default rounded-0 shadow blur">
                    <div class="card-body container-fluid">
                        <form action="" id="reservation-form">
                            <input type="hidden" name="id" value="">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group mb-3">
                                        <label for="name" class="control-label mx-3">Full Name</label>
                                        <input type="text" class="form-control rounded-pill" id="name" name="name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group mb-3">
                                        <label for="contact" class="control-label mx-3">Contact #</label>
                                        <input type="text" class="form-control rounded-pill" id="contact" name="contact">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group mb-3">
                                        <label for="email" class="control-label mx-3">Email</label>
                                        <input type="email" class="form-control rounded-pill" id="email" name="email">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group mb-3">
                                        <label for="address" class="control-label mx-3">Address</label>
                                        <textarea rows="3" class="form-control" id="address" name="address"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group mb-3">
                                        <label for="table_id" class="control-label mx-3">Table</label>
                                        <select class="form-control rounded-pill" id="table_id" name="table_id">
                                            <option value="" selected disabled></option>
                                            <?php 
                                            $tables = $conn->query("SELECT * FROM `table_list` where `status` = 1 and delete_flag = 0 order by abs(`name`) asc");
                                            while($row = $tables->fetch_assoc()):
                                            ?>
                                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    
                                    <div class="form-group mb-3">
                                        <label for="schedule" class="control-label mx-3">Schedule</label>
                                        <input type="datetime-local" class="form-control rounded-pill" id="schedule" name="schedule">
                                    </div>
                                    
                                </div>
                            </div>
                            <hr>
                            <div class="clear-fix py-3"></div>
                            <div class="text-center">
                                <button class="btn btn-primary btn-lg w-50 rounded-pill">Submit Reservation</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(function(){
        $('#table_id').select2({
            width:'100%',
            placeholder:"Please select here",
            containerCssClass :"form-control rounded-pill"
        }).addClass("form-control rounded-pill")
        $('#reservation-form').submit(function(e){
            e.preventDefault()
            var _this = $(this)
            var pop_msg = $('<div>')
            pop_msg.addClass("alert alert-danger rounded-0 err-msg")
            pop_msg.hide()
            $('.err-msg').remove()
            start_loader()
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_reservation",
                method:'POST',
                data:_this.serialize(),
                dataType:'JSON',
                error:err=>{
                    console.log(err)
                    pop_msg.text("An error occurred.")
                    _this.prepend(pop_msg)
                    pop_msg.show()
                    $('html, body').scrollTop(0)
                    end_loader()
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        location.reload()
                    }else if(!!resp.msg){
                        pop_msg.text(resp.msg)
                        _this.prepend(pop_msg)
                        pop_msg.show()
                        $('html, body').scrollTop(0)
                    }else{
                        pop_msg.text("An error occurred.")
                        _this.prepend(pop_msg)
                        pop_msg.show()
                        $('html, body').scrollTop(0)
                    }
                    end_loader()
                }
            })
        })
    })
</script>