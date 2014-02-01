<html>
<head>
<title>Upload Form</title>
</head>
<body>

<?php echo $error;?>

<?php echo form_open_multipart('admin/do_upload');?>

<input type="file" name="userfile" size="20" />
<input type="hidden" name="profile_id" value="<?php echo $_GET['profile_id']?>"/>
<br /><br />
Image Comments:<br />
<input type="text" name="image_comments">
<br /><br />

<input type="submit" value="upload" />

</form>

</body>
</html>