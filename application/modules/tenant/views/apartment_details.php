<div class="panel panel-success">
    <div class="panel-heading clearfix">
        <h2 class="panel-title"><?php echo $title; ?></h2>
    </div>

    <div class="panel-body">
        <h2>Apartment Details</h2>
        <table class="table table-responsive table-bordered">
            <tr>
                <th>ID</th>
                <th>Address</th>
                <th>Owner</th>
                <th>NR.</th>
                <th>Floor</th>
            </tr>
            <?php if(!empty($apartment)){ ?>
            <tr>
                <td><?php echo $apartment['id']; ?></td>
                <td><?php echo $apartment['address']; ?></td>
                <td><?php echo $apartment['owner_details']->name.' '.$apartment['owner_details']->family_name; ?></td>
                <td><?php echo $apartment['nr']; ?></td>
                <td><?php echo $apartment['floor']; ?></td>
            </tr>
            <?php } ?>
        </table>
        <h2>Room Details</h2>
        <table class="table table-responsive table-bordered">
            <tr>
                <th>ID</th>
                <th>Type</th>
            </tr>
            <?php if(!empty($room)){ ?>
            <tr>
                <td><?php echo $room['id']; ?></td>
                <td><?php echo $room['room_type'] == 1 ? 'Single' : 'Double'; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>