<form action="/properties/edit/<?= $property['id'] ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <label>Title</label><br>
    <input type="text" name="title" value="<?= esc($property['title']) ?>" required><br>
    
    <label>Location</label><br>
    <input type="text" name="location" value="<?= esc($property['location']) ?>"><br>
    
    <label>Size</label><br>
    <input type="text" name="size" value="<?= esc($property['size']) ?>"><br>
    
    <label>Price</label><br>
    <input type="text" name="price" value="<?= esc($property['price']) ?>"><br>
    
    <label>Rooms</label><br>
    <input type="text" name="rooms" value="<?= esc($property['rooms']) ?>"><br>
    
    <label>Master Bedrooms</label><br>
    <input type="text" name="masterBedrooms" value="<?= esc($property['masterBedrooms']) ?>"><br>
    
    <label>Bedrooms</label><br>
    <input type="text" name="bedrooms" value="<?= esc($property['bedrooms']) ?>"><br>
    
    <label>Bathrooms</label><br>
    <input type="text" name="bathrooms" value="<?= esc($property['bathrooms']) ?>"><br>
    
    <label>Description</label><br>
    <textarea name="description"><?= esc($property['description']) ?></textarea><br>
    
    <label>Facebook Post URL</label><br>
    <input type="text" name="facebookPost" value="<?= esc($property['facebookPost']) ?>"><br>
    
    <label>Current Image</label><br>
    <?php if($property['images']): ?>
        <?php $images = json_decode($property['images']); ?>
        <?php if(is_array($images)): ?>
            <?php foreach($images as $img): ?>
                <img src="<?= $img ?>" style="width:100px;">
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?><br>
    <input type="file" name="images"><br>
    
    <button type="submit">Update Property</button>
</form>
