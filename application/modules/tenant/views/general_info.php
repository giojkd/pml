<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>
    <div class="panel-body">
        <h2>Booking Info</h2>
        <table class="table table-responsive table-bordered">
            <tr>
                <th>Rent From</th>
                <th>Rent To</th>
                <th>Monthly Payment Date</th>
                <th>Agreement File</th>
            </tr>
            <?php if (!empty($booking_info)) { ?>
                <tr>
                    <td><?php echo date('d F Y', strtotime($booking_info['rent_from'])); ?></td>
                    <td><?php echo date('d F Y', strtotime($booking_info['rent_to'])); ?></td>
                    <td><?php echo $booking_info['payment_date']; ?></td>
                    <td>
                        <?php if ($booking_info['agreement_file']) { ?>
                        <a href="<?php echo base_url_tr('tenant/download_agreement')?>" class="btn btn-primary">Download</a>
                        <?php } else { ?>
                            No files
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>