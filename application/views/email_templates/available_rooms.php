<!DOCTYPE html>
<html>
    <head>
        
    </head>
    <body>
        
        <h2>List of Available rooms</h2>
        <table border="1">
            <tr>
                <th>Apartment ID</th>
                <th>Room Type</th>
                <th>Room No</th>
            </tr>
            
            <?php foreach($free_rooms as $value) {?>
            <tr>
                <td><?php echo $value["apartment_id"]; ?></td>
                <td><?php echo $value["room_type"]=="1"?"Single":"Double"; ?></td>
                <td><?php echo $value["id"]; ?></td>
            </tr>
            <?php } ?>
        </table>
        
        
        <h2>List of rooms going to be available</h2>
        <table border="1">
            <tr>
                <th>Apartment ID</th>
                <th>Room Type</th>
                <th>Room No</th>
                <th>Expire date</th>
            </tr>
            <?php foreach($rooms_to_expire as $value) {?>
            <tr>
                <td><?php echo $value["appt_id"]; ?></td>
                <td><?php echo $value["room_type"]=="1"?"Single":"Double"; ?></td>
                <td><?php echo $value["id"]; ?></td>
                <td><?php echo mydate(substr($value["rent_to"],0,10),"-"); ?></td>
            </tr>
            <?php } ?>
        </table>
    </body>
</html>