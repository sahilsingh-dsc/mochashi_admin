<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Newsletter</h4>
				<br>
                <table id="basic-datatable" class="table dt-responsive nowrap" width="100%">
					<thead>
						<tr>
							<th>
								#
							</th>
							<th>Email</th>
							<th>Subscribed On</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$newsletter = $this->db->get('newsletter')->result_array();
						$counter 		=	1;
						foreach ($newsletter as $n):
						?>
							<tr>
								<td><?php echo $counter++;?></td>
								<td><?php echo $n['email'];?></td>
								<td><?php echo date("d M, Y" , strtotime($n['nsubs_on']));?></td>
							</tr>
						<?php $counter++; endforeach;?>
					</tbody>
                </table>
				<hr>
            </div>
        </div>
    </div>
</div>
