<form id="edit_image_form">
<input type="hidden" id="image_id" value=<?php echo $image_id?>>
<div>
<img src="/uploads/<?php echo $image_name?>">
</div>

<div>
<input type="text" id="image_comments" value="<?php echo $image_comments?>">
</div>

<input type="submit" value="Update Comments"> <input type="button" value="Delete Image" id="delete_image">

</form>