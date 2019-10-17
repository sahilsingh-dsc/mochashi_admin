<a href="<?php echo base_url();?>admin/coupan_create/" class="btn btn-primary" style="margin-bottom: 20px;">
<i class="fa fa-plus"></i>
Create Coupons
</a>

<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Coupons List</h4>
                <table id="basic-datatable" class="table dt-responsive nowrap" width="100%">
					<thead>
						<tr>
							<th>#</th>
							<th>Coupon Title</th>
							<th>Coupon Code</th>
							<th>Operation</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$actors = $this->db->get('coupans')->result_array();
							$counter = 1;
							foreach ($actors as $row): ?>
						<tr>
							<td style="vertical-align: middle;"><?php echo $counter++;?></td>
							<td style="vertical-align: middle;">
								<a href="javascript:;" style="color: #6c757d;"><?php echo ucfirst($row['title']);?></a>
							</td>
							<td style="vertical-align: middle;">
								<?php echo $row['coupon_code'];?>
							</td>
							<td style="vertical-align: middle;">
								<a href="<?php echo base_url();?>admin/coupan_edit/<?php echo $row['coupan_id'];?>" class="btn btn-info btn-xs btn-mini">Edit</a>
								<a href="<?php echo base_url();?>admin/coupan_delete/<?php echo $row['coupan_id'];?>" class="btn btn-danger btn-xs btn-mini" onclick="return confirm('Want to delete?')">Delete</a>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
