<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Announcement Management
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-danger deactiveAll" href="#"  title="Deactive"><i class="fa fa-exclamation-circle"></i>Deactive All</a>
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>newAnnouncement"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Announcement List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>announceListing" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($announceRecords))
                    {
                        foreach($announceRecords as $record)
                        {
                    ?>
                    <tr>
                        <td><?php echo $record->title ?></td>
                        <td><?php echo $record->on_date?></td>
                        <td><?php echo $record->from_time ?></td>
                        <td><?php echo $record->to_time ?></td>
                            <?php if($record->active == 1){ ?>
                            <td>Active</td>
                            <?php }else{?>
                            <td>Deactive</td>
                            <?php } ?>
                        <td class="text-center">
                            <a class="btn btn-sm btn-success activeAnnouncement" href="#" data-id="<?php echo $record->id; ?>" title="Active"><i class="fa fa-exclamation-circle"></i></a>
                            <a class="btn btn-sm btn-danger deleteAnnouncement" href="#" data-id="<?php echo $record->id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "userListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
