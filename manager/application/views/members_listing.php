<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Mambers Management
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Users List</h3>
                    <div class="box-tools">
                        <form class="form-inline" action="<?php echo base_url() ?>memberListing" method="POST" id="searchList">
                            <?php if($this->session->userdata('role') != 3){ ?>
                            <div class="form-group">
                                <label for="emp_list">Select Employee</label>
                                <select id="emp_list" class="form-control" name="emp_id">
                                    <option value="">ALL</option>
                                    <?php foreach ($emp_lists as $emp_list) { ?>
                                    <option value="<?php echo $emp_list['userId'] ?>"><?php echo $emp_list['name']?> </option>
                                    <?php } ?>
                                </select>   
                            </div>
                            <?php }?>
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
                        <th>MemberID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Payment</th>
                        <th>Referal</th>
                        <th>Created On</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($userRecords))
                    {
                        foreach($userRecords as $record)
                        {
                    ?>
                    <tr>
                        <td><?php echo $record->member_id ?></td>
                        <td><?php echo $record->firstname." ".$record->lastname ?></td>
                        <td><?php echo $record->email ?></td>
                        <td><?php echo $record->phone ?></td>
                        <?php if($record->payment_status == 1){ ?>    
                            <td style="font-weight: bolder;color: #2fbd01;">PAIED</td>
                        <?php }else{ ?>
                            <td style="font-weight: bolder;color: #ff0000;">UNPAIED</td>
                        <?php }?>
                        <td><?php echo $record->name ?></td>
                        <td><?php echo date("d-m-Y", strtotime($record->created_on)) ?></td>
                        <td class="text-center">
                            <?php if($record->payment_status == 1){ ?>    
                                <a class="btn btn-sm btn-success" href="<?php echo base_url().'MemberAction/'.$record->member_id.'/0'; ?>" title="Deactivate"><i class="fa fa-star "></i></a>
                            <?php }else{ ?>
                                <a class="btn btn-sm btn-danger" href="<?php echo base_url().'MemberAction/'.$record->member_id.'/1'; ?>" title="Activate"><i class="fa fa-exclamation"></i></a>
                            <?php }?> | 
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'editOldMember/'.$record->member_id; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                            <?php if($role == ROLE_ADMIN){ ?>
                            |<a class="btn btn-sm btn-danger deleteMember" href="#" data-memberId="<?php echo $record->member_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                            <?php } ?>
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
            jQuery("#searchList").attr("action", baseURL + "memberListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
