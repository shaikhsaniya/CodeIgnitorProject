<form method="post" action="<?= base_url(); ?>updateProducts">
  
  <div class="form-group">
    <label for="productname">PRODUCT NAME:</label>
    <input type="text" name="productname" class="form-control" id="productname" value="<?=$productinfo[0]['productname']; ?>">
    <span style="color: red"><?php echo form_error('productname');?></span>
  </div>

  <div class="form-group">
    <label for="price">PRICE:</label>
    <input type="text" name="price" class="form-control" id="price" value="<?=$productinfo[0]['price']; ?>">
    <span style="color: red"><?php echo form_error('price');?></span>
  </div>


  <div class="form-group">
    <label for="quantity">Quantity:</label>
    <input type="text"  name="quantity" class="form-control" id="quantity" value="<?=$productinfo[0]['quantity']; ?>">
    <span style="color: red"><?php echo form_error('quantity');?></span>
  </div>
  
  <div class="form-group">
    <input type="hidden"  name="productid" class="form-control" id="productid" value="<?=$productinfo[0]['productid']; ?>">
  </div>

  <button type="submit" class="btn btn-default">Update</button>

</form>