
<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <div class="btn-group margin-bottom-10">
        </div>

        <table class="table table-striped table-bordered table-hover display responsive nowrap" id="tenant_list" width="100%">
            <thead>
                <tr>
                    <th width="30px">ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Apartment</th>
                    <th>Room</th>
                    <th><?php echo lang('action'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tenants as $tenant): ?>
                    <?php $sess_data = $this->session->userdata(); ?>
                    <tr>
                        <td><?php echo $tenant['id']; ?></td>
                        <td><?php echo $tenant['name'].' '.$tenant['family_name']; ?></td>
                        <td><?php echo $tenant['email']; ?></td>
                        <td><?php echo $tenant["phone_no"]; ?></td>
                        <td><?php echo $tenant['address']?></td>
                        <td><?php echo $tenant['room_description']?></td>

                        <td>
                        <?php if ($sess_data['userdata']['user_id'] != $tenant['id']) { ?>
                            <a href="<?php echo base_url_tr() ?>user/delete/<?php echo $tenant['id'] ?>" alt="<?php echo $tenant['name'] ?>" class="btn mini red delete confirm btn-sm"><i class="glyphicon glyphicon-trash"></i></a>
                        <?php } ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function () {
        $('#tenant_list').dataTable({
               responsive: true,
           });
    });

</script>
