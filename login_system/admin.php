<?php
// Initialize the session
session_start();
include_once '../db/conf.php';

header('P3P: CP="CAO PSA OUR"');
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) AND $_SESSION["loggedin"] !== true){
    header("Location: login.php");
//    header("Cache-Control: no-cache");
//    header("Pragma: no-cache");
//    header('P3P: CP="CAO PSA OUR"');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="../js/vue.js"></script>


</head>
<body>
<div class="page-header">
    <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome! </h1>
</div>
<a href="../about.php" style="text-decoration:none;color:#000;background-color:#ddd;border:1px solid #ccc;
    padding:8px; float: right">Back to your site</a>
<p>
<!--    <a href="login_system/reset-password.php" class="btn btn-warning">Reset Your Password</a>-->
    <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
</p>

<div id="app">
  <button v-on:click="getTrackData('3')">ShowThat 3 </button>
  <button v-on:click="getTrackData('all')">ShowThat ALL </button>
  <button v-on:click="getTrackData('desc')">Show desc </button>
  <button v-on:click="getTrackData('earliest')">Show earliest </button>
  <button v-on:click="getTrackData('contact')">Show Contact </button>
    <a href="#" id="xx" style="text-decoration:none;color:#000;background-color:#ddd;border:1px solid #ccc;
    padding:8px; float: right;
">Export Table data into Excel</a>
    <table id="dataTable" border='1' width='100%' style='border-collapse: collapse;'>
        <tr>
            <th>Id</th>
            <th>FromWhere</th>
            <th>ToWhere</th>
            <th>TheTime</th>
            <th>Duration</th>

        </tr>

        <tr v-for='track in tracking'>
            <td>{{ track.id }}</td>
            <td>{{ track.FromWhere }}</td>
            <td>{{ track.ToWhere }}</td>
            <td>{{ track.TheTime }}</td>
            <td>{{ track.Duration }}</td>
        </tr>
    </table>
</div>
<hr>

<script>
    const app = new Vue({
        el: "#app",
        data: {
            id: 2,
            FromWhere: '',
            ToWhere: '',
            TheTime: '',
            Duration: '',
            tracking: [],
        },
        mounted: function () {
            console.log('Hello!')
            // this.getTrackData()
        },
        methods: {
            getTrackData: function(key){
                console.log(key);
                axios.post('../api/getdata.php', {
                    command: key
                })
                    .then(function (response) {
                        // console.log(response);
                        app.tracking = response.data;

                    })
                    .catch(function (error) {
                        console.log(error);
                        alert('Bad call')
                    });
            },


            }, //methods end
        }) // const vue end
// function for CSV download from https://jsfiddle.net/mnsinger/65hqxygo/
    function exportTableToCSV($table, filename) {

        var $rows = $table.find('tr:has(td),tr:has(th)'),

            // Temporary delimiter characters unlikely to be typed by keyboard
            // This is to avoid accidentally splitting the actual contents
            tmpColDelim = String.fromCharCode(11), // vertical tab character
            tmpRowDelim = String.fromCharCode(0), // null character

            // actual delimiter characters for CSV format
            colDelim = '","',
            rowDelim = '"\r\n"',

            // Grab text from table into CSV formatted string
            csv = '"' + $rows.map(function (i, row) {
                var $row = $(row), $cols = $row.find('td,th');

                return $cols.map(function (j, col) {
                    var $col = $(col), text = $col.text();

                    return text.replace(/"/g, '""'); // escape double quotes

                }).get().join(tmpColDelim);

            }).get().join(tmpRowDelim)
                .split(tmpRowDelim).join(rowDelim)
                .split(tmpColDelim).join(colDelim) + '"',



            // Data URI
            csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

        console.log(csv);

        if (window.navigator.msSaveBlob) { // IE 10+
            //alert('IE' + csv);
            window.navigator.msSaveOrOpenBlob(new Blob([csv], {type: "text/plain;charset=utf-8;"}), "csvname.csv")
        }
        else {
            $(this).attr({ 'download': filename, 'href': csvData, 'target': '_blank' });
        }
    }

    // This must be a hyperlink
    $("#xx").on('click', function (event) {

        exportTableToCSV.apply(this, [$('#dataTable'), 'trackingData.csv']);

        // IF CSV, don't do event.preventDefault() or return false
        // We actually need this to be a typical hyperlink
    });



</script>

</body>
</html>
<script>

</script>
