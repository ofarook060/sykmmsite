<form action="/properties/create" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="text" name="title" placeholder="Property Title" required><br>
    <input type="text" name="location" placeholder="Location"><br>
    <input type="text" name="price" placeholder="Price"><br>
    <input type="file" name="property_images[]" multiple><br>
    <textarea name="description" placeholder="Description"></textarea><br>
    <button type="submit">Save Property</button>
</form>

