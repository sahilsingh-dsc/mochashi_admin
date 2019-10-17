<a href="<?php echo base_url();?>admin/support_text_create/" class="btn btn-primary" style="margin-bottom: 20px;">
<i class="fa fa-plus"></i>
Create Support Text
</a>

<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Support Texts</h4>
                <table id="basic-datatable" class="table dt-responsive nowrap" width="100%">
					<thead>
						<tr>
							<th>
								#
							</th>
						<!--	<th></th>-->
							<th>Title</th>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$tip = $this->db->get('support_text')->result_array();
							$counter = 1;
							foreach ($tip as $row):
							  ?>
						<tr>
							<td style="vertical-align: middle;"><?php echo $counter++;?></td>
							<td style="vertical-align: middle;"><?php echo $row['title_text'];?></td>
							<td style="vertical-align: middle;"><?php echo nl2br($row['big_text']);?></td>
							<td style="vertical-align: middle;">
								<a href="<?php echo base_url();?>admin/support_text_edit/<?php echo $row['id'];?>" class="btn btn-info btn-xs btn-mini">
								edit</a>
								<a href="<?php echo base_url();?>admin/support_text_delete/<?php echo $row['id'];?>" class="btn btn-danger btn-xs btn-mini" onclick="return confirm('Want to delete?')">
								delete</a>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
