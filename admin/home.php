<h1>Welcome to <?php echo $_settings->info('name') ?></h1>
<hr>
<div class="row">
        <div class="col-12 col-sm-6 col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-navy elevation-1"><i class="fas fa-car"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Table List</span>
                <span class="info-box-number">
                  <?php 
                    $table = $conn->query("SELECT * FROM table_list where delete_flag = 0")->num_rows;
                    echo format_num($table);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-light border elevation-1"><i class="fas fa-calendar-minus"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Peding Reservation</span>
                <span class="info-box-number">
                  <?php 
                    $total = $conn->query("SELECT * FROM reservation_list where `status` = 0 ")->num_rows;
                    echo format_num($total);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-maroon elevation-1"><i class="fas fa-calendar-day"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Upcoming Customer</span>
                <span class="info-box-number">
                  <?php 
                    $today = $conn->query("SELECT * FROM reservation_list where `status` = 1 and date(`schedule`) = '".date('Y-m-d')."' ")->num_rows;
                    echo format_num($today);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-danger elevation-1"><i class="fas fa-calendar-times"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Cancelled/No Show</span>
                <span class="info-box-number">
                  <?php 
                    $today = $conn->query("SELECT * FROM reservation_list where `status` in (3,5) and date(`schedule`) = '".date('Y-m-d')."' ")->num_rows;
                    echo format_num($today);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
<div class="container">
  <?php 
    $files = array();
      $fopen = scandir(base_app.'uploads/banner');
      foreach($fopen as $fname){
        if(in_array($fname,array('.','..')))
          continue;
        $files[]= validate_image('uploads/banner/'.$fname);
      }
  ?>
  <div id="tourCarousel"  class="carousel slide" data-ride="carousel" data-interval="3000">
      <div class="carousel-inner h-100">
          <?php foreach($files as $k => $img): ?>
          <div class="carousel-item  h-100 <?php echo $k == 0? 'active': '' ?>">
              <img class="d-block w-100  h-100" style="object-fit:contain" src="<?php echo $img ?>" alt="">
          </div>
          <?php endforeach; ?>
      </div>
      <a class="carousel-control-prev" href="#tourCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#tourCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
      </a>
  </div>
</div>
