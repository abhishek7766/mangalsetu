<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard
        <small>Control panel</small>
      </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-lg-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php if(isset($noOfMembers)){echo $noOfMembers;}else{echo "0";}?></h3>
                  <p>Total Members</p>
                </div>
                <div class="icon">
                  <i class="ion ion-android-people"></i>
                </div>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php if(isset($noOfEmployees)){echo $noOfEmployees;}else{echo "0";}?></h3>
                  <p>Total Emoloyees</p>
                </div>
                <div class="icon">
                  <i class="ion ion-android-person-add"></i>
                </div>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php if(isset($noOfPMember)){echo $noOfPMember;}else{echo "0";}?></h3>
                  <p>Premium Members</p>
                </div>
                <div class="icon">
                  <i class="ion ion-android-contacts"></i>
                </div>
              </div>
            </div><!-- ./col -->
          </div>
    </section>
</div>