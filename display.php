<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href="assets/css/tabulator.min.css" rel="stylesheet">
    <link href="assets/css/my.css" rel="stylesheet">
    <script type="text/javascript" src="assets/js/tabulator.min.js"></script>
<style>

</style>    
</head>
<?php
    include("config.php");
    $owner = "";
    $device_id = "";
    if(isset($_GET['owner'])){
        $owner = $_GET ["owner"] ;
    } 
    if(isset($_GET['device_id'])){
        $device_id = $_GET ["device_id"] ;	
    }
    $sql = "SELECT * FROM `MESSAGE` ORDER BY id DESC";
    if(!(empty($owner) && empty($device_id))) {
        $sql = "SELECT * FROM `MESSAGE` where `OWNER`='$owner' and `DEVICE_ID`='$device_id' ORDER BY id DESC";
    }
    echo "<!-- $sql -->";
    $result = $connection->query($sql);
?>
<body>
    <h4>Logs</h4> <hr>
    <?php if(!(empty($owner) && empty($device_id))) { ?>
        Owner number: <b> </b><?php echo $owner ?> </b> Device ID :   <b> </b><?php echo $device_id ?> </b> <br>
    <?php } else echo "Displaying all logs. Please specify owner and device ID to display specific logs" ?>
    <hr>
    <form action="" id="loginForm">
        <label for="owner">Enter owner number: </label> <input type="text" name="owner" id="owner"  required> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
        <label for="device_id">Enter device ID : </label> <input type="text" name="device_id" id="device_id"  required>
        <input type="submit" value="Submit">
    </form>
    <?php if ($result->num_rows > 0) { ?>
        <div id="example-table"></div>
    <?php } else echo "<h2>No logs found</h2>" ?>
    
<script>
let loginForm = document.getElementById("loginForm");
if(loginForm.addEventListener){
    loginForm.addEventListener("submit", callback, false);  //Modern browsers
}else if(loginForm.attachEvent){
    loginForm.attachEvent('onsubmit', callback);            //Old IE
}

function callback(e) {
    let owner = document.getElementById("owner").value;
    let device_id = document.getElementById("device_id").value;
    // alert(owner.length + " " + device_id.length);
    if (owner.length != 10 || device_id.length < 8) {
        alert("Error ! Owner must have 10 digits while ID must have minimum 8 digits");
        e.preventDefault();
        return;
    }
    if(!(/^\d+$/.test(owner))) {
        alert("Owner value contains non-digit characters ! \n Must have 10 digits ");
        e.preventDefault();
        return;
    }
    if(!(/^\d+$/.test(device_id))) {
        alert("Device ID value contains non-digit characters !! \n Must have minimum 8 digits ");
        e.preventDefault();
        return;
    }
}

// "ID","OWNER","DEVICE_ID","SPY","TESTING","ACTIVE","BATTERY","MESSAGE","EMULATOR","ADDED_ON"

var tabledata = [ // start of data
    <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { 
                if(!(empty($owner) && empty($device_id))) {
    ?>  
                    { ID:<?php echo $row['ID'] ?>, SPY:<?php echo $row['SPY'] ?>, TESTING:<?php echo $row['TESTING'] ?>, ACTIVE:<?php echo $row['ACTIVE'] ?>, BATTERY:<?php echo $row['BATTERY'] ?>, EMULATOR: <?php echo $row['EMULATOR'] ?>, ADDED_ON:"<?php echo $row['ADDED_ON'] ?>", MESSAGE:"<?php echo $row['MESSAGE'] ?>" },   
    <?php       } else { ?>    
                    { ID:<?php echo $row['ID'] ?>, OWNER:"<?php echo $row['OWNER'] ?>", DEVICE_ID:<?php echo $row['DEVICE_ID'] ?>, SPY:<?php echo $row['SPY'] ?>, TESTING:<?php echo $row['TESTING'] ?>, ACTIVE:<?php echo $row['ACTIVE'] ?>, BATTERY:<?php echo $row['BATTERY'] ?>, EMULATOR: <?php echo $row['EMULATOR'] ?>, ADDED_ON:"<?php echo $row['ADDED_ON'] ?>", MESSAGE:"<?php echo $row['MESSAGE'] ?>" },   
    <?php       }
            }  
        } 
    ?>
]; // end of data

var table = new Tabulator("#example-table", {
    data:tabledata,           //load row data from array
    layout:"fitColumns",      //fit columns to width of table
    responsiveLayout:"hide",  //hide columns that don't fit on the table
    addRowPos:"top",          //when adding a new row, add it to the top of the table
    history:true,             //allow undo and redo actions on the table
    pagination:"local",       //paginate the data
    paginationSize:25,         //allow 7 rows per page of data
    paginationCounter:"rows", //display count of paginated rows in footer
    movableColumns:true,      //allow column order to be changed
    //initialSort:[             //set the initial sort order of the data
    //    {column:"name", dir:"asc"},
    //],
    sortMode: "",
    columnDefaults:{
        tooltip:true,         //show tool tips on cells
    },
    columns:[                 //define the table columns
    <?php if((empty($owner) && empty($device_id))) { ?>
        {title:"OWNER",     field:"OWNER",      width:100   },
        {title:"ID",        field:"DEVICE_ID",  width:130   },
    <?php } ?>    
        {title:"S",         field:"SPY",        width:30, formatter:"tickCross"},  //hozAlign:"center", formatter:"tickCross", sorter:"boolean", editor:false},
        {title:"T",         field:"TESTING",    width:30   },
        {title:"A",         field:"ACTIVE",     width:30   },
        {title:"B",         field:"BATTERY",    width:30   },
        {title:"E",         field:"EMULATOR",   width:30   },
        {title:"ADDED_ON",  field:"ADDED_ON",   width:180   },
        {title:"MESSAGE",   field:"MESSAGE"},
    ],
});
table.clearSort();
</script>

</body>
</html>
