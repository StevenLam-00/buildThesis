Start session
Suppress error reporting
Include configuration file

If length of $_SESSION['rsLogin'] is 0:
Redirect to 'index.php'
Else:
Initialize $msg and $error variables

If submit button is set in $_POST:
Retrieve form data from $_POST

Prepare SQL query to insert article details into the database
Bind form data values to placeholders in the SQL query
Execute SQL query

Retrieve last inserted ID from the database
If lastInsertId is not null:
Display "Submit article successfully" message

If myfile input field is set in $_FILES:
Retrieve file details from $_FILES

If file extension is in the allowedExtensions array:
If file size does not exceed 1MB:
Set destination path for the file
Move uploaded file to the destination directory

Prepare SQL query to update article record with file details
Bind file details to placeholders in the SQL query
Execute SQL query to update article record
Else:
Set $error message to "File size should not exceed 1MB"
Delete inserted article record from the database
Else:
Set $error message to "Invalid file type. Only .docx, .pdf, .jpg, .png, .txt files are allowed."
Delete inserted article record from the database
Else:
Set $error message to "File upload is required."
Else:
If query error code is not "00000":
Retrieve error information
Set $error message to "Error inserting data into article table: " + errorInfo[2]
End If
End If