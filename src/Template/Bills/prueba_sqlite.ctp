<h1>CONTACT FORM</h1>
 
              <form id="mycontact">
 
                     <fieldset>
 
                           <legend>Your details</legend>
 
                           <ol>
 
                                  <li>
 
                                         <label for="username">Name</label>
 
                                         <input id="username" type="text">
 
                        <input type="hidden" id="id"/>
 
                                  </li>
 
                                  <li>
 
                                         <label for="useremail">Email</label>
 
                                         <input id="useremail" type="text">
 
                                  </li>
 
                           </ol>
 
                     </fieldset>
 
                <button id="btnReset" type=submit>Reset</button>
 
                <button id="submitButton" type="submit">SAVE</button>
 
                <button id="btnUpdate" type=submit>UPDATE</button>
 
                <button id="btnDrop" type=submit>DROP</button>
 
              </form><br />
 
        <div id="results"></div>
<script>
//  Declare SQL Query for SQLite
 
var createStatement = "CREATE TABLE IF NOT EXISTS Contacts (id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT, useremail TEXT)";
 
var selectAllStatement = "SELECT * FROM Contacts";
 
var insertStatement = "INSERT INTO Contacts (username, useremail) VALUES (?, ?)";
 
var updateStatement = "UPDATE Contacts SET username = ?, useremail = ? WHERE id=?";
 
var deleteStatement = "DELETE FROM Contacts WHERE id=?";
 
var dropStatement = "DROP TABLE Contacts";
 
var db = openDatabase("pruebaSqlite", "1.0", "Prueba Sqlite", 20000000);  // Open SQLite Database
 
var dataSet;
 
var dataType;
 
function initDatabase()  // Function Call When Page is ready.
 
{
 
    try {
 
        if (!window.openDatabase)  // Check browser is supported SQLite or not.
 
        {
 
            alert('Databases are not supported in this browser.');
 
        }
 
        else {
 
            createTable();  // If supported then call Function for create table in SQLite
 
        }
 
    }
 
    catch (e) {
 
        if (e == 2) {
 
            // Version number mismatch. 
 
            console.log("Invalid database version.");
 
        } else {
 
            console.log("Unknown error " + e + ".");
 
        }
 
        return;
 
    }
 
}
 
function createTable()  // Function for Create Table in SQLite.
 
{
 
    db.transaction(function (tx) { tx.executeSql(createStatement, [], showRecords, onError); });
 
}
 
function insertRecord() // Get value from Input and insert record . Function Call when Save/Submit Button Click..
 
{
 
        var usernametemp = $('input:text[id=username]').val();
 
        var useremailtemp = $('input:text[id=useremail]').val();
        db.transaction(function (tx) { tx.executeSql(insertStatement, [usernametemp, useremailtemp], loadAndReset, onError); });
 
        //tx.executeSql(SQL Query Statement,[ Parameters ] , Sucess Result Handler Function, Error Result Handler Function );
 
}
 
function deleteRecord(id) // Get id of record . Function Call when Delete Button Click..
 
{
 
    var iddelete = id.toString();
 
    db.transaction(function (tx) { tx.executeSql(deleteStatement, [id], showRecords, onError); alert("Delete Sucessfully"); });
 
    resetForm();
 
}
 
function updateRecord() // Get id of record . Function Call when Delete Button Click..
 
{
 
    var usernameupdate = $('input:text[id=username]').val().toString();
 
    var useremailupdate = $('input:text[id=useremail]').val().toString();
 
    var useridupdate = $("#id").val();
 
    db.transaction(function (tx) { tx.executeSql(updateStatement, [usernameupdate, useremailupdate, Number(useridupdate)], loadAndReset, onError); });
 
}
 
function dropTable() // Function Call when Drop Button Click.. Talbe will be dropped from database.
 
{
 
    db.transaction(function (tx) { tx.executeSql(dropStatement, [], showRecords, onError); });
 
    resetForm();
 
    initDatabase();
 
}
 
function loadRecord(i) // Function for display records which are retrived from database.
 
{
 
    var item = dataSet.item(i);
 
    $("#username").val((item['username']).toString());
 
    $("#useremail").val((item['useremail']).toString());
 
    $("#id").val((item['id']).toString());
 
}
 
function resetForm() // Function for reset form input values.
 
{
 
    $("#username").val("");
 
    $("#useremail").val("");
 
    $("#id").val("");
 
}
 
function loadAndReset() //Function for Load and Reset...
 
{
 
    resetForm();
 
    showRecords()
 
}
 
function onError(tx, error) // Function for Hendeling Error...
 
{
 
    alert(error.message);
 
}
 
function showRecords() // Function For Retrive data from Database Display records as list
 
{
 
    $("#results").html('')
 
    db.transaction(function (tx) {
 
        tx.executeSql(selectAllStatement, [], function (tx, result) {
 
            dataSet = result.rows;
 
            for (var i = 0, item = null; i < dataSet.length; i++) {
 
                item = dataSet.item(i);
 
                var linkeditdelete = '<li>' + item['username'] + ' , ' + item['useremail'] + '    ' + '<a href="#" onclick="loadRecord(' + i + ');">edit</a>' + '    ' +
 
                                            '<a href="#" onclick="deleteRecord(' + item['id'] + ');">delete</a></li>';
 
                $("#results").append(linkeditdelete);
 
            }
 
        });
 
    });
 
}
 
$(document).ready(function () // Call function when page is ready for load..
 
{
    initDatabase();
 
    $("#submitButton").click(insertRecord);  // Register Event Listener when button click.
 
    $("#btnUpdate").click(updateRecord);
 
    $("#btnReset").click(resetForm);
 
    $("#btnDrop").click(dropTable);
 
});    
</script> 

