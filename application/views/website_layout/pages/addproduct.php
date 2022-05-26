<form method="post" action="<?= base_url(); ?>saveProducts" enctype="multipart/form-data" >
  <p><?=$this->session->flashdata('Message');?></p>
  <div class="form-group">
    <label for="productname">PRODUCT NAME:</label>
    <input type="text" name="productname" class="form-control" id="productname">
    <span style="color: red"><?php echo form_error('productname');?></span>
  </div>
  <div class="form-group">
    <label for="price">PRICE:</label>
    <input type="text" name="price" class="form-control" id="price">
    <span style="color: red"><?php echo form_error('price');?></span>
  </div>
  <div class="form-group">
    <label for="quantity">Quantity:</label>
    <input type="text"  name="quantity" class="form-control" id="quantity">
    <span style="color: red"><?php echo form_error('quantity');?></span>
  </div>
   
   <div class="form-group">
    <label for="productimage">Product Image:</label>
    <input type="file"  name="productimage" class="form-control" id="productimage">
<!--     <span style="color: red"><?php echo form_error('quantity');?></span>
 -->  </div>
 
  <button type="submit" class="btn btn-default">Save</button>
</form>
<br>
<table class="table table-bordered">
    <thead>
      <tr>
      	<th>PRODUCT ID</th>
        <th>PRODUCT NAME</th>
        <th>PRICE</th>
        <th>Quantity</th>
        <th>Image</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    	<?php foreach ($productslist as $key => $value) {
    		# code...
    	?>
      <tr id="tr_<?= $value['productid']; ?>"> 
        <td><?= $value['productid']; ?></td>
        <td><?= $value['productname']; ?></td>
        <td><?= $value['price']; ?></td>
        <td><?= $value['quantity']; ?></td>
        <td><img src="<?= base_url();?>assets/uploads/productimage/<?= $value['imagepath']; ?>" /></td>
        <td>
          
          <button class="btn btn-danger" onclick="deleteRecord(<?= $value['productid']; ?>)">Delete</button>

          <a href="<?= base_url(); ?>EditProducts/<?= $value['productid']; ?>" class="btn btn-info" > Edit </a>

           <!-- http://localhost/ practicle / EditProducts /6
                              0             1           2 -->
          <!-- <a href="<?= base_url(); ?>EditProducts/<?= $value['productid']; ?>" class="btn btn-info">Edit</a> -->

        </td>
      </tr>
      <?php 
      } ?>
    </tbody>
  </table>

<script>
var myurl = "<?=base_url();?>";

function deleteRecord(id)
{
    // var pid = id;    
    $.ajax({
        url: myurl + 'Example_Controller/deleteRecord_fun',
        type: 'POST',
        data: "pid=" + encodeURIComponent(id),
        dataType: "json",
        success: function (data) {
            if (data.success === false) {
              alert(data.message);
            } else {
              $("#tr_"+id).remove();
              alert(data.message);
            }
        }
    });

}
</script>