<form action="/properties/create" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="text" name="title" placeholder="Property Title" required><br>
    <input type="text" name="location" placeholder="Location"><br>
    <input type="text" name="size" placeholder="Size"><br>
    <input type="text" name="price" placeholder="Price"><br>
    <input type="text" name="rooms" placeholder="Rooms"><br>
    <input type="text" name="masterBedrooms" placeholder="Master Bedrooms"><br>
    <input type="text" name="bedrooms" placeholder="Bedrooms"><br>
    <input type="text" name="bathrooms" placeholder="Bathrooms"><br>
    <textarea name="description" placeholder="Description"></textarea><br>
    <input type="text" name="facebookPost" placeholder="Facebook Post URL"><br>
    <input type="file" name="images"><br>
    <button type="submit">Save Property</button>
</form>

